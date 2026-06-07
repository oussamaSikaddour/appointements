<?php

namespace App\Http\Requests\User;

use App\Http\Requests\ApiFormRequest;
use App\Traits\Api\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;

class PatchRequest extends ApiFormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $nameRules = 'sometimes|string|min:3|max:100';
        $birthPlaceRules = 'sometimes|string|min:3|max:200';
        $addressRules = 'sometimes|string|min:10|max:400';

        return [
            'default.is_paid' => ['sometimes', 'boolean'],
            'default.is_active' => ['sometimes', 'boolean'],
            'personnelInfo.employee_number' => [
                'nullable', 'string', 'size:10',
                Rule::unique('personnel_infos', 'employee_number')
                    ->whereNull('deleted_at')
                    ->ignore($this->input('default.id')),
            ],
            'image' => ['sometimes', 'file', 'mimes:jpeg,png,gif,ico,webp', 'max:10000'],

            // Personnel Info
            'personnelInfo.last_name_fr' => $nameRules,
            'personnelInfo.first_name_fr' => $nameRules,
            'personnelInfo.last_name_ar' => $nameRules,
            'personnelInfo.first_name_ar' => $nameRules,

            'personnelInfo.card_number' => [
                'sometimes', 'string', 'min:6', 'max:255',
                Rule::unique('personnel_infos', 'card_number')
                    ->whereNull('deleted_at')
                    ->ignore($this->input('personnelInfo.user_id'), 'user_id'),
            ],

            'personnelInfo.birth_place_fr' => $birthPlaceRules,
            'personnelInfo.birth_place_ar' => $birthPlaceRules,
            'personnelInfo.birth_place_en' => $birthPlaceRules,

            'personnelInfo.birth_date' => [
                'nullable', 'date', 'date_format:Y-m-d',
                'after:1920-01-01',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            ],

            'personnelInfo.address_fr' => $addressRules,
            'personnelInfo.address_ar' => $addressRules,
            'personnelInfo.address_en' => $addressRules,
             'personnelInfo.phone' => [
                'nullable', 'regex:/^(05|06|07)\d{8}$/',
                Rule::unique('personnel_infos', 'phone')->whereNull('deleted_at')->ignore($this->input('personnelInfo.user_id'), 'user_id'),
            ],
        ];
    }




    protected function prepareForValidation(): void
    {
        $userId = $this->route('user')->id;
        $default = ['id' => $userId];
        $personnelInfo = ['user_id' => $userId];

        // Direct boolean and employee fields
        if ($this->filled('isPaid')) {
            $default['is_paid'] = $this->boolean('isPaid');
        }
        if ($this->filled('isActive')) {
            $default['is_active'] = $this->boolean('isActive');
        }


        // Map camelCase input keys to snake_case db keys
        $fieldMap = [
            'employeeNumber'=>'employee_number',
            'lastNameFr' => 'last_name_fr',
            'lastNameAr' => 'last_name_ar',
            'firstNameFr' => 'first_name_fr',
            'firstNameAr' => 'first_name_ar',
            'cardNumber' => 'card_number',
            'birthDate' => 'birth_date',
            'birthPlaceFr' => 'birth_place_fr',
            'birthPlaceAr' => 'birth_place_ar',
            'birthPlaceEn' => 'birth_place_en',
            'addressFr' => 'address_fr',
            'addressAr' => 'address_ar',
            'addressEn' => 'address_en',
        ];

        foreach ($fieldMap as $inputKey => $attributeKey) {
            if ($this->filled($inputKey)) {
                $personnelInfo[$attributeKey] = $this->input($inputKey);
            }
        }

        // Sanitize and assign phone
        if ($this->filled('phone')) {
            $personnelInfo['phone'] = $this->cleanPhone($this->input('phone'));
        }

        $this->merge([
            'default' => $default,
            'personnelInfo' => $personnelInfo,
        ]);
    }

    /**
     * Clean phone number to remove all non-digit characters.
     */
    protected function cleanPhone(string $value): string
    {
        $clean = preg_replace('/\s+/', '', $value);       // remove all whitespace
    $clean = trim($clean, "\"'");
                      // remove surrounding " or '
$this->responseTest($clean);
    return $clean;
    }

    public function messages(): array
    {
        return [
            'personnelInfo.phone.regex' => __('forms.common.errors.not_match.phone'),
        ];
    }
}
