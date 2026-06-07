<?php

namespace App\Livewire\Default\Guest\ForgotPassword;

use App\Livewire\Forms\ForgotPassword\FirstForm;
use Livewire\Component;

class FirstStep extends Component
{

    public FirstForm $form;
    public $forgetPasswordEmail;

 public function handleSubmit()
 {
     $this->dispatch('form-submitted');

     $response =  $this->form->save();
    if ($response['status']) {
        $this->dispatch('open-toast', $response['message']); // Corrected the variable name
        $this->dispatch('fp-first-step-succeeded',$this->form->email);
         $this->form->reset();
      }else{
         $this->dispatch('open-errors', $response['errors']);
      }

 }

    public function render()
    {
        return view('livewire.default.guest.forgot-password.first-step');
    }
}
