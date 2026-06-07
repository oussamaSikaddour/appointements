<?php

namespace App\Livewire\Default\Admin;

use App\Livewire\Forms\Slider\AddForm;
use App\Livewire\Forms\Slider\UpdateForm;
use App\Models\Service;
use App\Models\Slider;
use App\Traits\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;

class SliderModal extends Component
{

     use GeneralTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;
    public Slider $slider;
    public $id;
    public $form = 'addForm';
    public $local='fr';
    public $sliderableIdsOptions = [];
    public $sliderableTypesOptions=[];
    public $stateOptions=[];
    #[Computed()]
    public function formEntity()
    {
        return $this->id ? $this->updateForm : $this->addForm;
    }







    protected function loadSliderData()
    {
        $this->slider = Slider::findOrFail($this->id);

        $this->fillUpdateForm();
    }


    protected function fillUpdateForm()
    {

        $this->updateForm->fill([
            'id' => $this->id,
            'user_id' => auth()->id(),
            'name' => $this->slider->name,
            'sliderable_type' => $this->slider->sliderable_type,
            'sliderable_id' => $this->slider->sliderable_id,
            'state' => $this->slider->state,
        ]);
    }

    #[Computed]
    public function sliderableIds()
    {
        return match ($this->formEntity->sliderable_type) {
            Service::class => Service::get(['id', 'name_' . $this->local]),
            default => collect(),
        };
    }

    public function populateArticleableIdsSelector()
    {
        $options = match ($this->formEntity->sliderable_type) {
            Service::class => $this->populateSelectorOption(
                $this->sliderableIds(),
                'id',
                'name_' . $this->local,
                __('selectors.default.services')
            ),
            default => ["" => __('selectors.default.locations')],
        };
        $this->sliderableIdsOptions = $options;
    }

    public function handleSubmit()
    {
        $response = $this->id
            ? $this->updateForm->save($this->slider)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-sliders-table');
            $this->dispatch('open-toast', $response['message']);

            if (!$this->id) {
                $this->addForm->reset();
            }
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

        public function mount()
    {
        $this->local = app()->getLocale();
        $this->sliderableTypesOptions = config('constants.SLIDERABLE_TYPE')[$this->local] ?? [];
        $this->stateOptions = config('constants.PUBLISHING_STATE')[$this->local] ;
        $this->dispatch('initialize-tiny-mce');
        if ($this->id) {
            $this->form = 'updateForm';
            try {
                $this->loadSliderData();
            } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
                Log::error('Error in ArticleModal mount:', [
                    'message' => $e->getMessage(),
                    'exception' => $e,
                    'slider_id' => $this->id,
                ]);
                $this->dispatch('open-errors', __('forms.common.errors.default'));
            }
        } else {
            $this->addForm->fill([
                'user_id' => auth()->id(),
            ]);
        }
        $this->populateArticleableIdsSelector();
    }

        public function updated($property)
    {
        if (in_array($property, ['addForm.sliderable_type', 'updateForm.sliderable_type'])) {

            $this->populateArticleableIdsSelector();
        }
    }
    public function render()
    {
        return view('livewire.default.admin.slider-modal');
    }
}
