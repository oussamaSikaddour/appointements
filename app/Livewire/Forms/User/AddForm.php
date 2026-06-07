<?php

namespace App\Livewire\Forms\User;

use App\Models\PersonnelInfo;
use App\Models\Role;
use App\Models\User;
use App\Traits\Common\ModelFileTrait;
use App\Traits\Common\ModelImageTrait;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Livewire\Form;

class AddForm extends Form
{
    use ResponseTrait, ModelImageTrait, ModelFileTrait;

    public $default = [
        "email" => null,
        'establishment_id'=>null,
        'service_id'=>null
    ];

    public $image;

    public $personnelInfo = [
        "employee_number" => null,
        "social_number"=>null,
        "last_name_ar" => null,
        "first_name_ar" => null,
        "last_name_fr" => null,
        "first_name_fr" => null,
        "card_number" => null,
        "birth_place_ar" => null,
        "birth_place_fr" => null,
        "birth_place_en" => null,
        "birth_date" => null,
        "address_fr" => null,
        "address_ar" => null,
        "address_en" => null,
        "phone" => null,
    ];

    /**
     * Define validation rules.
     */
    public function rules(): array
    {


        return [
            'default.establishment_id' => [
               'nullable',
               'integer',
               Rule::exists('establishments', 'id'),
             ],
            'default.service_id' => [
               'nullable',
               'integer',
               Rule::exists('services', 'id'),
             ],

            'default.email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users', 'email')->whereNull('deleted_at'),

            ],
           'personnelInfo.employee_number' => [
                  'nullable',
                  'string',
                  'size:10',
                   Rule::unique('personnel_infos', 'employee_number')->whereNull('deleted_at'),
                ],
           'personnelInfo.social_number' => [
                  'nullable',
                  'string',
                  'size:20',
                   Rule::unique('personnel_infos', 'social_number')->whereNull('deleted_at'),
                ],
            'personnelInfo.last_name_fr' => 'required|string|min:3|max:100',
            'personnelInfo.first_name_fr' => 'required|string|min:3|max:100',
            'personnelInfo.last_name_ar' => 'required|string|min:3|max:100',
            'personnelInfo.first_name_ar' => 'required|string|min:3|max:100',
            'personnelInfo.card_number' => [
                'nullable', 'string', 'min:6',
                Rule::unique('personnel_infos', 'card_number')->whereNull('deleted_at'),
            ],
            'personnelInfo.birth_place_fr' => 'nullable|string|min:3|max:200',
            'personnelInfo.birth_place_ar' => 'nullable|string|min:3|max:200',
            'personnelInfo.birth_place_en' => 'nullable|string|min:3|max:200',
            'personnelInfo.birth_date' => [
                'nullable', 'date', 'date_format:Y-m-d',
                'after:1920-01-01',
                'before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            ],
            'personnelInfo.address_fr' => 'nullable|string|min:3|max:400',
            'personnelInfo.address_ar' => 'nullable|string|min:3|max:400',
            'personnelInfo.address_en' => 'nullable|string|min:3|max:400',
            'personnelInfo.phone' => [
                'nullable',
                'regex:/^(05|06|07)\d{8}$/',
                Rule::unique('personnel_infos', 'phone')->whereNull('deleted_at'),
            ],
            'image' => 'nullable|file|mimes:jpeg,png,gif,ico,webp|max:10000',
        ];
    }

    /**
     * Custom validation attribute names.
     */


    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('user', ["service_id",
            'email','employee_number','social_number','is_active','last_name_fr','last_name_ar','first_name_fr','first_name_ar','card_number','birth_place_fr','birth_place_en','birth_date','address_fr','address_ar','address_en','phone',
        ]);
    }
    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'personnelInfo.phone.regex' => __("forms.common.errors.not_match.phone"),
        ];
    }

    /**
     * Save form data.
     */
    public function save(): array
    {
        try {
            $data = $this->validate();



            return DB::transaction(function () use ($data) {
                // Create user


                $user = $this->createUser($data);
                 $message =__("forms.user.responses.add.user",['name'=> $user->localized_name]);
                // Handle image upload if provided
                if ($this->image) {
                    $this->uploadImage($user);
                }

                // Create personnel info
                $this->createPersonnelInfo($user, $data['personnelInfo']);

                // Assign role
                $this->assignDefaultRole($user);

             if(isset($data['default']['establishment_id']) || isset($data['default']['service_id'])){

                $message =__("forms.user.responses.add.personnel",['name'=> $user->localized_name]);
            }
                return $this->response(true, message: $message);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('User creation error: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }

    /**
     * Create a new user.
     */
    protected function createUser(array $data): User
    {
        return User::create([
            "establishment_id" => $data['default']['establishment_id'],
            "service_id" => $data['default']['service_id'],
            "name_fr" => "{$data['personnelInfo']['last_name_fr']} {$data['personnelInfo']['first_name_fr']}",
            "name_ar" => "{$data['personnelInfo']['last_name_ar']} {$data['personnelInfo']['first_name_ar']}",
            "email" => $data['default']['email'],
            "password" => Hash::make("Vide=1342"),
        ]);
    }

    /**
     * Upload and associate an image with the user.
     */
    protected function uploadImage(User $user): void
    {
        $this->uploadAndCreateImage($this->image, $user->id, User::class, "profile_pic");
    }

    /**
     * Create personnel info for the user.
     */
    protected function createPersonnelInfo(User $user, array $personnelInfo): void
    {
        PersonnelInfo::create(array_merge($personnelInfo, ['user_id' => $user->id]));
    }

    /**
     * Assign the default role to the user.
     */
private function assignDefaultRole(User $user): void
{
    $defaultRoleSlug = config('defaultRole.default_role_slug', 'user');
    $defaultRole     = Role::where('slug', $defaultRoleSlug)->first();

    if ($defaultRole) {
        $user->roles()->attach($defaultRole->id);
    } else {
        Log::warning("Default role '{$defaultRoleSlug}' not found during user creation.");
    }

    // Check if current authenticated user has role 'establishment_admin'
    if (auth()->check() && auth()->user()->roles()->where('slug', 'establishment_admin')->exists()) {
        $serviceAdminRole = Role::where('slug', 'service_admin')->first();

        if ($serviceAdminRole) {
            $user->roles()->attach($serviceAdminRole->id);
        } else {
            Log::warning("Service admin role not found when assigning to user ID {$user->id}");
        }
    }
}

}
