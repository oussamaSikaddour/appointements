<?php

namespace App\Livewire\Forms\GeneralInfos;

use App\Models\GeneralSetting;
use App\Traits\Common\ModelImageTrait;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ManageForm extends Form
{
    use ResponseTrait,ModelImageTrait;

public $id;
public $phone;
public $landline;
public $fax;
public $email;
public $map;
public $logo;



    // Livewire rules
    public function rules()
    {

        return [
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('general_settings','email')->whereNull('deleted_at')->ignore($this->id),
            ],
            'map' => 'nullable|string',
            'phone' => [
                'nullable',
                'regex:/^(05|06|07)\d{8}$/',
                  Rule::unique('general_settings','phone')->whereNull('deleted_at')->ignore($this->id)
            ],
            'landline' => [
                'nullable',
                'regex:/^(0)\d{8}$/',
                  Rule::unique('general_settings','landline')->whereNull('deleted_at')->ignore($this->id)
            ],
            'fax' => [
                'nullable',
                'regex:/^(0)\d{8}$/',
                  Rule::unique('general_settings','landline')->whereNull('deleted_at')->ignore($this->id)
            ],

           'logo' => 'nullable|file|mimes:jpeg,jpg,png,gif,ico,webp|max:10000',

        ];


    }

    public function validationAttributes()
    {
        return [
        'email' =>  __("forms.general_infos.email"),
        'logo'=>__("forms.general_infos.logo"),
        'phone'=>__("forms.general_infos.phone"),
        'landline'=>__("forms.general_infos.landline"),
        'fax'=>__("forms.general_infos.fax"),
        'map'=>__("forms.general_infos.map"),
        ];
    }


    public function messages(): array
    {

        $validationAttributes = $this->validationAttributes();
        return [
            'phone.regex' => __("forms.common.not_match.phone", ['attribute' => $validationAttributes['phone']]),
            'landline.regex' => __('forms.common.not_match.land_line',['attribute'=>$validationAttributes['landline']]),
            'fax.regex' => __('forms.common.not_match.land_line',['attribute'=>$validationAttributes['fax']]),
        ];
    }

    public function save($gSetting)
    {
            // Validate the form data
            try {
                $data = $this->validate();

              return DB::transaction(function () use ($data, $gSetting) {
            $logo = $this->logo;
            if ($logo) {
                $this->uploadAndUpdateImage($logo, $gSetting->id,  GeneralSetting::class, "logo");
            }
            $gSetting->update($data);
            return $this->response(true,message:__("forms.general_infos.responses.success"));
        });
    } catch (\Illuminate\Validation\ValidationException $e) {
        return $this->response(false, errors: $e->validator->errors()->all());
    }catch (\Exception $e) {
        Log::error('manage GeneralInfo form error: ' . $e->getMessage());
        return $this->response(false, errors: __('forms.common.errors.default'));
    }
    }

}
