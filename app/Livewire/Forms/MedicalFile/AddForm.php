<?php

namespace App\Livewire\Forms\MedicalFile;

use App\Traits\Web\ResponseTrait;
use Illuminate\Validation\Rule;
use Livewire\Form;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\MedicalFile; // Assuming this is your model

class AddForm extends Form
{
    use ResponseTrait;

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
                Rule::unique('medical_files')->whereNull('deleted_at'),
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
                    ->ignore($this->opened_by, 'opened_by') // ignore by column "opened_by"
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

    public function save()
    {
        try {
            $data = $this->validate();

            // Generate the unique code before saving
            $data['code'] = $this->createMedicalFileCode();
            MedicalFile::create($data);
            return $this->response(true, message: __("forms.medical_file.responses.add_success"));
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

    public function createMedicalFileCode()
    {
        // Map gender
        $genderMap = [
            'male' => 'M',
            'female' => 'F',
            'other' => 'O',
        ];

        $genderCode = $genderMap[strtolower($this->gender)] ?? 'O';

        // Year (last two digits) & Month (2 digits)
        $year = now()->format('y');
        $month = now()->format('m');

        // Get last medical file created in the same year + month
        $lastFile = MedicalFile::whereYear('created_at', now()->year)
            ->whereMonth('created_at', now()->month)
            ->orderByDesc('id')
            ->first();

        if ($lastFile && !empty($lastFile->code)) {
            // Extract the last 6 digits number part
            $lastNumber = (int) substr($lastFile->code, -6);
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }

        // Pad number to 6 digits
        $numberPart = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        // Build the code
        return $genderCode . $year . $month . $numberPart;
    }
}
