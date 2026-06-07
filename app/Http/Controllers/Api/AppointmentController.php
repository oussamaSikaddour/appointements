<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Appointment\CreateRequest;
use App\Http\Resources\AppointmentResource;
use App\Models\{Appointment, Image, ScheduleDay};
use App\Traits\Api\ResponseTrait;
use App\Traits\Common\ModelImageTrait;
use Illuminate\Http\{JsonResponse, Request};
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AppointmentController extends Controller
{
    use ResponseTrait, ModelImageTrait;

    private string $locale;
    private string $localeArAndFrOnly;

    public function __construct()
    {
        $this->localeArAndFrOnly = in_array(app()->getLocale(), ['fr', 'ar']) ? app()->getLocale() : 'fr';
        $this->locale =  app()->getLocale();
    }

    /**
     * 📅 Get schedule days
     */
    public function getScheduleDays(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->input('perPage', 15);

            $query = ScheduleDay::with(['doctor', 'appointmentsLocation.daira', 'schedule'])
                ->whereHas('schedule', fn($q) => $q->where('state', 'published'))
                ->where('specialty_id', $request->specialtyId)
                ->when($request->initiator === 'patient', fn($q) =>
                    $q->whereColumn('available_number', '>', 'confirmed_number')
                )
                ->when($request->filled('doctorId'), fn($q) =>
                    $q->where('doctor_id', $request->doctorId)
                )
                ->when($request->filled('dairaId'), fn($q) =>
                    $q->whereHas('appointmentsLocation', fn($e) =>
                        $e->where('daira_id', $request->dairaId)
                    )
                )
                ->when($request->filled('appointmentsLocationId'), fn($q) =>
                    $q->where('appointments_location_id', $request->appointmentsLocationId)
                )
                ->orderBy($request->input('sortBy', 'day_at'), $request->input('sortDirection', 'asc'))
                ->paginate($perPage)
                ->appends($request->only([
                    'perPage', 'sortBy', 'sortDirection', 'specialtyId', 'doctorId',
                    'dairaId', 'appointmentsLocationId'
                ]));

            $data = $query->getCollection()->transform(function ($day) {
                return [
                    'id' => $day->id,
                    'day_at' => $day->day_at,
                    'specialty_id' => $day->specialty_id,
                    'doctor_id' => $day->doctor?->id,
                    'doctor_name' => $day->doctor?->{"name_{$this->localeArAndFrOnly}"},
                    'appointment_location_id' => $day->appointmentsLocation?->id,
                    'appointments_location' => $day->appointmentsLocation?->{"name_{$this->locale}"},
                    'daira_id' => $day->appointmentsLocation?->daira?->id,
                    'available_number' => $day->available_number,
                    'confirmed_number' => $day->confirmed_number,
                ];
            });

            $query->setCollection($data);

            return $this->responseCollection('schedule_days', $query);
        } catch (\Throwable $e) {
            Log::error('AppointmentController@getScheduleDays', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->responseError(__('forms.common.errors.default'), 500);
        }
    }

    /**
     * 📜 List appointments (optimized)
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $perPage = (int) $request->input('perPage', 15);

            $query = Appointment::with([
                'patient:id,code,tel,birth_date,first_name_fr,last_name_fr,first_name_ar,last_name_ar',
                'doctor:id,name_fr,name_ar',
                'specialty:id,designation_fr,designation_ar,designation_en',
                'appointmentsLocation:id,name_fr,name_ar,name_en,longitude,latitude,tel,daira_id',
                'referralLetter',
            ]);

            $this->applyFilters($query, $request, $this->locale);

            $paginated = $query
                ->orderBy($request->input('sortBy', 'created_at'), $request->input('sortDirection', 'asc'))
                ->paginate($perPage)
                ->appends($request->only([
                    'perPage', 'sortBy', 'sortDirection', 'year', 'month', 'specialtyId',
                    'patientId', 'patientCode', 'patient', 'scheduleDayDate', 'doctorId',
                    'dairaId', 'appointmentsLocationId'
                ]));

            // Queue numbers optimized with SQL window function
            $appointmentIds = $paginated->getCollection()->pluck('id');
            $queueNumbers = DB::table('appointments')
                ->select('id', DB::raw('ROW_NUMBER() OVER(PARTITION BY day_at, doctor_id, appointments_location_id ORDER BY created_at) as queue_number'))
                ->whereIn('id', $appointmentIds)
                ->pluck('queue_number', 'id');

            $paginated->setCollection(
                $paginated->getCollection()->transform(function ($a) use ($queueNumbers) {
                    $patient = $a->patient;
                    $doctor = $a->doctor;
                    $specialty = $a->specialty;
                    $appointmentsLocation = $a->appointmentsLocation;
                    $referral = $a->referralLetter->first();

                    return [
                        'id' => $a->id,
                        'day_at' => $a->day_at,
                        'specialty_id' => $a->specialty_id,
                        'created_at' => $a->created_at,
                        'type' => $a->type,
                        'specialty' => $specialty?->{"designation_{$this->locale}"},
                        'patient_id' => $patient?->id,
                        'patient_code' => $patient?->code,
                        'patient_tel' => $patient?->tel,
                        'patient_birth_date' => $patient?->birth_date,
                        'patient_name' => $patient
                            ? trim($patient->{"last_name_{$this->locale}"} . ' ' . $patient->{"first_name_{$this->locale}"})
                            : null,
                        'doctor_name' => $doctor?->{"name_{$this->locale}"},
                        'longitude' => $appointmentsLocation?->longitude,
                        'latitude' => $appointmentsLocation?->latitude,
                        'appointments_location_tel' => $appointmentsLocation?->tel,
                        'appointments_location' => $appointmentsLocation?->{"name_{$this->locale}"},
                        'referral_letter' => $referral?->url,
                        'queue_number' => $queueNumbers[$a->id] ?? null,
                    ];
                })
            );

            return $this->responseCollection('appointments', $paginated);
        } catch (\Throwable $e) {
            Log::error('AppointmentController@index', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);

            return $this->responseError('appointment', __('forms.common.errors.default'), 'index_failed', 500);
        }
    }

    /**
     * 🆕 Store appointment (concurrency safe)
     */
    public function store(string $lang, CreateRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $appointment = DB::transaction(function () use ($validated, $request) {
                $scheduleDay = ScheduleDay::lockForUpdate()->find($validated['schedule_day_id']);
                if (!$scheduleDay) {
                    throw new \Exception(__('forms.appointment.errors.not_found.schedule_day'));
                }

                $type = $scheduleDay->doctor_id === auth()->id() ? 'follow-up' : 'initial';

                if ($type === 'initial') {
                    if (!$this->checkAppointmentGap($validated['patient_id'], $scheduleDay->day_at, $scheduleDay->specialty_id)) {
                        throw new \Exception(__('forms.appointment.errors.min_gap_days'));
                    }

                    if (!$this->checkMaxOut($scheduleDay)) {
                        throw new \Exception(__('forms.appointment.errors.maxed_out'));
                    }

                    $this->updateScheduleDayAvailability($scheduleDay);
                }

                $data = array_merge($validated, [
                    'day_at' => $scheduleDay->day_at,
                    'specialty_id' => $scheduleDay->specialty_id,
                    'appointments_location_id' => $scheduleDay->appointments_location_id,
                    'doctor_id' => $scheduleDay->doctor_id,
                    'type' => $type,
                ]);

                $appointment = Appointment::create($data);

                if ($request->hasFile('referralLetter')) {
                    $this->uploadAndCreateImage(
                        $request->file('referralLetter'),
                        $appointment->id,
                        Appointment::class,
                        'referral_letter'
                    );
                }

                return $appointment;
            });

            return $this->responseSuccess(
                'appointment', $appointment->id, [
                'message' => __('forms.appointment.responses.add_success'),
                'appointment' => $appointment
            ]);
        } catch (\Throwable $e) {
            Log::error('AppointmentController@store', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $code = $e->getCode() ?: 500;
            return $this->responseError('appointment', $e->getMessage(), 'store_failed', $code);
        }
    }

    /**
     * 👁 Show appointment
     */
    public function show(string $lang, Appointment $appointment): JsonResponse
    {
        try {
            $appointment->loadMissing(['referralLetter', 'patient', 'doctor','appointmentsLocation','specialty']);
            return $this->responseSuccess('appointments', $appointment->id, [
                'appointment' => new AppointmentResource($appointment)
            ]);
        } catch (\Throwable $e) {
            Log::error('AppointmentController@show', [
                'appointment_id' => $appointment->id ?? null,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('appointments', __('forms.common.errors.default'), 'show_failed', 500);
        }
    }




public function printAppointMentPdf(string $lang, Appointment $appointment): JsonResponse
{
    try {
        // 🧭 Load relations
        $appointment->loadMissing([
            'referralLetter',
            'patient',
            'doctor',
            'appointmentsLocation',
            'specialty',
        ]);

        $patient    = $appointment->patient;
        $doctor     = $appointment->doctor;
        $location   = $appointment->appointmentsLocation;
        $specialty  = $appointment->specialty;

        // ⚡ Fast queue number calculation with ROW_NUMBER
        $queueNumber = DB::table('appointments')
            ->select('id', DB::raw('ROW_NUMBER() OVER(
                PARTITION BY day_at, doctor_id, appointments_location_id
                ORDER BY created_at
            ) as queue_number'))
            ->where('day_at', $appointment->day_at)
            ->where('doctor_id', $appointment->doctor_id)
            ->where('appointments_location_id', $appointment->appointments_location_id)
            ->where('id', $appointment->id)
            ->value('queue_number');

        // 🗺️ Data for PDF
        $data = [
            'patient_code'              => $patient->code ?? null,
            'patient_name'              => $patient->localized_full_name ?? 'N/A',
            'day_at'                    => $appointment->day_at,
            'type'                      => $appointment->type ?? null,
            'appointments_location'     => $location?->localized_name ?? 'N/A',
            'appointments_location_tel' => $location?->tel ?? null,
            'doctor_name'               => $doctor->localized_name ?? 'N/A',
            'specialty'                 => $specialty?->localized_designation ?? 'N/A',
            'queue_number'              => $queueNumber,
            'appointment'               => $appointment,
        ];

        $viewName = 'pdfs.' . app()->getLocale() . '.appointment-confirmation';
        $filename = "appointment_{$appointment->id}.pdf";

        return $this->generatePdfAndReturnUrl(
            viewName: $viewName,
            data: $data,
            filename: $filename,
            disk: 'public'
        );

    } catch (\Throwable $e) {
        Log::error('AppointmentController@printAppointMentPdf', [
            'appointment_id' => $appointment->id ?? null,
            'message'        => $e->getMessage(),
            'trace'          => $e->getTraceAsString(),
        ]);

        return $this->responseError(
            field: 'appointments',
            errors: __('forms.common.errors.default'),
            title: 'print_appointment_failed',
            status: 500
        );
    }
}




    /**
     * 🗑 Delete appointment
     */
    public function destroy(string $lang,int $id): JsonResponse
    {
        try {
            $appointment = Appointment::find($id);
            if (!$appointment) {
                return $this->responseError(
                    'appointment',
                    __('api.appointment.errors.not_found.appointment'),
                    'appointment_not_found',
                    404
                );
            }

            $dayAt = Carbon::parse($appointment->day_at);
            if (now()->diffInDays($dayAt, false) < 3) {
                return $this->responseError(
                    'appointment',
                    __('modals.appointment.errors.too_close_to_cancel'),
                    'too_close_to_cancel',
                    422
                );
            }

            DB::transaction(function () use ($appointment) {
                $images = Image::where([
                    ['imageable_id', $appointment->id],
                    ['imageable_type', Appointment::class],
                ])->get();

                if ($images->isNotEmpty()) {
                    $this->deleteImages($images);
                }

                $appointment->scheduleDay?->decrement('confirmed_number');
                $appointment->delete();
            });

            return $this->responseSuccess('appointment', $id, [
                'message' => __('forms.appointment.responses.delete_success'),
            ]);
        } catch (\Throwable $e) {
            Log::error('AppointmentController@destroy', [
                'appointment_id' => $id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return $this->responseError('appointment', __('forms.common.errors.default'), 'delete_failed', 500);
        }
    }

    /**
     * 🧮 Helpers
     */
    protected function checkMaxOut(ScheduleDay $scheduleDay): bool
    {
        return $scheduleDay->confirmed_number < $scheduleDay->available_number;
    }

    protected function updateScheduleDayAvailability(ScheduleDay $scheduleDay): void
    {
        $scheduleDay->increment('confirmed_number');
    }

    protected function checkAppointmentGap(int $patientId, string $newDayAt, int $specialtyId): bool
    {
        $lastAppointment = Appointment::where('patient_id', $patientId)
            ->where('specialty_id', $specialtyId)
            ->latest('day_at')
            ->first();

        if (!$lastAppointment) return true;

        return Carbon::parse($lastAppointment->day_at)->diffInDays(Carbon::parse($newDayAt)) >= 15;
    }

    private function applyFilters($query, Request $request, string $locale): void
    {
        $query
            ->when($request->filled('year'), fn($q) => $q->whereYear('day_at', $request->year))
            ->when($request->filled('month'), fn($q) => $q->whereMonth('day_at', $request->month))
            ->when($request->filled('specialtyId'), fn($q) => $q->where('specialty_id', $request->specialtyId))
            ->when($request->filled('patientId'), fn($q) => $q->where('patient_id', $request->patientId))
            ->when($request->filled('patientCode'), fn($q) =>
                $q->whereHas('patient', fn($p) => $p->where('code', 'like', "%{$request->patientCode}%"))
            )
            ->when($request->filled('patient'), function ($q) use ($request, $locale) {
                $containsArabic = preg_match('/\p{Arabic}/u', $request->patient);
                $first = $containsArabic ? 'first_name_ar' : "first_name_{$locale}";
                $last = $containsArabic ? 'last_name_ar' : "last_name_{$locale}";
                $q->whereHas('patient', fn($p) =>
                    $p->whereRaw("CONCAT($last, ' ', $first) LIKE ?", ["%{$request->patient}%"])
                );
            })
            ->when($request->filled('scheduleDayDate'), fn($q) =>
                $q->whereHas('scheduleDay', fn($s) => $s->whereDate('day_at', $request->scheduleDayDate))
            )
            ->when($request->filled('doctorId'), fn($q) => $q->where('doctor_id', $request->doctorId))
            ->when($request->filled('dairaId'), fn($q) =>
                $q->whereHas('appointmentsLocation', fn($e) => $e->where('daira_id', $request->dairaId))
            )
            ->when($request->filled('appointmentsLocationId'), fn($q) =>
                $q->where('appointments_location_id', $request->appointmentsLocationId)
            );
    }
}
