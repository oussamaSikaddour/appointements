<?php

namespace App\Livewire\Default;

use App\Models\Appointment;
use App\Models\Daira;
use App\Models\Establishment;
use App\Models\FieldSpecialty;
use App\Models\Image;
use App\Models\ScheduleDay;
use App\Models\User;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\ModelImageTrait;
use App\Traits\Common\TableTrait;
use App\Traits\Common\TextAndPdfTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class ConfirmedAppointmentsTable extends Component
{
    use TableTrait, WithFileUploads, TextAndPdfTrait, GeneralTrait,ModelImageTrait;

    public ?int $year = null;
    public ?int $month = null;

    public ?int $patientId = null;
    public ?int $specialtyId = null;
    public ?int $doctorId = null;
    public ?int $dairaId = null;
    public ?int $appointmentsLocationId = null;

    public string $scheduleDayDate = "";
    public string $patient="";
    public string $patientCode="";
    public array $yearsOptions = [];
    public array $monthsOptions = [];
    public array $scheduleDaysOptions = [];
    public array $dairatesOptions = [];
    public array $doctorsOptions = [];
    public array $specialtiesOptions = [];
    public array $appointmentsLocationsOptions = [];
    public array $appointmentTypes = [];
    public bool $isForDoctor=false;


    public string $locale = 'fr';

    protected array $filterable = [
        "patient",
        "patientCode",
        'year',
        'month',
        'scheduleDayDate',
        'patientId',
        'dairaId',
        'doctorId',
        'specialtyId',
        'appointmentsLocationId'
    ];

    protected array $validationRules = [
        'patient' => ['nullable', 'string', 'max:255'],
        'patientCode' => ['nullable', 'string', 'max:20'],
        'year'           => ['nullable', 'integer', 'digits:4', 'between:2023,2050'],
        'month'          => ['nullable', 'integer', 'between:1,12'],
        'scheduleDayDate' => ['nullable', 'date', 'date_format:Y-m-d'],
        'patientId'              => ['nullable', 'exists:medical_files,id'],
        'specialtyId'            => ['nullable', 'exists:field_specialties,id'],
        'doctorId'               => ['nullable', 'exists:users,id'],
        'dairaId'                => ['nullable', 'exists:dairates,id'],
        'appointmentsLocationId' => ['nullable', 'exists:establishments,id'],
    ];

    /**
     * Helpers
     */
    protected function localFrAndArOnly(): string
    {
        return in_array($this->locale, ['fr', 'ar']) ? $this->locale : 'fr';
    }

    protected function translatedColumn(string $base): string
    {
        return $base . '_' . $this->localFrAndArOnly();
    }

    public function resetFilters(): void
    {
        $this->reset(
             "patient",
             "code",
            'year',
            'month',
            'scheduleDayId',
            'patientId',
            'dairaId',
            'doctorId',
            'specialtyId',
            'appointmentsLocationId'
        );
    }

        protected function selectorOptions($items, $valueKey, $labelKey, $placeholder): array
    {
        return $this->populateSelectorOption($items, $valueKey, $labelKey, $placeholder);
    }
    /**
     * Computed Properties
     */
#[Computed]
public function scheduleDays()
{
    return ScheduleDay::query()
        ->when($this->specialtyId, fn($q, $specialtyId) =>
            $q->where('specialty_id', $specialtyId)
        )
        ->when($this->year, fn($q) =>
            $q->whereYear('day_at', $this->year)
        )
        ->when($this->month, fn($q) =>
            $q->whereMonth('day_at', $this->month)
        )
        ->orderBy('day_at', 'desc')
        ->get()
        ->map(fn($item) => $item->day_at->format('Y-m-d'))
        ->unique()
        ->values()
        ->map(fn($date) => [
            'day_at' => $date,
            'date'   => $date, // second key with the same value
        ]);
}

    #[Computed]
    public function specialties()
    {
        return FieldSpecialty::query()
            ->whereHas('field', fn($q) => $q->where('acronym', 'F_MED'))
            ->get(['id', 'designation_' . $this->locale]);
    }

    #[Computed]
    public function doctors()
    {
        return User::query()
            ->whereHas('roles', fn($q) => $q->where('slug', 'doctor'))
            ->whereHas('occupations', fn($q) => $q
                ->where('is_active', true)
                ->when($this->specialtyId, fn($q, $specialtyId) =>
                    $q->where('field_specialty_id', $specialtyId)
                )
            )
            ->get(['id', $this->translatedColumn('name')]);
    }

    #[Computed]
    public function dairates()
    {
        return Daira::query()
            ->whereHas('wilaya', fn($q) => $q->where('code', '13')) // ⚠ hardcoded, maybe make configurable
            ->get(['id', 'designation_' . $this->locale]);
    }

    #[Computed]
    public function appointmentsLocations()
    {
        return Establishment::query()
            ->whereJsonContains('types', 'appointment_locations')
            ->when($this->dairaId, fn($q, $dairaId) =>
                $q->where('daira_id', $dairaId)
            )
            ->get(['id', 'name_' . $this->locale]);
    }

#[Computed]
public function confirmedAppointments()
{

    // Build the patient full-name column once
    $patientFullNameColumn = "CONCAT(
        medical_files.last_name_" . $this->localFrAndArOnly() . ",
        ' ',
        medical_files.first_name_" . $this->localFrAndArOnly() . "
    )";

    return Appointment::query()
        ->join('schedule_days', 'schedule_days.id', '=', 'appointments.schedule_day_id')
        ->leftJoin('medical_files', 'medical_files.id', '=', 'appointments.patient_id')
        ->leftJoin('users', 'users.id', '=', 'appointments.doctor_id')
        ->leftJoin('establishments', 'establishments.id', '=', 'appointments.appointments_location_id')
        ->leftJoin('dairates', 'dairates.id', '=', 'establishments.daira_id')
        ->leftJoin('field_specialties', 'field_specialties.id', '=', 'appointments.specialty_id')
        ->leftJoin('images', function ($join) {
            $join->on('images.imageable_id', '=', 'appointments.id')
                ->where('images.imageable_type', '=', Appointment::class)
                ->where('images.use_case', '=', 'referral_letter');
        })

        // Filters
        ->when($this->year, fn($q) => $q->whereYear('appointments.day_at', $this->year))
        ->when($this->month, fn($q) => $q->whereMonth('appointments.day_at', $this->month))
        ->when($this->specialtyId, fn($q) => $q->where('appointments.specialty_id', $this->specialtyId))
        ->when($this->patientId, fn($q) => $q->where('appointments.patient_id', $this->patientId))
        ->when($this->patientCode, fn($q) => $q->where('medical_files.code', 'like', "%{$this->patientCode}%"))
        ->when(filled($this->patient), fn($q) => $q->whereRaw("{$patientFullNameColumn} LIKE ?", ["%{$this->patient}%"]))
        ->when($this->scheduleDayDate, fn($q) =>
            $q->whereDate('schedule_days.day_at', $this->scheduleDayDate)
        )
        ->when($this->doctorId, fn($q) => $q->where('appointments.doctor_id', $this->doctorId))
        ->when($this->dairaId, fn($q) => $q->where('establishments.daira_id', $this->dairaId))
        ->when($this->appointmentsLocationId, fn($q) => $q->where('appointments.appointments_location_id', $this->appointmentsLocationId))

        // Selected columns including queue number
        ->select([
            'appointments.id',
            'appointments.day_at',
            'appointments.specialty_id',
            'appointments.created_at',
            'appointments.type',
            "field_specialties.designation_{$this->locale} as specialty",
            'medical_files.id as patient_id',
            'medical_files.code as patient_code',
            'medical_files.tel as patient_tel',
            'medical_files.birth_date as patient_birth_date',
            DB::raw("{$patientFullNameColumn} as patient_name"),
            'users.' . $this->translatedColumn('name') . ' as doctor_name',
            'establishments.longitude',
            'establishments.latitude',
            'establishments.tel as appointments_location_tel',
            "establishments.name_{$this->locale} as appointments_location",
            'images.url as referral_letter',
            // ✅ Queue number: resets for each doctor each day
            DB::raw("ROW_NUMBER() OVER (
                  PARTITION BY appointments.day_at, appointments.doctor_id, appointments.appointments_location_id
                  ORDER BY appointments.created_at ASC
                ) as queue_number")
         ])
        ->orderBy($this->sortBy, $this->sortDirection)
        ->get();
}


    /**
     * Lifecycle
     */
    public function mount(): void
    {

     $this->year = now()->year;   // or Carbon::now()->year
    $this->month = now()->month; // or Carbon::now()->month
        $this->sortBy="queue_number";
        $this->locale = app()->getLocale();

        $this->yearsOptions = config('constants.YEARS', []);
        $this->monthsOptions = config('constants.MONTHS_OPTIONS')[$this->locale] ?? [];
        $this->appointmentTypes = config('constants.APPOINTMENT_TYPES')[$this->locale] ?? [];

        // preload options
        $this->refreshOptions();
    }

    public function updated($property): void
    {
        if ($property === 'specialtyId') {
            $this->doctorsOptions = $this->selectorOptions(
                $this->doctors(), 'id', $this->translatedColumn('name'), __('selectors.default.doctors')
            );

            if(count($this->doctorsOptions)==1){
                $this->doctorId=null;
            }
            $this->scheduleDaysOptions = $this->selectorOptions(
                $this->scheduleDays(), 'day_at' ,'day_at', __('selectors.default.appointments_dates')
            );

            if(count($this->scheduleDaysOptions)==1){
                $this->scheduleDayDate="";
            }
        }

        if ($property === 'dairaId') {
            $this->appointmentsLocationsOptions = $this->selectorOptions(
                $this->appointmentsLocations(), 'id', 'name_' . $this->locale, __('selectors.default.appointments_locations')
            );
            if(count($this->appointmentsLocationsOptions)==1){
                $this->appointmentsLocationId=null;
            }
        }
        if ($property === 'year' || $property ==="month") {
            $this->scheduleDaysOptions = $this->selectorOptions($this->scheduleDays(), 'day_at' ,'day_at', __('selectors.default.appointments_dates'));
            if(count($this->scheduleDaysOptions)==1){
                $this->scheduleDayDate="";
            }

        }

        if (array_key_exists($property, $this->validationRules)) {
            try {
                $this->validateOnly($property, $this->validationRules);
            } catch (ValidationException $e) {
                $this->dispatch('open-errors', $e->validator->errors()->all());
            }
        }
    }

    protected function refreshOptions(): void
    {
        $this->scheduleDaysOptions = $this->selectorOptions($this->scheduleDays(), 'day_at' ,'day_at', __('selectors.default.appointments_dates'));
        $this->dairatesOptions = $this->selectorOptions($this->dairates(), 'id', 'designation_' . $this->locale, __('selectors.default.dairates'));
        $this->appointmentsLocationsOptions = $this->selectorOptions($this->appointmentsLocations(), 'id', 'name_' . $this->locale, __('selectors.default.appointments_locations'));
        $this->specialtiesOptions = $this->selectorOptions($this->specialties(), 'id', 'designation_' . $this->locale, __('selectors.default.field_specialties'));
        $this->doctorsOptions = $this->selectorOptions($this->doctors(), 'id', $this->translatedColumn('name'), __('selectors.default.doctors'));
    }


    public function openAppointmentCancellingDialog(array $appointment): void
    {
        $this->dispatch('open-dialog', [
            'question'   => __('dialogs.title.cancel-appointment'),
            'details'    => ['cancel-appointment', $appointment['day_at']],
            'actionEvent'=> [
                'event'      => 'cancel-appointment',
                'parameters' => $appointment['id'],
            ],
        ]);
    }
    /**
     * Events
     */
