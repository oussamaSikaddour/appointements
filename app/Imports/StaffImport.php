<?php

namespace App\Imports;

use App\Models\Bank;
use App\Models\BankingInformation;
use App\Models\PersonnelInfo;
use App\Models\Role;
use App\Models\User;
use App\Rules\ValidAccountNumber;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StaffImport implements ToCollection, WithHeadingRow, WithChunkReading
{
    protected array $errors = [];
    protected int $overallLineNumber = 1;
    protected array $userRoles = [];
    protected array $personnelInfos = [];
    protected array $bankingInfos = [];
    protected array $banksCache = [];
    protected array $existingAccountNumbers = [];

    public function __construct(
        protected ?int $establishmentId = null,
        protected ?int $serviceId = null
    ) {
        // Cache once for performance
        $this->existingAccountNumbers = BankingInformation::pluck('account_number')->toArray();
        $this->banksCache = Bank::pluck('id', 'acronym')->toArray();
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {
            $lineNumber = $this->overallLineNumber + $index + 1;

            $cleanRow = $this->trimRowValues($row->toArray());
            $this->processRow($cleanRow, $lineNumber);
        }

        $this->overallLineNumber += $rows->count();
        $this->finalizeBulkInsert();

        if ($this->hasErrors()) {
            throw new \Exception($this->getFormattedErrors());
        }
    }

    /**
     * Trim all string values in the row.
     */
    protected function trimRowValues(array $row): array
    {
        return array_map(fn($value) => is_string($value) ? trim($value) : $value, $row);
    }

    protected function processRow(array $row, int $lineNumber): void
    {
        $validator = $this->getValidator($row);

        if ($validator->fails()) {
            $this->addValidationErrors($validator->errors()->all(), $lineNumber);
            return;
        }

        $this->prepareDataForBulkInsert($row);
    }

protected function getValidator(array $row)
{
    return Validator::make($row, [
        'nom_francais'    => 'required|string|min:3|max:100',
        'prenom_francais' => 'required|string|min:3|max:100',
        'nom_arabe'       => 'nullable|string|min:3|max:100',
        'prenom_arabe'    => 'nullable|string|min:3|max:100',
        'banque'          => 'required|exists:banks,acronym',
        'e_mail'          => [
            'nullable', 'string', 'email', 'max:255',
            Rule::unique('users', 'email')->whereNull('deleted_at'),
        ],
        'compte_bancaire' => [
            'required',
            'string',
            function ($attribute, $value, $fail) {
                if (in_array($value, $this->existingAccountNumbers, true)) {
                    $fail(__('imports.banking_information.exist'));
                }
            },
            new ValidAccountNumber(),
        ],
    ], [], [
        'nom_francais'    => __('imports.users.nom_francais'),
        'prenom_francais' => __('imports.users.prenom_francais'),
        'nom_arabe'       => __('imports.users.nom_arabe'),
        'prenom_arabe'    => __('imports.users.prenom_arabe'),
        'banque'          => __('imports.users.banque'),
        'e_mail'          => __('imports.users.e_mail'),
        'compte_bancaire' => __('imports.users.compte_bancaire'),
    ]);
}



    protected function addValidationErrors(array $errors, int $lineNumber): void
    {
        foreach ($errors as $error) {
            $this->errors[] = __("imports.line-number-error", ['number' => $lineNumber]) . " : " . $error;
        }
    }

    protected function prepareDataForBulkInsert(array $row): void
    {
        $password = "Vide=1342";

        $userId = User::insertGetId([
            'name_fr'        => "{$row['nom_francais']} {$row['prenom_francais']}",
            'name_ar'        => trim(($row['nom_arabe'] ?? '') . ' ' . ($row['prenom_arabe'] ?? '')),
            'email'          => $row['e_mail'],
            'password'       => Hash::make($password),
            'establishment_id' => $this->establishmentId,
            'service_id'     => $this->serviceId,
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);

            // Get default role once
    static $defaultRoleId = null;
    if ($defaultRoleId === null) {
        $defaultRoleSlug = config('defaultRole.default_role_slug', 'user');
        $defaultRoleId   = Role::where('slug', $defaultRoleSlug)->value('id');
    }

    $this->userRoles[] = [
        'user_id'    => $userId,
        'role_id'    => $defaultRoleId,
    ];
        $this->personnelInfos[] = [
            'user_id'       => $userId,
            'is_paid'       => true,
            'last_name_fr'  => $row['nom_francais'],
            'first_name_fr' => $row['prenom_francais'],
            'last_name_ar'  => $row['nom_arabe'] ?? null,
            'first_name_ar' => $row['prenom_arabe'] ?? null,
            'created_at'    => now(),
            'updated_at'    => now(),
        ];

        $this->bankingInfos[] = [
            'bankable_id'   => $userId,
            'bankable_type' => User::class,
            'is_active'     => true,
            'bank_id'       => $this->banksCache[$row['banque']] ?? null,
            'account_number'=> $row['compte_bancaire'],
            'created_at'    => now(),
            'updated_at'    => now(),
        ];

        // Update in-memory account numbers to prevent duplicates in the same file
        $this->existingAccountNumbers[] = $row['compte_bancaire'];
    }

    protected function finalizeBulkInsert(): void
    {
        if (!empty($this->personnelInfos)) {
            PersonnelInfo::insert($this->personnelInfos);
            $this->personnelInfos = [];
        }

        if (!empty($this->bankingInfos)) {
            BankingInformation::insert($this->bankingInfos);
            $this->bankingInfos = [];
        }


    if (!empty($this->userRoles)) {
        DB::table('role_user')->insert($this->userRoles);
        $this->userRoles = [];
    }
    }

    protected function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    protected function getFormattedErrors(): string
    {
        return implode("\n", $this->errors);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}




