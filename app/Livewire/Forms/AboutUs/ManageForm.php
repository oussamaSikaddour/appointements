<?php

namespace App\Livewire\Forms\AboutUs;

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
public $title_ar;
public $title_fr;
public $title_en;
public $description_fr;
public $description_ar;
public $description_en;
public $image;



    // Livewire rules
    public function rules()
    {

        return [
            'title_fr' => [
                'required',
                'string',
                'min:5',
                'max:100',
                Rule::unique('about_us','title_fr')->ignore($this->id),
            ],
            'title_ar' => [
                'required',
                'string',
                'min:5',
                'max:100',
                Rule::unique('about_us','title_ar')->ignore($this->id),
            ],
            'title_en' => [
                'required',
                'string',
                'min:5',
                'max:100',
                Rule::unique('about_us','title_en')->ignore($this->id),
            ],
            'description_ar' => [
                'required',
                'string',
            ],
            'description_fr' => [
                'required',
                'string',
            ],
            'description_en' => [
                'required',
                'string',
            ],

           'image' => 'nullable|file|mimes:jpeg,jpg,png,gif,ico,webp|max:10000',

        ];


    }

    public function validationAttributes()
    {
        return [
        'image'=>__("forms.manage_about_us.image"),
        'title_ar'=>__("forms.manage_about_us.title_ar"),
        'title_fr'=>__("forms.manage_about_us.title_fr"),
        'title_en'=>__("forms.manage_about_us.title_en"),
        'description_fr'=>__("forms.manage_about_us.description_fr"),
        'description_ar'=>__("forms.manage_about_us.description_ar"),
        'description_en'=>__("forms.manage_about_us.description_en"),
        ];
    }




    public function save($aUs)
    {
            // Validate the form data
            try {
                $data = $this->validate();
              return DB::transaction(function () use ($data, $aUs) {
            $image = $this->image;
            if ($image) {
                $this->uploadAndUpdateImage($image, $aUs->id, "App\Models\AboutUs", "image");
            }
            $aUs->update($data);
            return $this->response(true,message:__("forms.manage_about_us.responses.success"));
        });
    }  catch (\Illuminate\Validation\ValidationException $e) {
        return $this->response(false, errors: $e->validator->errors()->all());
    }
    catch (\Exception $e) {
        Log::error('Error in manageform : ' . $e->getMessage());
        return $this->response(false, errors: __('forms.common.errors.default'));
    }
    }
}