#[On('cancel-appointment')]
public function cancelAppointment(Appointment $appointment): void
{
    try {
      $dayAt = Carbon::createFromFormat('Y-m-d', $appointment->day_at);

        // Check: is the appointment less than 3 days away?
        if (now()->diffInDays($dayAt, false) < 3) {
            $this->dispatch('open-errors', __('modals.appointment.errors.too_close_to_cancel'));
            return;
        }

        $images = Image::where([
            ['imageable_id', $appointment->id],
            ['imageable_type', Appointment::class],
        ])->get();

        if ($images->isNotEmpty()) {
            $this->deleteImages($images);
        }

        if ($appointment->scheduleDay) {
            $appointment->scheduleDay->decrement('confirmed_number');
        }

        // Rule 4: Delete the appointment
        $appointment->delete();

        // Success feedback
        $this->dispatch('appointment-cancelled', __('appointments.success.cancelled'));

    } catch (\Exception $e) {
        Log::error('Error deleting appointment: ' . $e->getMessage());
        $this->dispatch('open-errors', __('forms.common.errors.default'));
    }
}


    /**
     * Export Helpers
     */
public function generateAppointmentsExcel()
{
    // Use filter date if set, otherwise today
    $datePart = $this->scheduleDayDate
        ? Carbon::parse($this->scheduleDayDate)->format('Y-m-d')
        : now()->format('Y-m-d');

    // Start building file name
    $fileName = "listeAttente_{$datePart}";

    // Add specialty acronym if specialtyId is set
    if ($this->specialtyId) {
        $specialty = FieldSpecialty::find($this->specialtyId);
        if ($specialty && $specialty->acronym) {
            $fileName .= "_" . Str::slug($specialty->acronym, '_');
        }
    }

    // Add doctor name if doctorId is set
    if ($this->doctorId) {
        $doctor = User::find($this->doctorId);
        if ($doctor && $doctor->name_fr) {
            $fileName .= "_" . Str::slug($doctor->name_fr, '_');
        }
    }

    // Get appointments ordered by queue_number
    $appointments = $this->confirmedAppointments()
        ->sortBy('queue_number'); // ensure proper order

    return $this->generateExcel(
        fn() => $appointments->map(fn($appointment) => [
            __("tables.confirmed_appointments.queue_number") => $appointment->queue_number,
            __("tables.confirmed_appointments.patient_code") => $appointment->patient_code ?? '',
            __("tables.confirmed_appointments.patient") => $appointment->patient_name ?? '',
            __("tables.confirmed_appointments.patient_birth_date") => $appointment->patient_birth_date ?? '',
            __("tables.confirmed_appointments.patient_tel") => $appointment->patient_tel ?? '',
            __("tables.confirmed_appointments.type")         => $this->appointmentTypes[$appointment->type] ?? '',
            __("tables.confirmed_appointments.doctor")       => $appointment->doctor_name ?? '',
            __("tables.confirmed_appointments.specialty")    => $appointment->specialty ?? '',
            __("tables.confirmed_appointments.date")       => $appointment->day_at,
        ])->toArray(),
        $fileName
    );
}


public function openGoogleMap(?float $latitude, ?float $longitude): void
{
    if ($latitude === null || $longitude === null) {
        $this->dispatch('open-errors', __('forms.common.errors.missing_coordinates'));
        return;
    }

    $url = sprintf(
        "https://www.google.com/maps/search/?api=1&query=%f,%f",
        $latitude,
        $longitude
    );

    $this->dispatch('open-google-map', $url);
}


    public function generateAppointmentConfirmationPdf($appointment)
    {

        try {
            return $this->generateAndDownloadPdf(
                "pdfs.{$this->locale}.appointment-confirmation",
                $appointment,
                'confirmation.pdf'
            );
        } catch (\Exception $e) {
            Log::error('Error in generateAppointmentConfirmationPdf: ' . $e->getMessage());
            $this->dispatch('open-errors', $e->getMessage());
            return null;
        }
    }

    public function render()
    {
        return view('livewire.default.confirmed-appointments-table');
    }
}
