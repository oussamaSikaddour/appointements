<?php

namespace App\Livewire\Forms\Slide;

use App\Models\Slide;
use App\Traits\Common\AppSpecificTrait;
use App\Traits\Common\ModelImageTrait;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class UpdateForm extends Form
{
use ResponseTrait,ModelImageTrait,AppSpecificTrait;
   public $id;
    public $slider_id;
    public $image;
    public $title_fr;
    public $title_ar;
    public $title_en;
    public $content_ar;
    public $content_fr;
    public $content_en;
    public $order;

    /**
     * Define validation rules.
     */
    public function rules()
    {

        $localizedTitleRules = [
            'required', 'string', 'min:5', 'max:255',
            Rule::unique('slides')
                    ->whereNull('deleted_at')
                    ->ignore($this->id)
        ];
        $localizedContentRules = [
            'required', 'string', 'min:50', 'max:300',
            Rule::unique('slides')
                    ->whereNull('deleted_at')
                    ->ignore($this->id)
        ];

    return [
        'image' => 'required|file|mimes:jpeg,png,gif,ico,webp|max:10000',
        'title_fr' => $localizedTitleRules,
        'title_en' => $localizedTitleRules,
        'title_ar' => $localizedTitleRules,
        'content_fr'=>$localizedContentRules,
        'content_ar'=>$localizedContentRules,
        'content_en'=>$localizedContentRules,
        'order' => 'nullable|integer|min:1',
        'slider_id' => [
            'required',
            'integer',
            Rule::exists('sliders', 'id'),
        ],
    ];


    }

    /**
     * Define attribute names for validation messages.
     */
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('slide', [
           'title_fr','title_ar','title_en','content_ar','content_fr','content_en','order','slider_id'
        ]);
    }

    /**
     * Save the banking information.
     */


        public function save($slide,$slider)
    {
            $data = $this->validate();
             $data = $this->setSlideOrder($data,$slider);
        try {

            return DB::transaction(function () use ($data,$slide) {
                // Create user
              $slide->update($data);
               if ($this->image) {
                $this->uploadAndUpdateImage($this->image, $slide->id, Slide::class, "slide");
            }
                return $this->response(true, message: __("forms.user.responses.add_success"));
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Error in Slide UpdateForm save method: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }

}
