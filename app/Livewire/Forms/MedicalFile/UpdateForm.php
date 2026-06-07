<?php

namespace App\Livewire\Forms\MedicalFile;

use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateForm extends Form
{

    use ResponseTrait;
    public $id;
    public $last_name_fr;
    public $first_name_fr;
    public $last_name_ar;
    public $first_name_ar;
    public $gender;
    public $code;
    public $birth_place_fr;
    public $birth_place_ar;
    public $birth_place_en;
    public $birth_date;
    public $address_fr;
    public $address_ar;
    public $address_en;
    public $tel;
    public $opened_by;
    public $insurance_number;

    public function rules()
    {
        $localizedNameRules = [
            'required',
            'string',
            'min:3',
            'max:100',
        ];

        $localizedAddressRules = [
            'nullable',
            'string',
            'min:5',
            'max:255',
        ];

        $localizedBirthPlaceRules = [
            'nullable',
            'string',
            'min:5',
            'max:100',
        ];

        return [
            'last_name_ar' => $localizedNameRules,
            'last_name_fr' => $localizedNameRules,
            'first_name_fr' => $localizedNameRules,
            'first_name_ar' => $localizedNameRules,
            'opened_by' => ['required', 'exists:users,id'],
            'gender' => ['required', Rule::in(['male', 'female', 'other'])],
            'insurance_number' => [
                'nullable',
                'string',
                'size:20',
                Rule::unique('medical_files')->ignore($this->id)->whereNull('deleted_at'),
            ],
            "birth_place_fr" => $localizedBirthPlaceRules,
            "birth_place_ar" => $localizedBirthPlaceRules,
            "birth_place_en" => $localizedBirthPlaceRules,
            'birth_date' => [
                'required', 'date', 'date_format:Y-m-d',
                'after:1920-01-01',
                'before:today',
            ],
            "address_fr" => $localizedAddressRules,
            "address_ar" => $localizedAddressRules,
            "address_en" => $localizedAddressRules,
            'tel' => [
                'required',
                'regex:/^(05|06|07)\d{8}$/',
                Rule::unique('medical_files', 'tel')
                ->ignore($this->opened_by, 'opened_by')
                ->whereNull('deleted_at'),
            ],
        ];
    }

    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('medical_file', [
            "last_name_fr",
            "first_name_fr",
            "last_name_ar",
            "first_name_ar",
            'gender',
            "code",
            "email",
            "birth_place_fr",
            "birth_place_ar",
            "birth_place_en",
            "birth_date",
            "address_fr",
            "address_ar",
            "address_en",
            "tel",
            "opened_by",
            "insurance_number",
        ]);
    }

    public function messages(): array
    {
        return [
            'tel.regex' => __("forms.common.errors.not_match.phone"),
        ];
    }

    public function save($medicalFile)
    {
        try {
            $data = $this->validate();
            $medicalFile->update($data);
            return $this->response(true, message: __("forms.medical_file.responses.update_success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Error in MedicalFile AddForm save method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }

}
