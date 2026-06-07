<?php

namespace App\Livewire\Default\User;

use App\Livewire\Forms\MedicalFile\AddForm;
use App\Livewire\Forms\MedicalFile\UpdateForm;
use App\Models\MedicalFile;
use App\Traits\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class MedicalFileModal extends Component
{
    use GeneralTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;
    public ?MedicalFile $medicalFile = null;
    public ?int $medicalFileId = null;   // renamed from $id to avoid Livewire conflicts
    public string $form = 'addForm';
    public string $locale = 'fr';
    public array $genderOptions=[];



    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->locale = app()->getLocale();

            $this->genderOptions = config('constants.GENDER')[$this->locale] ??[];

        if ($this->medicalFileId) {
            $this->form = 'updateForm';
            $this->loadMedicalFileData();
        } else {
            $this->initializeAddForm();
        }
    }


    /**
     * Initialize the AddForm with defaults.
     */
    protected function initializeAddForm(): void
    {
        $this->addForm->fill([
            'opened_by'  => auth()->id(),
        ]);
    }

    /**
     * Load medicalFile data for update.
     */
    protected function loadMedicalFileData(): void
    {
        try {
            $this->medicalFile = medicalFile::findOrFail($this->medicalFileId);

            $this->updateForm->fill([
                'id'             => $this->medicalFile->id,
                "last_name_fr"=>$this->medicalFile->last_name_fr,
                "first_name_fr"=>$this->medicalFile->first_name_fr,
                "last_name_ar"=>$this->medicalFile->last_name_ar,
                "first_name_ar"=>$this->medicalFile->first_name_ar,
                 'gender'=>$this->medicalFile->gender,
                 "code"=>$this->medicalFile->code,
                 "email"=>$this->medicalFile->email,
                 "birth_place_fr"=>$this->medicalFile->birth_place_fr,
                 "birth_place_ar"=>$this->medicalFile->birth_place_ar,
                 "birth_place_en"=>$this->medicalFile->birth_place_en,
                 "birth_date"=>$this->medicalFile->birth_date,
                 "address_fr"=>$this->medicalFile->address_fr,
                 "address_ar"=>$this->medicalFile->address_ar,
                 "address_en"=>$this->medicalFile->address_en,
                 "tel"=>$this->medicalFile->tel,
                 "opened_by"=>$this->medicalFile->opened_by,
                "insurance_number"=>$this->medicalFile->insurance_number,
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Error loading medicalFile: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    /**
     * Handle form submission.
     */
    public function handleSubmit(): void
    {
        $this->dispatch('form-submitted');

        $response = $this->medicalFileId
            ? $this->updateForm->save($this->medicalFile)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-medical-files-table');
            $this->dispatch('open-toast', $response['message']);

            if ($this->form === 'addForm') {
                $this->addForm->reset();
                $this->initializeAddForm();
            }
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }
    public function render()
    {
        return view('livewire.default.user.medical-file-modal');
    }
}
