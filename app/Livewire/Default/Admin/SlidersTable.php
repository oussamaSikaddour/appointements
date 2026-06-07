<?php

namespace App\Livewire\Default\Admin;

use App\Models\Service;
use App\Models\Slider;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SlidersTable extends Component
{

      use WithPagination, TableTrait, GeneralTrait;

    #[Url()]
    public $creator = "";
    #[Url()]
    public $name = "";
    #[Url()]
    public $sliderableType = Service::class;
    #[Url()]
    public $sliderableId = "";

    public $local = "fr";
    public array $sliderableIdsOptions = [];
    public array $stateOptions = [];
    public array $sliderTypesOptions = [];

    protected array $filterable = ['name', 'sliderableType','creator'];

    protected array $validationRules = [
        'name' => ['nullable', 'string', 'max:255'],
        'creator' => ['nullable', 'string', 'max:255'],
        'sliderableType' => 'nullable|string|min:10',
    ];

    public function mount()
    {
        $this->local = app()->getLocale();
        $this->sliderTypesOptions = config('constants.SLIDERABLE_TYPE')[$this->local] ;
        $this->stateOptions = config('constants.PUBLISHING_STATE')[$this->local] ;
        $this->populateSliderableIdsSelector();

    }

    public function resetFilters()
    {
        $this->reset(['name', 'creator', 'sliderableId', 'sliderableType']);
        $this->resetPage();
    }

#[Computed()]
public function sliders()
{
    $nameField = $this->local === 'ar' ? 'name_ar' : 'name_fr';

    $query = Slider::query()
        ->with(['creator', 'sliderable']) // Always eager load relationships
        ->leftJoin('users', 'sliders.user_id', '=', 'users.id')
        ->where('sliders.sliderable_id','like', "%{$this->sliderableId}%")
        ->where('sliders.sliderable_type', $this->sliderableType)
        ->where('sliders.name','like',"%{$this->name}%")
        ->whereHas('creator', fn ($q) => $q->where($nameField, 'like', "%{$this->creator}%"));
    if ($this->sliderableType === Service::class) {
        $query->leftJoin('services', 'services.id', '=', 'sliders.sliderable_id')
            ->select([
                'sliders.*',
                "services.name_{$this->local} as location",
                "users.{$nameField} as creator",
            ]);
    } else {
        $query->select([
            'sliders.*',
            "users.{$nameField} as creator",
        ]);
    }

    return $query->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
}




    #[On("selected-value-updated")]
    public function changeArticleState(Slider $slider, $value)
    {
        try {
            $slider->update(['state' => $value]);
        } catch (\Exception $e) {
             Log::error('Error deleting slider: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    #[On("delete-slider")]
    public function deleteMenu(Slider $slider)
    {
        try {
            $slider->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting slider: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    public function openDeleteDialog($slider)
    {
        $data = [
            "question" => "dialogs.name.slider",
            "details" => ["slider", $slider['name']],
            "actionEvent" => [
                "event" => "delete-slider",
                "parameters" => $slider
            ]
        ];

        $this->dispatch("open-dialog", $data);
    }



    public function updated(string $property): void
    {
        if ($property === "sliderableType") {
           $this->populateSliderableIdsSelector();

        }

        if (in_array($property, $this->filterable) || $property === 'perPage') {
            $this->resetPage();
        }

        if (array_key_exists($property, $this->validationRules)) {
            try {
                $this->validateOnly($property, $this->validationRules);
            } catch (ValidationException $e) {
                $this->dispatch('open-errors', $e->validator->errors()->all());
            }
        }
    }

    #[Computed()]
    public function sliderableIds()
    {
        return match ($this->sliderableType) {
            Service::class => Service::get(['id', 'name_' . $this->local]),
            default => collect(),
        };
    }

        public function populateSliderableIdsSelector()
    {

        $options = match ($this->sliderableType) {
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
    public function render()
    {
        return view('livewire.default.admin.sliders-table');
    }
}
