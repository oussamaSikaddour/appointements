<?php

namespace App\Livewire\Default\Doctor;

use App\Livewire\Forms\Visit\AddForm;
use App\Livewire\Forms\Visit\UpdateForm;
use App\Models\Visit;
use App\Traits\Common\DateAndTimeTrait;
use App\Traits\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class PatientVisitModal extends Component
{
    use WithFileUploads, GeneralTrait, DateAndTimeTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;

    public ?Visit $visit = null;
    public ?int $visitId = null;
    public ?int $patientId = null;

    public string $form = 'addForm';
    public string $locale = 'fr';

    public string $reportFr = '';
    public string $reportAr = '';
    public string $reportEn = '';

    #[Computed]
    public function formEntity(): AddForm|UpdateForm
    {
        return $this->visitId ? $this->updateForm : $this->addForm;
    }

    public function mount(): void
    {
        $this->locale = app()->getLocale();
        $this->dispatch('initialize-tiny-mce');

        if ($this->visitId) {
            $this->form = 'updateForm';
            $this->loadVisitData();
        } else {
            $this->initializeAddForm();
        }
    }

    private function loadVisitData(): void
    {
        try {
            $this->visit = Visit::findOrFail($this->visitId);

            $this->updateForm->fill($this->visit->only([
                'id', 'patient_id', 'doctor_id', 'report_ar', 'report_fr', 'report_en',
            ]));

            $this->reportFr = $this->visit->report_fr ?? '';
            $this->reportAr = $this->visit->report_ar ?? '';
            $this->reportEn = $this->visit->report_en ?? '';

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Visit not found in PatientVisitModal:', [
                'visit_id'  => $this->visitId,
                'message'   => $e->getMessage(),
            ]);

            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    private function initializeAddForm(): void
    {
        $this->addForm->fill([
            'doctor_id'  => auth()->id(),
            'patient_id' => $this->patientId,
        ]);
    }

    #[On('set-report-fr')]
    public function setContentFr(string $report): void
    {
        $this->formEntity->report_fr = $report;
    }

    #[On('set-report-en')]
    public function setContentEn(string $report): void
    {
        $this->formEntity->report_en = $report;
    }

    #[On('set-report-ar')]
    public function setContentAr(string $report): void
    {
        $this->formEntity->report_ar = $report;
    }

    public function handleSubmit(): void
    {
        $response = $this->visitId
            ? $this->updateForm->save($this->visit)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-patient-visits-table');
            $this->dispatch('open-toast', $response['message']);

            $this->resetAfterSubmit();
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    private function resetAfterSubmit(): void
    {
        $this->formEntity->reset();

        if ($this->visitId) {
            $this->loadVisitData();
        }
    }

    public function render()
    {
        return view('livewire.default.doctor.patient-visit-modal');
    }
}
