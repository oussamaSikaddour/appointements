<?php

namespace App\Livewire\Forms\User;

use App\Models\PersonnelInfo;
use App\Models\User;
use App\Traits\Common\ModelFileTrait;
use App\Traits\Common\ModelImageTrait;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Form;

class UpdateForm extends Form
{
    use ResponseTrait, ModelImageTrait, ModelFileTrait;

    public $default = [
        'id' => null,
        'is_active' => null,
         'email'=>null,
        'service_id'=>null,
        'establishment_id'=>null,
    ];

    public $image;
    public $personnelInfo = [
        'user_id' => null,
        'last_name_fr' => null,
        'first_name_fr' => null,
        'last_name_ar' => null,
        'first_name_ar' => null,
        'card_number' => null,
        'birth_place_fr' => null,
        'birth_place_ar' => null,
        'birth_place_en' => null,
        'birth_date' => null,
        'address_fr' => null,
        'address_ar' => null,
        'address_en' => null,
        'phone' => null,
        'is_paid' => null,
        'employee_number' => null,
        "social_number"=>null
    ];

    public function rules()
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
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users','email')->ignore($this->default['id'])->whereNull('deleted_at'),
            ],
            'default.id' => 'required|exists:users,id',
            'personnelInfo.user_id' => 'required|exists:users,id',
            'image' => 'nullable|file|mimes:jpeg,png,gif,ico,webp|max:10000',
            'personnelInfo.is_paid' => 'required|boolean',
            'default.is_active' => 'required|boolean',
            'personnelInfo.employee_number' => [
                'nullable', 'nullable', 'string', 'size:10',
                   Rule::unique('personnel_infos', 'employee_number')
                 ->whereNull('deleted_at')
                ->ignore(
                  PersonnelInfo::where('user_id', $this->default['id'])->first()?->id
                ),
            ],
            'personnelInfo.employee_number' => [
                'nullable', 'nullable', 'string', 'size:10',
                   Rule::unique('personnel_infos', 'employee_number')
                 ->whereNull('deleted_at')
                ->ignore(
                  PersonnelInfo::where('user_id', $this->default['id'])->first()?->id
                ),
            ],
            'personnelInfo.social_number' => [
                'nullable', 'nullable', 'string', 'size:20',
                   Rule::unique('personnel_infos', 'social_number')
                 ->whereNull('deleted_at')
                ->ignore(
                  PersonnelInfo::where('user_id', $this->default['id'])->first()?->id
                ),
            ],
            'personnelInfo.last_name_fr' => 'nullable|string|min:3|max:100',
            'personnelInfo.first_name_fr' => 'nullable|string|min:3|max:100',
            'personnelInfo.last_name_ar' => 'nullable|string|min:3|max:100',
            'personnelInfo.first_name_ar' => 'nullable|string|min:3|max:100',
            'personnelInfo.card_number' => [
                'nullable', 'string', 'min:6', 'max:255',
                Rule::unique('personnel_infos', 'card_number')->whereNull('deleted_at'),
            ],
            'personnelInfo.birth_place_fr' => 'nullable|string|min:3|max:200',
            'personnelInfo.birth_place_ar' => 'nullable|string|min:3|max:200',
            'personnelInfo.birth_place_en' => 'nullable|string|min:3|max:200',
            'personnelInfo.birth_date' => 'nullable|date|date_format:Y-m-d|after:1920-01-01|before:' . Carbon::now()->subYears(18)->format('Y-m-d'),
            'personnelInfo.address_fr' => 'nullable|string|min:3|max:400',
            'personnelInfo.address_ar' => 'nullable|string|min:3|max:400',
            'personnelInfo.address_en' => 'nullable|string|min:3|max:400',
            'personnelInfo.phone' => [
                'nullable', 'regex:/^(05|06|07)\d{8}$/',
                Rule::unique('personnel_infos', 'tel')->whereNull('deleted_at')->ignore(
                  PersonnelInfo::where('user_id', $this->default['id'])->first()?->id
                ),
            ],
        ];
    }



        public function messages(): array
    {
        return [
            'personnelInfo.phone.regex' => __("forms.common.errors.not_match.phone"),
        ];
    }
    public function validationAttributes(): array
    {
        return $this->returnTranslatedResponseAttributes('user', ['service_id',
            'email','employee_number','is_paid','is_active','last_name_fr','last_name_ar','first_name_fr','first_name_ar','card_number','birth_place_fr','birth_place_en','birth_date','address_fr','address_ar','address_en','phone'
        ]);
    }
    public function save()
    {
        try {
            $data = $this->validate();

            $user = User::findOrFail($this->default['id']);
            return DB::transaction(function () use ($data, $user) {
                $message =__("forms.user.responses.update.user",['name'=> $user->localized_name]);
                $pInfo = $user->personnelInfo;
                if ($pInfo) {
                    $pInfo->update($data['personnelInfo']);
                    $user->update([
                        'name_fr' => "{$pInfo['last_name_fr']} {$pInfo['first_name_fr']}",
                        'name_ar' => "{$pInfo['last_name_ar']} {$pInfo['first_name_ar']}",
                    ]);
                }
                if ($this->image) {
                    $this->uploadAndUpdateImage($this->image, $user->id, User::class, 'profile_pic');
                }
                $user->update($data['default']);

             if(isset($data['default']['establishment_id']) || isset($data['default']['service_id'])){


                $message =__("forms.user.responses.add.personnel",['name'=> $user->localized_name]);
            }
                return $this->response(true, message: $message);
            });
        } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        } catch (\Exception $e) {
            Log::error('Error in user update form: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
        }
    }
}
