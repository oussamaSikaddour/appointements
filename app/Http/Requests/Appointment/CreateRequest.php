<?php

namespace App\Http\Requests\Appointment;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare camelCase fields from frontend to snake_case
     */
    protected function prepareForValidation(): void
    {
        $fields = [
            'patient_id'                 => 'patientId',
            'schedule_day_id'            => 'scheduleDayId',
            'type'                       => 'type',
            'referral_letter'            => 'referralLetter',
        ];

        $mergeData = [];
        foreach ($fields as $snake => $camel) {
            if ($this->has($camel)) {
                $mergeData[$snake] = $this->$camel;
            }
        }

        $this->merge($mergeData);
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        $rules = [
            'patient_id'      => ['required', 'exists:medical_files,id'],
            'schedule_day_id' => ['required', 'exists:schedule_days,id'],
            'type'            => ['nullable', Rule::in(['initial', 'follow-up'])],
        ];

        // Referral letter required only if it's an initial appointment
        if ($this->input('type') === 'initial') {
            $rules['referral_letter'] = [
                'required',
                'file',
                'mimes:jpeg,png,gif,ico',
                'max:10000'
            ];
        } else {
            $rules['referral_letter'] = ['nullable', 'file', 'mimes:jpeg,png,gif,ico', 'max:10000'];
        }

        return $rules;
    }

    /**
     * Custom messages
     */
    public function messages(): array
    {
        return [
            'patient_id.required'       => __("forms.appointment.errors.not_found.patient"),
            'schedule_day_id.required'  => __("forms.appointment.errors.not_found.schedule_day"),
            'referral_letter.required'  => __("forms.appointment.errors.referral_required"),
        ];
    }
}
