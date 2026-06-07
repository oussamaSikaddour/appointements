<?php

namespace App\Livewire\Default\Admin;

use App\Livewire\Forms\Establishment\AddForm;
use App\Livewire\Forms\Establishment\UpdateForm;
use App\Models\Daira;
use App\Models\Establishment;
use App\Traits\Common\DateAndTimeTrait;
use App\Traits\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class EstablishmentModal extends Component
{


        use  GeneralTrait, DateAndTimeTrait;

    // Form bindings
    public AddForm $addForm;
    public UpdateForm $updateForm;

    // Models
    public Establishment $establishment;

    // State
    public $id;
    public $form = 'addForm';
    public $local = 'fr';
    public $dairatesOptions=[];

    // Editor preview (optional if using only TinyMCE)
    public $descriptionFr = '';
    public $descriptionAr = '';
    public $descriptionEn = '';

    /* ---------------- Computed Properties ---------------- */

    #[Computed()]
    public function formEntity()
    {
        return $this->id ? $this->updateForm : $this->addForm;
    }

    #[Computed]
public function dairates()
{
    return Daira::query()
        ->whereHas('wilaya', fn ($q) =>
            $q->where('code', '13')
        )
        ->get(['id', 'designation_' . $this->local]);
}



    /* ---------------- Lifecycle ---------------- */

    public function mount()
    {
        $this->dispatch('initialize-tiny-mce');
        $this->local = app()->getLocale();

     $this->dairatesOptions =  $this->populateSelectorOption($this->dairates(),  'id','designation_'.$this->local, __('selectors.default.dairates'));
        if ($this->id) {
            $this->form = 'updateForm';
            $this->loadEstablishmentDataSafe();
        }
    }

    public function render()
    {
        return view('livewire.default.admin.establishment-modal');
    }

    /* ---------------- establishment Data Handling ---------------- */

    protected function loadEstablishmentDataSafe()
    {
        try {
            $this->loadEstablishmentData();
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            $this->logModelError($e, 'establishment');
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    protected function loadEstablishmentData()
    {
        $this->establishment = establishment::findOrFail($this->id);

        $this->fillUpdateForm();
    }

    protected function fillUpdateForm()
    {
        $this->updateForm->fill([
            'id'         => $this->id,
            'acronym'   => $this->establishment->acronym,
            'email'   => $this->establishment->email,
            'name_ar'   => $this->establishment->name_ar,
            'name_fr'   => $this->establishment->name_fr,
            'name_en'   => $this->establishment->name_en,
            'address_fr'   => $this->establishment->address_fr,
            'address_ar'   => $this->establishment->address_ar,
            'address_en'   => $this->establishment->address_en,
            'description_ar' => $this->establishment->description_ar,
            'description_fr' => $this->establishment->description_fr,
            'description_en' => $this->establishment->description_en,
            'tel' => $this->establishment->tel,
            'fax' => $this->establishment->fax,
            'daira_id' => $this->establishment->daira_id,
            'longitude' => $this->establishment->longitude,
            'latitude' => $this->establishment->latitude,


        ]);

        // Optional preview state for multilingual editors
        $this->descriptionFr = $this->establishment->description_fr;
        $this->descriptionAr = $this->establishment->description_ar;
        $this->descriptionEn = $this->establishment->description_en;
    }

    /* ---------------- Form Submission ---------------- */

    public function handleSubmit()
    {
        $response = $this->id
            ? $this->updateForm->save($this->establishment)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-establishments-table');
            $this->dispatch('open-toast', $response['message']);

            if (!$this->id) {
                $this->addForm->reset();
            }
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }





    #[On('set-description-fr')]
    public function setDescriptionFr($description)
    {
        $this->formEntity->fill(['description_fr' => $description]);
    }

    #[On('set-description-en')]
    public function setDescriptionEn($description)
    {
        $this->formEntity->fill(['description_en' => $description]);
    }

    #[On('set-description-ar')]
    public function setDescriptionAr($description)
    {
        $this->formEntity->fill(['description_ar' => $description]);
    }

    /* ---------------- Helpers ---------------- */

    protected function logModelError($exception, string $model)
    {
        Log::error("Error in establishmentModal mount ({$model} not found):", [
            'message' => $exception->getMessage(),
            'exception' => $exception,
            'establishment_id' => $this->id,
        ]);
    }

}
