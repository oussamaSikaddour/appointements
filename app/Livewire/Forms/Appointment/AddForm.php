<?php

namespace App\Livewire\Forms\Appointment;

use App\Models\Appointment;
use App\Models\ScheduleDay;
use App\Traits\Common\ModelImageTrait;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Form;
use Carbon\Carbon;

class AddForm extends Form
{
    use ResponseTrait, ModelImageTrait;

    // --- Properties (form fields) ---
    public ?int $patient_id = null;                   // Patient (medical file) ID
    public ?int $schedule_day_id = null;              // Schedule day ID
    public ?int $appointments_location_id = null;     // Appointment location ID
    public ?int $doctor_id = null;                    // Doctor ID

    public ?ScheduleDay $scheduleDay = null;          // Loaded schedule day
    public string $type = 'initial';                  // "initial" or "follow-up"
    public string $initiator = 'patient';             // "patient" or "doctor"
    public string $status = '';                       // Status ("available", "confirmed", etc.)
    public string $specialty_id = '';                 // Specialty
    public $referral_letter;                          // File input

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        $this->scheduleDay = ScheduleDay::findOrFail($this->schedule_day_id);

        // Determine type based on doctor
        $this->type = $this->scheduleDay->doctor_id === auth()->id()
            ? 'follow-up'
            : 'initial';

        $rules = [
            'patient_id'      => ['required', 'exists:medical_files,id'],
            'schedule_day_id' => ['required', 'exists:schedule_days,id'],
        ];

        // Referral letter required only for initial consultations
        if ($this->type === 'initial') {
            $rules['referral_letter'] = [
                'required',
                'file',
                'mimes:jpeg,png,gif,ico',
                'max:10000'
            ];
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'patient_id.required'      => __("forms.appointment.errors.not_found.patient"),
            'schedule_day_id.required' => __("forms.appointment.errors.not_found.schedule_day"),
        ];
    }

    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('appointment', [
            'patient_id',
            'schedule_day_id',
            'referral_letter'
        ]);
    }

    /**
     * Save appointment.
     */
    public function save(): array
    {
        try {
            $data = $this->validate();

            return DB::transaction(function () use ($data) {
                if ($this->type === 'initial') {
                    $this->checkAppointmentGap(
                        $this->patient_id,
                        $this->scheduleDay->day_at,
                        $this->scheduleDay->specialty_id
                    );
                    $this->checkMaxOut($this->scheduleDay);
                    $this->updateScheduleDayAvailability($this->scheduleDay);
                }

                // Override trusted values from scheduleDay
                $data = array_merge($data, [
                    'day_at'                  => $this->scheduleDay->day_at,
                    'specialty_id'            => $this->scheduleDay->specialty_id,
                    'appointments_location_id'=> $this->scheduleDay->appointments_location_id,
                    'doctor_id'               => $this->scheduleDay->doctor_id,
                ]);

                // Create appointment
                $appointment = Appointment::create($data);

                // Upload referral letter
                if ($this->referral_letter) {
                    $this->uploadImage($appointment);
                }

                return $this->response(true, message: __("forms.appointment.responses.add_success"));
            });

        } catch (ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Appointment creation error: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }

    /**
     * Upload referral letter.
     */
    protected function uploadImage(Appointment $appointment): void
    {
        $this->uploadAndCreateImage(
            $this->referral_letter,
            $appointment->id,
            Appointment::class,
            "referral_letter"
        );
    }

    /**
     * Ensure schedule day has slots left.
     */
    protected function checkMaxOut(ScheduleDay $scheduleDay): void
    {
        if ($scheduleDay->confirmed_number >= $scheduleDay->available_number) {
            throw ValidationException::withMessages([
                'schedule_day_id' => __("forms.appointment.errors.maxed_out")
            ]);
        }
    }

    /**
     * Increment confirmed slots safely.
     */
    protected function updateScheduleDayAvailability(ScheduleDay $scheduleDay): void
    {
        $scheduleDay->confirmed_number++;

        if ($scheduleDay->confirmed_number > $scheduleDay->available_number) {
            throw ValidationException::withMessages([
                'schedule_day_id' => __("forms.appointment.errors.maxed_out")
            ]);
        }

        $scheduleDay->save();
    }

    /**
     * Ensure 15-day gap between appointments of the same specialty.
     */
    protected function checkAppointmentGap(int $patientId, string $newDayAt, int $specialtyId): void
    {
        $lastAppointment = Appointment::where('patient_id', $patientId)
            ->where('specialty_id', $specialtyId)
            ->latest('day_at')
            ->first();

        if ($lastAppointment) {
            $lastDay = Carbon::parse($lastAppointment->day_at);
            $newDay  = Carbon::parse($newDayAt);

            if ($lastDay->diffInDays($newDay) < 15) {
                throw ValidationException::withMessages([
                    'schedule_day_id' => __(
                        "forms.appointment.errors.min_gap_days",
                        [
                            'days' => 15,
                            'date' => $newDay->translatedFormat('d F Y'),
                            'last' => $lastDay->translatedFormat('d F Y'),
                        ]
                    )
                ]);
            }
        }
    }
}
