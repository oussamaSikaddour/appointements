<?php

namespace App\Http\Requests\MedicalFile;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;

class CreateRequest extends ApiFormRequest
{
    public function authorize(): bool
    {
        return true;
    }

protected function prepareForValidation(): void
{
    $fields = [
        'last_name_fr'      => 'lastNameFr',
        'first_name_fr'     => 'firstNameFr',
        'last_name_ar'      => 'lastNameAr',
        'first_name_ar'     => 'firstNameAr',
        'birth_place_fr'    => 'birthPlaceFr',
        'birth_place_ar'    => 'birthPlaceAr',
        'birth_place_en'    => 'birthPlaceEn',
        'birth_date'        => 'birthDate',
        'address_fr'        => 'addressFr',
        'address_ar'        => 'addressAr',
        'address_en'        => 'addressEn',
        'tel'               => 'tel',
        'opened_by'         => 'openedBy',
        'insurance_number'  => 'insuranceNumber',
        'gender'            => 'gender',
    ];

    $mergeData = [];
    foreach ($fields as $snake => $camel) {
        if ($this->has($camel)) {
            $mergeData[$snake] = $this->$camel;
        }
    }

    $this->merge($mergeData);
}



    public function rules(): array
    {
        $localizedNameRules = ['required', 'string', 'min:3', 'max:100'];
        $localizedAddressRules = ['nullable', 'string', 'min:5', 'max:255'];
        $localizedBirthPlaceRules = ['nullable', 'string', 'min:5', 'max:100'];

        return [
            'last_name_ar'      => $localizedNameRules,
            'last_name_fr'      => $localizedNameRules,
            'first_name_fr'     => $localizedNameRules,
            'first_name_ar'     => $localizedNameRules,
            'opened_by'         => ['required', 'exists:users,id'],
            'gender'            => ['required', Rule::in(['male', 'female', 'other'])],
            'insurance_number'  => [
                'nullable',
                'string',
                'size:20',
                Rule::unique('medical_files')->whereNull('deleted_at'),
            ],
            'birth_place_fr'    => $localizedBirthPlaceRules,
            'birth_place_ar'    => $localizedBirthPlaceRules,
            'birth_place_en'    => $localizedBirthPlaceRules,
            'birth_date'        => ['required', 'date', 'date_format:Y-m-d', 'after:1920-01-01', 'before:today'],
            'address_fr'        => $localizedAddressRules,
            'address_ar'        => $localizedAddressRules,
            'address_en'        => $localizedAddressRules,
            'tel'               => [
                'required',
                'regex:/^(05|06|07)\d{8}$/',
                Rule::unique('medical_files', 'tel')->whereNull('deleted_at'),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'tel.regex' => __("forms.common.errors.not_match.phone"),
        ];
    }
}
