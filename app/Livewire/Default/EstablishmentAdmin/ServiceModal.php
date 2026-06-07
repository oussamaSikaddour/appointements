<?php

namespace App\Livewire\Default\EstablishmentAdmin;

use App\Livewire\Forms\Service\AddForm;
use App\Livewire\Forms\Service\UpdateForm;
use App\Models\FieldSpecialty;
use App\Models\Service;
use App\Models\User;
use App\Traits\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ServiceModal extends Component
{
    use GeneralTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;
    public Service $service;

    public $id;
    public $form = 'addForm';
    public $establishmentId;

    public $local = 'fr';

    public $serviceTypesOptions = [];
    public $serviceSpecialtiesOptions = [];
    public $headOfServiceOptions = [];






    /**
     * Mount the component.
     */
    public function mount(): void
    {

        $this->local = app()->getLocale();
        // Load select options
        $this->loadSelectOptions();

        // If editing, load existing data
        if ($this->id) {
            $this->form = 'updateForm';
            $this->loadServiceData();
        }else{
         $this->addForm->fill([
            'establishment_id' => $this->establishmentId,
        ]);


        }

    }

    /**
     * Load dropdown/select options.
     */
    protected function loadSelectOptions(): void
    {
        // Service types from config
        $this->serviceTypesOptions = config('constants.SERVICE_TYPE')[$this->local] ?? [];

        // Specialties
        $this->serviceSpecialtiesOptions = $this->populateSelectorOption(
            $this->specialties(),
            'id',
            'designation_' . $this->local,
            __('selectors.default.field_specialties')
        );

         $local = in_array($this->local, ['fr', 'en']) ? $this->local : 'fr';

        $this->headOfServiceOptions = $this->populateSelectorOption(
            $this->staff(),
            'id',
            'name_' . $local,
            __('selectors.default.head_of_service')
        );
    }

    /**
     * Load service data for update.
     */
    protected function loadServiceData(): void
    {
        try {
            $this->service = Service::findOrFail($this->id);

            $this->updateForm->fill([
                'id'                 => $this->service->id,
                'name_ar'            => $this->service->name_ar,
                'name_fr'            => $this->service->name_fr,
                'name_en'            => $this->service->name_en,
                'head_of_service_id' => $this->service->head_of_service_id,
                'type'               => $this->service->type,
                'tel'               => $this->service->tel,
                'fax'               => $this->service->fax,
                'specialty_id'       => $this->service->specialty_id,
                'establishment_id'        => $this->service->establishment_id,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Error loading service: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    /**
     * Computed: load specialties for the selector.
     */
    #[Computed]
    public function specialties()
    {
        return FieldSpecialty::query()
            ->whereHas('field', fn ($q) =>
                $q->where('acronym', 'F_MED')
            )
            ->get(['id', 'designation_' . $this->local]);
    }

    /**
     * Computed: load staff for head of service selector.
     */
    /**
     * Computed: load staff for head of service selector.
     */
    #[Computed]
    public function staff()
    {
        $local = in_array($this->local, ['fr', 'en']) ? $this->local : 'fr';
        return User::query()
            ->where('establishment_id', $this->establishmentId)
            ->get(['id', 'name_' . $local]);
    }


    /**
     * Handle form submission.
     */
    public function handleSubmit(): void
    {
        $this->dispatch('form-submitted');

        $response = $this->id
            ? $this->updateForm->save($this->service)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-services-table');
            $this->dispatch('open-toast', $response['message']);


            if ($this->form === 'addForm') {
                $this->addForm->reset();
             $this->addForm->fill([
                'establishment_id' => $this->establishmentId,
              ]);
            }
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    /**
     * Render the component.
     */
    public function render()
    {
        return view('livewire.default.establishment-admin.service-modal');
    }
}
