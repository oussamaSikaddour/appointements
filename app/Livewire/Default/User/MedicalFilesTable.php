<?php

namespace App\Livewire\Default\User;

use App\Models\MedicalFile;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\TableTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class MedicalFilesTable extends Component
{
    use WithPagination, TableTrait, GeneralTrait;
    public ?int $doctorId = null;
    public ?int $openedById = null;
    /* ---------- URL-bound filters ---------- */

    #[Url] public string $name   = '';
    #[Url] public string $code   = '';
    #[Url] public string $year   = '';
    #[Url] public string $gender = '';
    #[Url] public string $state  = '';
    #[Url] public string $month  = '';
    public string $locale = 'fr';
    public array $yearsOptions = [];
    public array $genderOptions = [];
    public bool $isForDoctor = false;

    protected array $filterable = ['name', 'gender', 'year', 'code', 'state', 'month'];

    protected array $validationRules = [
        'name'   => ['nullable', 'string', 'max:255'],
        'code'   => ['nullable', 'string', 'max:255'],
        'year'   => ['nullable', 'integer', 'digits:4', 'between:1900,' . 2100],
        'gender' => ['nullable', 'string','max:10'],
        'state'  => ['nullable', 'string'],
    ];

    /* ---------- Lifecycle ---------- */
    public function mount(): void
    {

        $this->openedById=auth()->id();

        $this->locale        = app()->getLocale();
        $this->yearsOptions  = config('constants.YEARS', []);
        $this->genderOptions = config('constants.GENDER')[$this->locale] ?? [];
    }

    public function resetFilters(): void
    {
        $this->reset('name', 'gender', 'code', 'year', 'month');
        $this->resetPage();
    }

    /* ---------- Computed ---------- */
#[Computed()]
public function medicalFiles()
{
    $containsArabic = preg_match('/\p{Arabic}/u', $this->name ?? '');

    // Build patient full-name columns based on locale
    $columns = $containsArabic
        ? ['medical_files.last_name_ar', 'medical_files.first_name_ar']
        : ["medical_files.last_name_{$this->locale}", "medical_files.first_name_{$this->locale}"];

    return MedicalFile::query()
        // Filter by doctor: only include patients who have at least one appointment with this doctor
        ->when(filled($this->doctorId), fn($q) =>
            $q->whereExists(function ($sub) {
                $sub->select(DB::raw(1))
                    ->from('appointments')
                    ->whereColumn('appointments.patient_id', 'medical_files.id')
                    ->where('appointments.doctor_id', $this->doctorId);
            })
        )
        // Filter by openedById if doctorId not set
        ->when(!filled($this->doctorId) && filled($this->openedById), fn($q) =>
            $q->where('medical_files.opened_by', $this->openedById)
        )
        // Filter by state
        ->when(filled($this->state), fn($q) =>
            $q->where('medical_files.state', $this->state)
        )
        // Filter by patient name using full-name column
        ->when(filled($this->name), function ($q) use ($columns) {
            $q->where(function ($query) use ($columns) {
                foreach ($columns as $column) {
                    $query->orWhere($column, 'like', '%' . $this->name . '%');
                }
            });
        })
        // Filter by creation year
        ->when(filled($this->year), fn($q) =>
            $q->whereYear('medical_files.created_at', $this->year)
        )
        ->select('medical_files.*')
        ->orderBy($this->sortBy, $this->sortDirection)
        ->get();
}


    /* ---------- Actions ---------- */
    public function openDeleteDialog(array $medicalFile): void
    {
        $this->dispatch('open-dialog', [
            'question'    => __('dialogs.title.medical_file'),
            'details'     => ['medical_file', $medicalFile['code']],
            'actionEvent' => [
                'event'      => 'delete-medical-file',
                'parameters' => $medicalFile['id'],
            ],
        ]);
    }

    /* ---------- CRUD listeners ---------- */
    #[On('delete-medical-file')]
    public function deleteMedicalFile(MedicalFile $medicalFile): void
    {
        try {
            $medicalFile->delete();
        } catch (\Throwable $e) {
            Log::error('Error deleting MedicalFile', ['message' => $e->getMessage()]);
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

    public function render()
    {
        return view('livewire.default.user.medical-files-table');
    }
}
