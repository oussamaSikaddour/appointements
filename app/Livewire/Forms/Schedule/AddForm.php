<?php

namespace App\Livewire\Forms\Schedule;

use App\Models\Schedule;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait;

    // --- Properties ---
    public string $name_fr = '';
    public string $name_ar = '';
    public string $name_en = '';
    public ?string $description_fr = null;
    public ?string $description_ar = null;
    public ?string $description_en = null;
    // public ?string $state = null; // published | not_published | null
    public ?int $month = null;
    public ?int $year = null;
    public ?int $service_id = null;
    public ?int $opened_by = null;

    // --- Rules ---
    public function rules(): array
    {
        $localizedNameRules = [
            'required',
            'string',
            'min:5',
            'max:255',
            Rule::unique('schedules')
                ->where(fn($query) => $query->where('year', $this->year))
                ->whereNull('deleted_at'),
        ];

        $localizedDescriptionRules = [
            'nullable',
            'string',
            'min:5',
            'max:255',
        ];

        return [
            'name_ar'        => $localizedNameRules,
            'name_fr'        => $localizedNameRules,
            'name_en'        => $localizedNameRules,
            'description_fr' => $localizedDescriptionRules,
            'description_ar' => $localizedDescriptionRules,
            'description_en' => $localizedDescriptionRules,
            'year'           => ['required', 'integer', 'digits:4', 'between:2023,2050'],
            'month'          => ['required', 'integer', 'between:1,12'],
            // 'state'          => ['nullable', Rule::in(['published', 'not_published'])],
            'opened_by'      => ['required', 'exists:users,id'],
            'service_id'     => ['required', 'exists:services,id'],
        ];
    }

    // --- Custom messages ---
    public function messages(): array
    {
        return [
            'opened_by.required'  => __("forms.schedule.errors.not_found.creator"),
            'service_id.required' => __("forms.schedule.errors.not_found.service"),
        ];
    }

    // --- Translatable attributes ---
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('schedule', [
            'year',
            'month',
            'name_fr',
            'name_ar',
            'name_en',
            'description_fr',
            'description_ar',
            'description_en',
            // 'state',
            'service_id',
            'opened_by',
        ]);
    }

    // --- Save ---
    public function save()
    {
        try {
            $data = $this->validate();

            Schedule::create($data);

            return $this->response(true, message: __("forms.schedule.responses.add_success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Throwable $e) {
            Log::error('Error in schedule AddForm save method', [
                'message' => $e->getMessage(),
                'trace'   => $e->getTraceAsString(),
            ]);
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
