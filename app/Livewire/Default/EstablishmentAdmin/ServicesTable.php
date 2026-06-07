<?php

namespace App\Livewire\Default\EstablishmentAdmin;

use App\Models\FieldSpecialty;
use App\Models\Service;
use App\Traits\Common\GeneralTrait;
use App\Traits\Common\TableTrait;
use App\Traits\Common\TextAndPdfTrait;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;
use Livewire\WithPagination;

class ServicesTable extends Component
{
    use WithPagination,
        TableTrait,
        GeneralTrait,
        WithFileUploads,
        ResponseTrait,
        TextAndPdfTrait;

    /* ---------- URL-bound filters ---------- */
    #[Url]
    public string $name          = '';
    #[Url]
    public string $type          = '';
    #[Url]
    public string $specialtyId     = '';
    #[Url]
    public string $headOfService = '';

    public string  $local = 'fr';
    public $establishmentId;
    public array   $serviceTypesOptions     = [];
    public array   $serviceSpecialtiesOptions = [];

    protected array $filterable      = ['name', 'type', 'headOfService', 'specialty'];
    protected array $validationRules = [
        'name'          => ['nullable', 'string', 'max:255'],
        'headOfService' => ['nullable', 'string', 'max:255'],
        'type'          => ['nullable', 'in:administration,health'],
    ];


        #[Computed]
public function specialties()
{
    return FieldSpecialty::query()
        ->whereHas('field', fn ($q) =>
            $q->where('acronym', 'F_MED')
        )
        ->get(['id', 'designation_' . $this->local]);
}

    /* ---------- Lifecycle ---------- */
    public function mount(): void
    {

        $this->local = app()->getLocale();

        $this->serviceTypesOptions     = config('constants.SERVICE_TYPE.'.$this->local) ?? [];
        $this->serviceSpecialtiesOptions =  $this->populateSelectorOption($this->specialties(),  'id','designation_'.$this->local, __('selectors.default.field_specialties'));
    }

    public function resetFilters(): void
    {
        $this->reset(
            'name',
            'type',
            'headOfService',
            'specialty'
        );
        $this->resetPage();
    }


#[Computed()]
public function services()
{
    return $this->buildServiceQuery()->paginate($this->perPage);
}

protected function buildServiceQuery()
{
    $local = in_array($this->local, ['fr', 'en']) ? $this->local : 'fr';
    $containsArabic = preg_match('/\p{Arabic}/u', $this->name ?? '');
    $searchColumn = $containsArabic
        ? 'services.name_ar'
        : "services.name_{$local}";

    return Service::query()
        ->select([
            'services.*',
            "users.name_{$local} as head_service",
            "field_specialties.designation_{$this->local} as specialty",
        ])
        ->leftJoin('users', 'services.head_of_service_id', '=', 'users.id')
        ->leftJoin('field_specialties', 'services.specialty_id','=','field_specialties.id')
        ->where('services.establishment_id', $this->establishmentId)
        ->when(filled($this->name), fn($q) => $q->where($searchColumn, 'like', "%{$this->name}%"))
        ->when(filled($this->type), fn($q) => $q->where('services.type', $this->type))
        ->when(filled($this->headOfService), fn($q) => $q->where("users.name_{$local}", 'like', "%{$this->headOfService}%"))
        ->when(filled($this->specialtyId), fn($q) => $q->where('services.specialty_id', $this->specialtyId))
        ->orderBy(
            $this->sortBy,
            $this->sortDirection
        );
}



    /* ---------- CRUD listeners ---------- */
    #[On('delete-service')]
    public function deleteService(Service $service): void
    {
        try {
            $service->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting service: '.$e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    public function openDeleteDialog(array $service): void
    {
        $this->dispatch('open-dialog', [
            'question'  => __('dialogs.title.service'),
            'details'   => ['service', $service['name_'.$this->local]],
            'actionEvent' => [
                'event'      => 'delete-service',
                'parameters' => $service['id'],
            ],
        ]);
    }

    /* ---------- Hooks ---------- */
    public function updated(string $property): void
    {
        if ($property === 'excelFile') {
            $errors = $this->whenExcelFileUploaded('servicesImport', __('tables.services.excel.upload.success') , [$this->establishmentId]);
            if (is_array($errors)) {
                $this->dispatch('errors-file-data', errorsFileData: $errors);
            }
        }

        if (in_array($property, $this->filterable) || $property === 'perPage') {
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

    /* ---------- Excel exports ---------- */
    public function generateEmptyServicesExcel()
    {
        return $this->generateEmptyExcelWithHeaders('services_vide', [
            'Nom (français)',
            'Nom (arabe)',
            'Nom (anglais)',
            'Chef de service',
            'Type',
            'Spécialité',
            'Téléphone',
            'Fax',
        ]);
    }

    public function generateServicesExcel()
    {
        return $this->generateExcel(
            fn () => $this->services()->map(fn ($service) => [
                __('tables.services.name_fr')    => $service->name_fr,
                __('tables.services.name_ar')    => $service->name_ar,
                __('tables.services.name_en')    => $service->name_en,
                __('tables.services.type')       => $this->serviceTypesOptions[$service->type] ?? $service->type,
                __('tables.services.specialty')  => $this->serviceSpecialtiesOptions[$service->specialty] ?? $service->specialty,
                __('tables.services.tel')        => $service->tel,
                __('tables.services.fax')        => $service->fax,
                __('tables.services.created_at') => $service->created_at->format('d/m/Y'),
            ])->toArray(),
            'services'
        );
    }

    /* ---------- Errors file download ---------- */
    #[On('errors-file-data')]
    public function downloadServicesErrorsTextFile(array $errorsFileData)
    {
        return $this->streamFileDownload($errorsFileData['filePath'], $errorsFileData['fileName']);
    }

    /* ---------- Render ---------- */
    public function render()
    {
        return view('livewire.default.establishment-admin.services-table');
    }
}
