<?php

namespace App\Livewire\Forms\Slider;

use App\Models\Service;
use App\Models\Slider;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class AddForm extends Form
{
  use ResponseTrait;

      public $user_id;
      public $name;
    public $sliderable_type;
    public $sliderable_id;

    /**
     * Define validation rules.
     */
    public function rules()
    {



$commonRules=[
        'name' => [
            'required', 'string', 'min:5', 'max:255',
            Rule::unique('sliders')
                    ->whereNull('deleted_at')
        ],

            'user_id' => 'required|exists:users,id',
            'sliderable_type' => 'required|string|min:10',
            ];

     switch ($this->sliderable_type) {

            case Service::class:
                return array_merge($commonRules, [
                    'sliderable_id' => 'required|exists:services,id',
                ]);

            default:
                // Handle any other userable types or provide a default route name.
                return  $commonRules;
        }

    }

    /**
     * Define attribute names for validation messages.
     */
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('slider', [
           'name','user_id',"sliderable_id","sliderable_type"
        ]);
    }

    /**
     * Save the banking information.
     */
    public function save()
    {
        try {
            $data = $this->validate();
            Slider::create($data);
            return $this->response(true, message: __("forms.slider.responses.add_success"));
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Error in Slider AddForm save method: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
