<?php

namespace App\Livewire\Forms\Socials;

use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ManageForm extends Form
{
    use ResponseTrait;

public $id;
public $youtube;
public $facebook;
public $instagram;
public $github;
public $linkedin;
public $tiktok;



    // Livewire rules
    public function rules()
    {

        return [
            'youtube' => [
                'nullable',
                'url',
                Rule::unique('socials','youtube')->ignore($this->id),
            ],
            'facebook' => [
                'nullable',
                'url',
                Rule::unique('socials','facebook')->ignore($this->id),
            ],
            'instagram' => [
                'nullable',
                'url',
                Rule::unique('socials','instagram')->ignore($this->id),
            ],
            'github' => [
                'nullable',
                'url',
                Rule::unique('socials','github')->ignore($this->id),
            ],
            'linkedin' => [
                'nullable',
                'url',
                Rule::unique('socials','linkedin')->ignore($this->id),
            ],
            'tiktok' => [
                'nullable',
                'url',
                Rule::unique('socials','tiktok')->ignore($this->id),
            ],

        ];


    }

    public function validationAttributes()
    {
        return [
        'youtube' =>  __("forms.socials.youtube"),
        'facebook' =>  __("forms.socials.facebook"),
        'github' =>  __("forms.socials.github"),
        'linkedin' =>  __("forms.socials.linkedin"),
        'instagram' =>  __("forms.socials.instagram"),
        'tiktok' =>  __("forms.socials.tiktok"),
        ];
    }




    public function save($gSetting)
    {
                // Validate the form data
                try {
                    $data = $this->validate();
            $gSetting->update($data);
            return $this->response(true,message:__("forms.socials.responses.success"));

    }  catch (\Illuminate\Validation\ValidationException $e) {
        // Return all validation errors
        return $this->response(false, errors: $e->validator->errors()->all());
    }
    catch (\Exception $e) {
        Log::error('ChangeMail form error: ' . $e->getMessage());
        return $this->response(false, errors: __('forms.common.errors.default'));
    }
}

}
