<?php

namespace App\Livewire\Default\ServiceAdmin;

use App\Livewire\Forms\ScheduleDay\AddForm;
use App\Livewire\Forms\ScheduleDay\UpdateForm;
use App\Models\Establishment;
use App\Models\ScheduleDay;
use App\Models\Service;
use App\Models\User;
use App\Traits\Common\DateAndTimeTrait;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\TableTrait;
use Carbon\Traits\Date;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class ScheduleDaysModal extends Component
{
    use WithPagination, TableTrait, GeneralTrait, DateAndTimeTrait;

    /** Forms */
    public AddForm $addForm;
    public UpdateForm $updateForm;

    /** Current schedule day */
    public ?ScheduleDay $scheduleDay = null;

    /** State */
    public ?int $scheduleDayId = null;
    public ?int $scheduleId = null;
    public string $scheduleName = '';
    public string $scheduleState = "not_published";
    public array $schedule = [];
    public ?int $selectedChoice = null;
    public string $form = 'addForm';
    public string $locale = 'fr';
    public ?string $minDate = null;
 public ?Service $service =null;
    /** Select options */
    public array $doctorsOptions = [];
    public array $appointmentsLocationsOptions = [];


        protected function localFrAndArOnly(): string
    {
        return in_array($this->locale, ['fr', 'ar']) ? $this->locale : 'fr';
    }

    /**
     * Prepare add form defaults
     */
protected function initializeAddForm(): void
{
    $minDateOfPlanning = Carbon::createFromDate(
        $this->schedule['year'],
        $this->schedule['month'],
        1
    );

    $this->minDate = (
        $minDateOfPlanning->isPast()
            ? now()->addDays(3)
            : $minDateOfPlanning
    )->format('Y-m-d');

    // Cache the full service


    $this->addForm->fill([
        'schedule_id'  => $this->schedule['id'],
        'day_at'       => $this->minDate,
        'specialty_id' => $this->service?->specialty_id,
    ]);
}

    /**
     * Doctors list (computed).
     */
#[Computed]
public function doctors()
{
    // get cached service once (you already cache it earlier)
    $service = Cache::get("service:{$this->schedule['service_id']}");

    return User::query()
        ->whereHas('roles', fn ($q) => $q->where('slug', 'doctor'))
        ->whereHas('occupations', fn ($q) => $q
            ->where('is_active', true)
            ->where('field_specialty_id', $service?->specialty_id)
        )
        ->get(['id', "name_{$this->localFrAndArOnly()}"]);
}

    /**
     * Appointment locations list (computed).
     */
    #[Computed]
    public function appointmentsLocations()
    {
        return Establishment::query()
            ->whereJsonContains('types', 'appointment_locations')
            ->get(['id', "name_{$this->locale}"]);
    }

    /**
     * Schedule days list (computed).
     */
    #[Computed]
    public function scheduleDays()
    {
        $doctorColumn = preg_match('/\p{Arabic}/u', $this->name ?? '')
            ? 'users.name_ar'
            : "users.name_{$this->localFrAndArOnly()}";

        return ScheduleDay::query()
            ->select([
                'schedule_days.id',
                'schedule_days.day_at',
                'schedule_days.available_number',
                'schedule_days.confirmed_number',
                'schedule_days.created_at',
                "{$doctorColumn} as doctor",
                "establishments.name_{$this->locale} as appointment_location",
            ])
            ->leftJoin('users', 'users.id', '=', 'schedule_days.doctor_id')
            ->leftJoin('establishments', 'establishments.id', '=', 'schedule_days.appointments_location_id')
            ->where('schedule_days.schedule_id', $this->schedule['id'])
            ->orderBy($this->sortBy, $this->sortDirection)
            ->get();
    }

    /**
     * Reset form fields.
     */
    public function resetForm(): void
    {
        $this->form = 'addForm';
        $this->scheduleDayId = $this->selectedChoice = null;

        $this->addForm->reset();
        $this->updateForm->reset();

        $this->initializeAddForm();
    }

    /**
     * Switch form when selection changes.
     */
    public function updatedSelectedChoice(): void
    {
        $this->scheduleDayId = $this->selectedChoice;
        $this->form = $this->scheduleDayId ? 'updateForm' : 'addForm';

        if ($this->scheduleDayId) {
            $this->setScheduleDayForm($this->scheduleDayId);
        }
    }

    /**
     * Mount component.
     */
    public function mount(): void
    {
        $this->locale = app()->getLocale();
        $this->scheduleName = $this->schedule['name_'.$this->locale] ?? '';
      $this->scheduleState=$this->schedule['state'];

        $this->service = !empty($this->schedule['service_id'])
        ? Cache::rememberForever(
            "service:{$this->schedule['service_id']}",
            fn () => Service::with('specialty')->find($this->schedule['service_id'])
        )
        : null;
        $this->loadSelectOptions();

        try {
            $this->resetForm();
        } catch (\Throwable $e) {
            $this->handleException('mount', $e);
        }
    }

    /**
     * Populate select options.
     */
    protected function loadSelectOptions(): void
    {

        $this->doctorsOptions = $this->populateSelectorOption(
            $this->doctors(),
            'id',
            "name_{$this->localFrAndArOnly()}",
            __('selectors.default.doctors')
        );

        $this->appointmentsLocationsOptions = $this->populateSelectorOption(
            $this->appointmentsLocations(),
            'id',
            "name_{$this->locale}",
            __('selectors.default.appointments_locations')
        );
    }

    /**
     * Load update form values.
     */
    public function setScheduleDayForm(int $scheduleDayId): void
    {
        try {
            $this->scheduleDay = ScheduleDay::where('schedule_id', $this->schedule['id'])
                ->findOrFail($scheduleDayId);

            $this->updateForm->fill([
                'id'                     => $this->scheduleDay->id,
                'doctor_id'              => $this->scheduleDay->doctor_id,
                'day_at'                 => $this->scheduleDay->day_at->format('Y-m-d'),
                'specialty_id'           => $this->scheduleDay->specialty_id,
                'appointments_location_id'=> $this->scheduleDay->appointments_location_id,
                'available_number'                  => $this->scheduleDay->available_number,
                 'schedule_id'  => $this->scheduleDay->schedule_id
            ]);
        } catch (\Throwable $e) {
            $this->handleException('setScheduleDayForm', $e);
        }
    }

    /**
     * Handle form submit.
     */
    public function handleSubmit(): void
    {
        $this->dispatch('form-submitted');

        $response = $this->scheduleDayId
            ? $this->updateForm->save($this->scheduleDay)
            : $this->addForm->save();

        if ($response['status']) {
            $this->dispatch('update-schedule-days-table');

            if ($this->form === 'addForm') {
                $this->resetForm();
            }

            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }

    /**
     * Open delete confirmation.
     */
    public function openDeleteScheduleDayDialog(array $scheduleDay): void
    {
      $date =$this->parseDate($scheduleDay['day_at']);
        $this->dispatch('open-dialog', [
            'question'    => 'dialogs.title.schedule_day',
            'details'     => ['schedule_day', $date ?? ''],
            'actionEvent' => ['event' => 'delete-schedule-day', 'parameters' => $scheduleDay],
        ]);
    }

    /**
     * Delete schedule day.
     */
    #[On('delete-schedule-day')]
    public function deleteScheduleDay(ScheduleDay $scheduleDay): void
    {
        try {
            $scheduleDay->delete();
        } catch (\Throwable $e) {
            $this->handleException('deleteScheduleDay', $e);
        }
    }

    /**
     * Handle exceptions in one place.
     */
    protected function handleException(string $context, \Throwable $e): void
    {
        Log::error("Error in ScheduleDaysModal@{$context}: {$e->getMessage()}");
        $this->dispatch('open-errors', __('forms.common.errors.default'));
    }

    /**
     * Render component.
     */
    public function render()
    {
          $this->dispatch("init-tooltips");
        return view('livewire.default.service-admin.schedule-days-modal');
    }
}
