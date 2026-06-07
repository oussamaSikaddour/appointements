<?php

namespace App\Livewire\Default\Admin;

use App\Livewire\Forms\Establishment\ManageTypesForm;
use App\Models\Establishment;
use App\Traits\Common\GeneralTrait;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;

class EstablishmentDetails extends Component
{
    use GeneralTrait;

    public ManageTypesForm $form;
    public ?int $id = null;
    public ?Establishment $establishment = null;
    public $existingTypes =[];
    public $local="fr";

    /**
     * Mount the component and load establishment data.
     */
    public function mount(): void
    {
        $this->local = app()->getLocale();
        if (!$this->id) {
            return;
        }
        $this->existingTypes = config('constants.ESTABLISHMENT_TYPES')[$this->local] ;

        try {
            $this->establishment = Establishment::findOrFail($this->id);

            // Convert JSON types to array if needed
            $this->form->types = is_array($this->establishment->types)
                ? $this->establishment->types
                : json_decode($this->establishment->types, true) ?? [];
        } catch (ModelNotFoundException $e) {
            Log::error('Establishment not found: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }


    /**
     * Add new type dynamically (e.g., on keydown).
     */
    public function updatetypesOnKeydownEvent($value): void
    {
        if (!isset($this->form->types)) {
            $this->form->types = [];
        }
        $this->checkAndUpdateArray($this->form->types, $value);
    }

    /**
     * Handle form submission.
     */
    public function handleSubmit(): void
    {
        $response = $this->form->save($this->establishment);

        if ($response['status']) {
            $this->dispatch('open-toast', $response['message'] ?? __('forms.establishment.responses.manage_success'));
        } else {
            $this->dispatch('open-errors', $response['errors'] ?? [__('forms.common.errors.default')]);
        }
    }

    public function render()
    {
        return view('livewire.default.admin.establishment-details');
    }
}
