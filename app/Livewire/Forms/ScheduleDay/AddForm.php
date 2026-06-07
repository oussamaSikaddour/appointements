<?php

namespace App\Livewire\Forms\ScheduleDay;

use App\Models\ScheduleDay;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddForm extends Form
{

    use ResponseTrait;

    // --- Properties ---
    public string $day_at = '';
    public ?int $schedule_id = null;
    public ?int $specialty_id = null;
    public ?int $doctor_id = null;
    public ?int $appointments_location_id = null;
    public ?int $available_number = null;


    // --- Rules ---
    public function rules(): array
    {
         $now = now()->toDateString();

        return [
            'available_number'          => ['required', 'integer', 'between:1,50'],
            'schedule_id'      => ['required', 'exists:schedules,id'],
            'doctor_id'      => ['required', 'exists:users,id'],
            'day_at' => [
                      'required',
                      'date',
                      "after:$now",
                       Rule::unique('schedule_days', 'day_at')
                      ->where(fn ($q) => $q
                      ->where('schedule_id', $this->schedule_id)
                    ->where('doctor_id', $this->doctor_id)
                       ),
                ],
            'appointments_location_id'     => ['required', 'exists:establishments,id'],
            'specialty_id'     => ['required', 'exists:field_specialties,id'],
        ];
    }

    // --- Custom messages ---
    public function messages(): array
    {
        return [
            'schedule_id.required' => __("forms.schedule.errors.not_found.schedule"),
            'specialty_id.required' => __("forms.schedule.errors.not_found.specialty"),
        ];
    }

    // --- Translatable attributes ---
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('schedule_day', [
            'day_at',
             'doctor_id',
             'available_number',
             'appointments_location_id',
             'specialty_id'
        ]);
    }

    // --- Save ---
    public function save()
    {
        try {
            $data = $this->validate();

            ScheduleDay::create($data);

            return $this->response(true, message: __("forms.schedule_day.responses.add_success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Throwable $e) {
            Log::error('Error in scheduleDay AddForm save method', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
