<?php

namespace App\Livewire\Forms\Register;

use App\Models\User;
use App\Traits\Web\ResponseTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Otp;
class LastForm extends Form
{
    use ResponseTrait;
    public $code ='';
    public $email ="";

    // Livewire rules
    public function rules()
    {
        return [
            'email' => ['required', 'email', "exists:users,email"],
            'code' => ['required', 'max:6'],
        ];
    }


    public function validationAttributes()
    {
        return [

            'email' => __("forms.register.email"),
            'code' => __("forms.register.steps.last.code")
            // Add more attribute names as needed
        ];
    }




    public function save()
    {
        // Validate the form data
        try {
            $data = $this->validate();

               // Attempt to find the user by email
                $user = User::where('email', $data['email'])->first();
                // Create an instance of the Otp class
                 $otp = new Otp();
                 // Validate the OTP code for the provided email
                 $validationResult = $otp->validate($data['email'], $data['code']);
               if ($validationResult->status){
                  // Update the user's password
                    // Authenticate the user
                   Auth::login($user);
                  $route = $user->resolveRedirectRouteForUser();
                     return $this->response(true, data:["route"=>$route]);

                  } else {
                    throw new \Exception(__("forms.register.errors.verification_code"));
                 }

          } catch (\Illuminate\Validation\ValidationException $e) {
            return $this->response(false, errors: $e->validator->errors()->all());
        }
        catch (\Exception $e) {
            Log::error('ForgotPassword last form error: ' . $e->getMessage());
            return $this->response(false, errors: __('forms.common.errors.default'));
       }

    }
}
