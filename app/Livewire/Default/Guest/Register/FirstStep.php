<?php

namespace App\Livewire\Default\Guest\Register;

use App\Enum\Web\RoutesNames;
use App\Livewire\Forms\Register\FirstForm;
use Livewire\Attributes\Computed;
use Livewire\Component;

class FirstStep extends Component
{


    public $registrationEmail;
    public FirstForm $form;

     #[Computed()]
    public function loginRoute(){
        return RoutesNames::LOGIN->value;
    }
    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $this->registrationEmail = $this->form->email;
        $response =  $this->form->save();
       if ($response['status']) {
        $this->dispatch('open-toast', $response['message']); // Corrected the variable name
        $this->dispatch('first-step-succeeded', $this->registrationEmail);
            $this->form->reset();
         }else{
            $this->dispatch('open-errors', $response['errors']);
         }

    }
    public function render()
    {
        return view('livewire.default.guest.register.first-step');
    }
}
