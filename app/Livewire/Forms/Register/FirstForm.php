<?php

namespace App\Livewire\Forms\Register;

use App\Events\Default\Auth\VerificationEmailEvent;
use App\Models\PersonnelInfo;
use App\Models\Role;
use App\Models\User;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Validate;
use Livewire\Form;

class FirstForm extends Form
{
    use ResponseTrait;
    public $email ='';
    public $password ="";




    // Livewire rules
    public function rules()
    {
        return [
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users','email')->whereNull('deleted_at'),
            ],


            'password' => 'required|min:8|max:255',

        ];
    }


    public function validationAttributes()
    {
        return [
             'email' => __('forms.register.email'),
             'password' =>__('forms.register.steps.first.password'),
        ];
    }

// Import the DB facade

    public function save()
    {
                // Validate the form data
                try {
                    $data = $this->validate();



        return DB::transaction(function () use($data) {

                $default = [
                    'email' => $data['email'],
                    "password" => Hash::make($data['password']),
                ];
                $user = User::create($default);

                $personalInfo = [
                    'user_id' => $user->id,
                ];
                PersonnelInfo::create($personalInfo);

                event(new VerificationEmailEvent($user));

                $defaultRoleSlugs = [config('defaultRole.default_role_slug', 'user')];
                $user->roles()->attach(Role::whereIn('slug', $defaultRoleSlugs)->get());

                return $this->response(true,message:__('forms.register.responses.new_code'));
            });
               } catch (\Illuminate\Validation\ValidationException $e) {
                return $this->response(false, errors: $e->validator->errors()->all());
            }
            catch (\Exception $e) {
                Log::error('Register first form error: ' . $e->getMessage());
                return $this->response(false, errors: __('forms.common.errors.default'));
            }

    }
}
