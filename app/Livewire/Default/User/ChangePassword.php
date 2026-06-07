<?php

namespace App\Livewire\Default\User;

use App\Enum\Web\RoutesNames;
use App\Livewire\Forms\ChangePasswordForm;
use Livewire\Attributes\Computed;
use Livewire\Component;

class ChangePassword extends Component
{


    public ChangePasswordForm $form;

    public function handelSubmit()
    {
        $this->dispatch('form-submitted');
        $response = $this->form->save();

        if ($response['status']) {
            $this->dispatch('redirect-page');
            $this->dispatch('open-toast', $response['message']);
        } else {
            $this->dispatch('open-errors', $response['errors']);
        }
    }


    #[Computed()]
    public function logoutRoute(){
        return RoutesNames::LOG_OUT->value;
    }

    public function render()
    {
        return view('livewire.default.user.change-password');
    }
}
