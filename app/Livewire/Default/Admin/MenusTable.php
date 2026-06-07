<?php

namespace App\Livewire\Default\Admin;

use App\Models\Menu;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MenusTable extends Component
{
        use WithPagination, TableTrait, GeneralTrait;
    #[Url()]
    public $title = "";
    #[Url()]
    public $type = "";
     #[Url()]
    public $state = "";
    public $local="fr";
    public array $stateOptions=[];
    public array $menuTypesOptions=[];
    protected array $filterable = ['title','type','state'];
    protected array $validationRules = [
        'title' => ['nullable', 'string', 'max:255'],
        'state' => 'nullable|in:published,not_published',
        'type' => 'nullable|in:external_links,internal_links',
    ];




    public function mount(){
     $this->local = app()->getLocale();
     $this->menuTypesOptions = config('constants')['MENU_TYPES'][$this->local];
    $this->stateOptions = config('constants')['PUBLISHING_STATE'][$this->local];
    }

    /**
     * Reset all filters.
     */
    public function resetFilters()
    {
        $this->title="";
        $this->type="";
        $this->state="";
        $this->resetPage();
    }

    /**
     * Get paginated list of our qualities with localized designations.
     */
    #[Computed()]
public function menus()
{
    $query = Menu::query()
          ->where('title_'.$this->local, 'like', "%{$this->title}%")
          ->where('type', 'like', "%{$this->type}%")
          ->where('state', 'like', "{$this->state}%")
          ->orderBy($this->sortBy, $this->sortDirection);
    return $query->paginate($this->perPage);
}



    #[On("selected-value-updated")]
    public function changeMenuState(Menu $menu, $value)
    {
        try {
        $menu->update(['state' => $value]);
        } catch (\Exception $e) {
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }


    /**
     * Delete an OurQuality entity and its associated images.
     */
    #[On("delete-menu")]
    public function deleteMenu( Menu $Menu)
    {
        try {
            $Menu->delete();
        } catch (\Exception $e) {
            Log::error('Error in deleteMenu method: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    /**
     * Handle property updates and reset pagination if necessary.
     */


    public function openDeleteDialog($menu){
        $data=[
            "question" => "dialogs.title.menu",
            "details" =>["menu",$menu['title_'.$this->local]],
            "actionEvent"=>[
                            "event"=>"delete-menu",
                            "parameters"=>$menu
                            ]
            ];
    $this->dispatch("open-dialog", $data);
    }


    public function updated(string $property): void
{
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


    public function render()
    {
        return view('livewire.default.admin.menus-table');
    }
}
