<?php

namespace App\Livewire\Default\Guest\Register;

use App\Events\Default\Auth\VerificationEmailEvent;
use App\Livewire\Forms\Register\LastForm;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class LastStep extends Component
{

    public LastForm $form;

    public function setEmail($email)
    {
        $this->form->email =$email;
    }
    public function setNewValidationCode(){
        try {
            $user = User::where('email', $this->form->email)->first();
            event(new VerificationEmailEvent($user));
            $this->dispatch('open-toast',__('forms.register.steps.last.new-verification-mail'));
            } catch (\Exception $e) {
                Log::error('Register setNewValidationCode error: ' . $e->getMessage());
                $this->dispatch('open-errors', __('forms.common.errors.default'));
            }
    }
    public function handleSubmit()
    {
        $this->dispatch('form-submitted','.form--2');
        $response =  $this->form->save();
       if ($response['status']) {
         $this->reset();
         $this->dispatch('second-step-succeeded');
         return  $this->redirectRoute($response['data']['route']);
         }else{
            $this->dispatch('open-errors', $response['errors']);
         }

    }

    public function render()
    {
        return view('livewire.default.guest.register.last-step');
    }
}
