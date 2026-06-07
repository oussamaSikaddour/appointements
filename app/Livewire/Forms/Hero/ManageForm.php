<?php

namespace App\Livewire\Forms\Hero;

use App\Models\Hero;
use App\Traits\Common\ModelImageTrait;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class ManageForm extends Form
{
    use ResponseTrait, ModelImageTrait;

    public $id;
    public $title_fr;
    public $title_ar;
    public $title_en;
    public $sub_title_ar;
    public $sub_title_fr;
    public $sub_title_en;
    public $images;

    // Livewire rules
    public function rules()
    {
        return [
            'title_fr' => [
                'required',
                'string',
                'min:10',
                'max:100',
                Rule::unique('heros', 'title_fr')->ignore($this->id),
            ],
            'title_ar' => [
                'required',
                'string',
                'min:10',
                'max:100',
                Rule::unique('heros', 'title_ar')->ignore($this->id),
            ],
            'title_en' => [
                'required',
                'string',
                'min:10',
                'max:100',
                Rule::unique('heros', 'title_en')->ignore($this->id),
            ],
            'sub_title_fr' => [
                'required',
                'string',
                'min:10',
                'max:100',
                Rule::unique('heros', 'sub_title_fr')->ignore($this->id),
            ],
            'sub_title_ar' => [
                'required',
                'string',
                'min:10',
                'max:100',
                Rule::unique('heros', 'sub_title_ar')->ignore($this->id),
            ],
            'sub_title_en' => [
                'required',
                'string',
                'min:10',
                'max:100',
                Rule::unique('heros', 'sub_title_en')->ignore($this->id),
            ],
            'images' => 'nullable|array|max:5',
            'images.*' => 'nullable|file|mimes:jpeg,png,gif,ico,webp|max:10000',
        ];
    }

    public function validationAttributes()
    {
        return [
            'title_ar' => __("forms.manage_hero.title_ar"),
            'title_fr' => __("forms.manage_hero.title_fr"),
            'title_en' => __("forms.manage_hero.title_en"),
            'sub_title_fr' => __("forms.manage_hero.sub_title_fr"),
            'sub_title_ar' => __("forms.manage_hero.sub_title_ar"),
            'sub_title_en' => __("forms.manage_hero.sub_title_en"),
            'images' => __("forms.manage_hero.images"),
        ];
    }

    public function save($hero)
    {
        // Validate the form data
        try {
            $data = $this->validate();

            return DB::transaction(function () use ($data, $hero) {
                $hero->update($data);
                if ($this->images) {
                    $this->uploadAndUpdateImages($this->images, $hero->id,  Hero::class, "hero");
                }
                return $this->response(true, message: __("forms.manage_hero.responses.success"));
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        }
        catch (\Exception $e) {
            // Log the error for debugging
            Log::error('manage Hero form error: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
