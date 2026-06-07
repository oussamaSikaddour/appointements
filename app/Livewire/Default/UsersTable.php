<?php

namespace App\Livewire\Default;

use App\Models\Image;
use App\Models\User;
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

class UsersTable extends Component
{
    use WithPagination, TableTrait, WithFileUploads, ResponseTrait, TextAndPdfTrait;

    #[Url]
    public string $fullName = '';

    #[Url]
    public ?string $email = null;

    #[Url]
    public ?string $employeeNumber = null;

    public ?string $establishmentId = null;
    public ?string $serviceId = null;

    public ?bool $isForSuperAdmin = null;

    public string $updateUserBtnTitle = '';
    public string $usersTableInfoMsg = '';
    public string $usersTableEmptyMsg = '';

    public string $local = 'fr';

    protected array $filterable = ['fullName', 'email', 'employeeNumber'];

    protected array $validationRules = [
        'fullName' => ['nullable', 'string', 'max:255'],
        'email' => ['nullable', 'string', 'email', 'max:255'],
        'employeeNumber' => ['nullable', 'string', 'max:255'],
    ];

public function mount(): void
{

    $this->local = app()->getLocale();

    $this->setUsersTableMessages();
}

private function setUsersTableMessages(): void
{
    $service = !empty($this->serviceId)
        ? \App\Models\Service::find($this->serviceId)
        : null;

    $establishment = !empty($this->establishmentId)
        ? \App\Models\Establishment::find($this->establishmentId)
        : null;

    $this->usersTableEmptyMsg = match (true) {
        $service !== null       => __('tables.users.empty.service'),
        $establishment !== null => __('tables.users.empty.establishment'),
        default                 => __('tables.users.empty.default'),
    };

    $this->usersTableInfoMsg = match (true) {
        $service !== null       => __('tables.users.info.service', ['acronym' => $service->acronym ?? '']),
        $establishment !== null => __('tables.users.info.establishment', ['acronym' => $establishment->acronym ?? '']),
        default                 => __('tables.users.info.default'),
    };
}



    public function resetFilters(): void
    {
        $this->reset(['fullName', 'email', 'employeeNumber']);
        $this->resetPage();
    }

    #[Computed]
public function users()
{
    $local = in_array($this->local, ['fr', 'en']) ? $this->local : 'fr';

    return User::query()
        ->with(['personnelInfo', 'service', 'establishment'])
        ->leftJoin('personnel_infos', 'users.id', '=', 'personnel_infos.user_id')
        ->leftJoin('services', 'users.service_id', '=', 'services.id')
        ->leftJoin('establishments', 'users.establishment_id', '=', 'establishments.id')
        ->when(!empty($this->fullName), function ($query) use ($local) {
            $containsArabic = preg_match('/\p{Arabic}/u', $this->fullName);
            $column = $containsArabic ? 'users.name_ar' : "users.name_{$local}";
            $query->where($column, 'like', "%{$this->fullName}%");
        })
        ->when(!empty($this->establishmentId), fn($query) =>
            $query->where('users.establishment_id', $this->establishmentId)
        )
        ->when(!empty($this->serviceId), fn($query) =>
            $query->where('users.service_id', $this->serviceId)
        )
        ->when(!empty($this->email), fn($query) =>
            $query->where('users.email', 'like', "%{$this->email}%")
        )
        ->when(!empty($this->employeeNumber), fn($query) =>
            $query->where('personnel_infos.employee_number', 'like', "%{$this->employeeNumber}%")
        )
        ->select([
            'users.*',
            'personnel_infos.employee_number',
            'personnel_infos.social_number',
            'personnel_infos.card_number',
            'personnel_infos.birth_date',
            'personnel_infos.birth_place_ar',
            'personnel_infos.birth_place_fr',
            'personnel_infos.birth_place_en',
            'personnel_infos.phone',
            "services.name_{$this->local} as service_name",
            "establishments.acronym as establishment_name",
        ])
        ->orderBy($this->sortBy, $this->sortDirection)
        ->paginate($this->perPage);
}


    public function updated(string $property): void
    {
        if ($property === 'excelFile') {
            $errorsFileData = $this->whenExcelFileUploaded("StaffImport", __('tables.users.excel.upload.success'), [$this->establishmentId , $this->serviceId]);

            if (is_array($errorsFileData)) {
                $this->dispatch('errors-file-data', errorsFileData: $errorsFileData);
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

    #[On('errors-file-data')]
    public function downloadUsersErrorsTextFile($errorsFileData)
    {
        return $this->streamFileDownload($errorsFileData['filePath'], $errorsFileData['fileName']);
    }

    public function generateEmptyStaffExcel()
    {
        return $this->generateEmptyExcelWithHeaders("personnelVide", [
            'Nom (français)',
            'Prénom (français)',
            'Nom (Arabic)',
            'Prénom (Arabic)',
            'E-mail',
            'Banque',
            'Compte bancaire',
        ]);
    }

    public function generateStaffExcel()
    {
        return $this->generateExcel(fn() => $this->users()->map(fn($user) => [
            __("tables.users.employee_number")   => $user->employee_number,
            __("tables.users.full_name_fr")      => $user->name_fr,
            __("tables.users.full_name_ar")      => $user->name_ar,
            __("tables.users.email")             => $user->email,
            __("tables.users.registration_date") => $user->created_at->format('d-m-Y'),
            __("tables.users.phone")             => $user->tel,
            __("tables.users.card_number")       => $user->card_number,
            __("tables.users.birth_date")        => $user->birth_date,
            __("tables.users.birth_place_fr")    => $user->birth_place_fr,
            __("tables.users.birth_place_ar")    => $user->birth_place_ar,
            __("tables.users.birth_place_en")    => $user->birth_place_en,
        ])->toArray(), "users");
    }

    public function openDeleteUserDialog($user): void
    {
        $locale = in_array(app()->getLocale(), ['fr', 'ar', 'en']) ? app()->getLocale() : 'fr';
        $name = $user["name_{$locale}"] ?? $user['name_fr'] ?? '';

        $data = [
            "question" => "dialogs.title.user",
            "details" => ["user", $name],
            "actionEvent" => [
                "event" => "delete-user",
                "parameters" => $user
            ],
        ];

        $this->dispatch("open-dialog", $data);
    }

    #[On("delete-user")]
    public function deleteUser(User $user): void
    {
        try {
            $images = Image::where([
                ['imageable_id', $user->id],
                ['imageable_type', User::class],
            ])->get();

            if ($images->isNotEmpty()) {
                $this->deleteImages($images);
            }

            $user->delete();
        } catch (\Exception $e) {
            Log::error('Error deleting user: ' . $e->getMessage());
            $this->dispatch('open-errors', __('forms.common.errors.default'));
        }
    }

    public function render()
    {
        return view('livewire.default.users-table');
    }
}
