<?php

namespace App\Livewire\Default\ServiceAdmin;

use App\Livewire\Forms\Schedule\AddForm;
use App\Livewire\Forms\Schedule\UpdateForm;
use App\Models\Schedule;
use App\Traits\Common\GeneralTrait;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ScheduleModal extends Component
{

    use GeneralTrait;

    public AddForm $addForm;
    public UpdateForm $updateForm;
    public ?Schedule $schedule = null;

    public ?int $scheduleId = null;   // renamed from $id to avoid Livewire conflicts
    public string $form = 'addForm';
    public ?int $serviceId = null;

    public string $locale = 'fr';

    public array $yearsOptions = [];
    public array $monthsOptions = [];
    public array $statesOptions=[];

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->locale = app()->getLocale();

        $this->loadSelectOptions();

        if ($this->scheduleId) {
            $this->form = 'updateForm';
            $this->loadScheduleData();
        } else {
            $this->initializeAddForm();
        }
    }

    /**
     * Load dropdown/select options.
     */
    protected function loadSelectOptions(): void
    {
        $this->yearsOptions = config('constants.YEARS', []);
        $this->monthsOptions = config('constants.MONTHS_OPTIONS')[$this->locale] ?? [];
         $this->statesOptions = config('constants.PUBLISHING_STATE')[$this->locale] ??[];

    }

    /**
     * Initialize the AddForm with defaults.
     */
    protected function initializeAddForm(): void
    {
        $this->addForm->fill([
            'service_id' => $this->serviceId,
            'opened_by'  => auth()->id(),
        ]);
    }

    /**
     * Load schedule data for update.
     */
    protected function loadScheduleData(): void
    {
        try {
            $this->schedule = Schedule::findOrFail($this->scheduleId);

            $this->updateForm->fill([
                'id'             => $this->schedule->id,
                'name_ar'        => $this->schedule->name_ar,
                'name_fr'        => $this->schedule->name_fr,
                'name_en'        => $this->schedule->name_en,
                'description_fr' => $this->schedule->description_fr,
                'description_ar' => $this->schedule->description_ar,
                'description_en' => $this->schedule->description_en,
                'state'          => $this->schedule->state,
                'year'          => $this->schedule->year,
                'month'          => $this->schedule->month,
                'service_id'     => $this->schedule->service_id,
                'opened_by'      => auth()->id(),
            ]);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Error loading schedule: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    /**
     * Handle form submission.
     */
    public function handleSubmit(): void
    {
        $this->dispatch('form-submitted');

        $response = $this->scheduleId
            ? $this->updateForm->save($this->schedule)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-schedules-table');
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
        return view('livewire.default.service-admin.schedule-modal');
    }


}
