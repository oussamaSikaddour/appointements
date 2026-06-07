<?php

namespace App\Livewire\Default\Doctor;

use App\Models\File;
use App\Models\Image;
use App\Models\User;
use App\Models\Visit;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\ModelFileTrait;
use App\Traits\Common\ModelImageTrait;
use App\Traits\Common\TableTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class PatientVisitsTable extends Component
{
    use TableTrait, GeneralTrait, ModelImageTrait, ModelFileTrait;

    public ?int $doctorId = null;
    public ?int $patientId = null;
       public string $patient="";
    public string $patientCode="";
    public string $locale = 'fr';
    public array $doctorsOptions = [];

    /** @var string[] */
    protected array $filterable = ['doctorId'];

    /** @var array<string, array<int, string>> */
    protected array $validationRules = [
        'doctorId' => ['nullable', 'integer'],
        'patient' => ['nullable', 'string', 'max:255'],
        'patientCode' => ['nullable', 'string', 'max:20'],
    ];

    /* -------------------------------------------------------------------------- */
    /*                               Helper Methods                               */
    /* -------------------------------------------------------------------------- */

    protected function localFrAndArOnly(): string
    {
        return in_array($this->locale, ['fr', 'ar'], true) ? $this->locale : 'fr';
    }

    /* -------------------------------------------------------------------------- */
    /*                               Computed Data                                */
    /* -------------------------------------------------------------------------- */
#[Computed]
public function doctors()
{
    $localeColumn = "name_{$this->localFrAndArOnly()}";

    return Cache::remember(
        "patient_{$this->patientId}_doctors_{$this->locale}",
        now()->addMinutes(10),
        fn() => User::query()
            ->select(['id', $localeColumn])
            ->whereHas('roles', fn($q) => $q->where('slug', 'doctor'))
            ->whereHas('occupations', fn($q) => $q
                ->where('is_active', true)
                ->whereHas('field', fn($q) => $q->where('acronym', 'F_MED'))
            )
            ->whereHas('doctorAppointments', fn($q) =>
                $q->when($this->patientId, fn($q) =>
                    $q->where('patient_id', $this->patientId)
                )
            )
            ->orderBy($localeColumn)
            ->get()
    );
}


#[Computed]
public function visits()
{
    $lang = $this->localFrAndArOnly();

    return Visit::query()
        ->leftJoin('medical_files', 'medical_files.id', '=', 'visits.patient_id')
        ->leftJoin('users', 'users.id', '=', 'visits.doctor_id')
        ->when($this->doctorId, fn($q) => $q->where('visits.doctor_id', $this->doctorId))
        ->when($this->patientCode, fn($q) => $q->where('medical_files.code', 'like', "%{$this->patientCode}%"))
        ->when($this->patient, fn($q) =>
            $q->whereRaw("CONCAT(medical_files.last_name_{$lang}, ' ', medical_files.first_name_{$lang}) LIKE ?", ["%{$this->patient}%"])
        )
        ->select([
            'visits.id',
            'visits.created_at',
            'medical_files.id AS patient_id',
            'medical_files.code AS patient_code',
            'medical_files.tel AS patient_tel',
            'medical_files.birth_date AS patient_birth_date',
            DB::raw("CONCAT(medical_files.last_name_{$lang}, ' ', medical_files.first_name_{$lang}) AS patient_name"),
            DB::raw("users.name_{$lang} AS doctor_name"),
        ])
        ->orderBy($this->sortBy, $this->sortDirection)
        ->get();
}



    /* -------------------------------------------------------------------------- */
    /*                               Lifecycle Hooks                              */
    /* -------------------------------------------------------------------------- */

    public function mount(): void
    {
        $this->locale = app()->getLocale();

        $this->doctorsOptions = $this->populateSelectorOption(
            $this->doctors(),
            'id',
            "name_{$this->localFrAndArOnly()}",
            __('selectors.default.doctors')
        );
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Actions                                  */
    /* -------------------------------------------------------------------------- */

    public function resetFilters(): void
    {
        $this->reset('doctorId','patient','patientCode');
        $this->resetPage();
    }



public function openDeleteDialog(array $visit): void
{
    $createdAt = Carbon::parse($visit['created_at'])->format('Y-m-d');

    $this->dispatch('open-dialog', [
        'question'    => __('dialogs.title.patient-visit'),
        'details'     => ['patient-visit', $createdAt],
        'actionEvent' => [
            'event'      => 'delete-visit',
            'parameters' => $visit['id'],
        ],
    ]);
}


    /* -------------------------------------------------------------------------- */
    /*                               CRUD Listeners                               */
    /* -------------------------------------------------------------------------- */

    #[On('delete-visit')]
    public function deleteVisit(Visit $visit): void
    {
        try {
            // Delete associated images
            $images = Image::where([
                ['imageable_id', $visit->id],
                ['imageable_type', Visit::class],
            ])->get();

            if ($images->isNotEmpty()) {
                $this->deleteImages($images);
            }

            // Delete associated files
            $files = File::where([
                ['fileable_id', $visit->id],
                ['fileable_type', Visit::class],
            ])->get();

            if ($files->isNotEmpty()) {
                $this->deleteFiles($files);
            }

            $visit->delete();
        } catch (\Throwable $e) {
            Log::error('Error deleting visit', [
                'visit_id' => $visit->id,
                'message'  => $e->getMessage(),
            ]);

            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    /* -------------------------------------------------------------------------- */
    /*                                   Hooks                                    */
    /* -------------------------------------------------------------------------- */

    public function updated(string $property): void
    {
        if (in_array($property, $this->filterable, true) || $property === 'perPage') {
            $this->resetPage();
        }

        if (isset($this->validationRules[$property])) {
            try {
                $this->validateOnly($property, $this->validationRules);
            } catch (ValidationException $e) {
                $this->dispatch('open-errors', $e->validator->errors()->all());
            }
        }
    }

    public function render()
    {
        return view('livewire.default.doctor.patient-visits-table');
    }
}
