<?php

namespace App\Livewire\Default\ServiceAdmin;

use App\Models\Schedule;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\TableTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class SchedulesTable extends Component
{
    use WithPagination, TableTrait, GeneralTrait;

    /* ---------- URL-bound filters ---------- */
    #[Url] public string $name  = '';
    #[Url] public string $state = '';
    #[Url] public string $year  = '';
    #[Url] public string $month = '';

    /* ---------- General properties ---------- */
    public ?int $serviceId= null;
    public string $locale = 'fr';
    public array $yearsOptions = [];
    public array $monthsOptions = [];
    public array $statesOptions = [];
    public ?int $scheduleId = null;

    protected array $filterable = ['name', 'state', 'month', 'year'];
    protected array $validationRules = [
        'name' => ['nullable', 'string', 'max:255'],
        'year' => ['nullable', 'integer', 'digits:4', 'between:2025,2050'],
        'month'=> ['nullable', 'integer', 'between:1,12'],
    ];

    /* ---------- Lifecycle ---------- */
    public function mount(): void
    {
        $this->locale        = app()->getLocale();
        $this->yearsOptions  = config('constants.YEARS', []);
        $this->monthsOptions = config('constants.MONTHS_OPTIONS')[$this->locale] ?? [];
        $this->statesOptions = config('constants.PUBLISHING_STATE')[$this->locale] ?? [];
    }

    public function resetFilters(): void
    {
        $this->reset('name', 'state', 'month', 'year');
        $this->resetPage();
    }

    /* ---------- Computed ---------- */
    #[Computed]
    public function schedules()
    {
        return $this->buildScheduleQuery()->paginate($this->perPage);
    }

    protected function buildScheduleQuery()
    {
        $containsArabic = preg_match('/\p{Arabic}/u', $this->name ?? '');
        $searchColumn   = $containsArabic
            ? 'schedules.name_ar'
            : "schedules.name_{$this->locale}"; // fixed: typo $this->local → $this->locale

        return Schedule::query()
            ->where('service_id', $this->serviceId)
            ->when(filled($this->name), fn($q) => $q->where($searchColumn, 'like', "%{$this->name}%"))
            ->when(filled($this->state), fn($q) => $q->where('state', $this->state))
            ->when(filled($this->year), fn($q) => $q->where('year', $this->year))
            ->when(filled($this->month), fn($q) => $q->where('month', $this->month))
            ->orderBy($this->sortBy, $this->sortDirection);
    }



    public function openDeleteDialog(array $schedule): void
    {
        $this->dispatch('open-dialog', [
            'question'    => __('dialogs.title.schedule'),
            'details'     => ['schedule', $schedule['name_'.$this->locale]],
            'actionEvent' => [
                'event'      => 'delete-schedule',
                'parameters' => $schedule['id'],
            ],
        ]);
    }
    public function openPublishDialog(array $schedule): void
    {
        $this->dispatch('open-dialog', [
            'question'    => __('dialogs.title.publish_schedule'),
            'details'     => ['publish_schedule', $schedule['name_'.$this->locale]],
            'actionEvent' => [
                'event'      => 'publish-schedule',
                'parameters' => $schedule['id'],
            ],
        ]);
    }

        /* ---------- CRUD listeners ---------- */
    #[On('delete-schedule')]
    public function deleteSchedule(Schedule $schedule): void
    {
        try {
            $schedule->delete();
        } catch (\Throwable $e) {
            Log::error('Error deleting schedule', ['message' => $e->getMessage()]);
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }
    #[On('publish-schedule')]
    public function publishSchedule(Schedule $schedule): void
    {
        try {
           $schedule->update(['state' => "published"]);
        } catch (\Throwable $e) {
            Log::error('Error publishSchedule', ['message' => $e->getMessage()]);
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }



    /* ---------- Hooks ---------- */
    public function updated(string $property): void
    {
        if (in_array($property, $this->filterable, true) || $property === 'perPage') {
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

    /* ---------- Render ---------- */
    public function render()
    {
        return view('livewire.default.service-admin.schedules-table');
    }
}
