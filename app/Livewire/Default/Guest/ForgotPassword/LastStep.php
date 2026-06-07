<?php

namespace App\Livewire\Default\Guest\ForgotPassword;

use App\Enum\Web\RoutesNames;
use App\Livewire\Forms\ForgotPassword\LastForm;
use Livewire\Component;

class LastStep extends Component
{


    public LastForm $form;



    public function setEmail($email){
        $this->form->email = $email;
    }

    public function handleSubmit()
    {
        $this->dispatch('form-submitted','.form-fp-l');
        $response =  $this->form->save();
        if ($response['status']) {
            $this->reset();
            $this->dispatch('fp-second-step-succeeded');
            redirect()->route(RoutesNames::USER_ROUTE->value);
            }else{
               $this->dispatch('open-errors', $response['errors']);
            }

    }
    public function render()
    {
        return view('livewire.default.guest.forgot-password.last-step');
    }
}
