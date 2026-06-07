<?php

namespace App\Livewire\Default\Guest;

use App\Enum\Web\RoutesNames;
use App\Livewire\Forms\LoginForm;
use Livewire\Attributes\Computed;
use Livewire\Component;

class Login extends Component
{

    public LoginForm $form;


    #[Computed()]
    public function forgetPasswordRoute(){
        return RoutesNames::FORGET_PASSWORD->value;
    }
    #[Computed()]
    public function registerPageRoute(){
        return RoutesNames::REGISTER->value;
    }





    public function handelSubmit()
    {

        $this->dispatch('form-submitted');
        $response =  $this->form->save();
        $this->form->reset();
       if ($response['status']) {
        return  $this->redirectRoute($response['data']['route']);
       }else{
        $this->dispatch('open-errors', $response['errors']);
         }
    }
    public function render()
    {
        return view('livewire.default.guest.login');
    }
}
