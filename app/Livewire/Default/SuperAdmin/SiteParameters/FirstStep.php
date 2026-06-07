<?php

namespace App\Livewire\Default\SuperAdmin\SiteParameters;

use App\Livewire\Forms\SiteParameters\FirstStepForm;
use App\Traits\Common\GeneralTrait;
use Livewire\Component;

class FirstStep extends Component
{


    public FirstStepForm $form;
    public function handleSubmit()
    {
        $this->dispatch('form-submitted');
        $response =  $this->form->save();
       if ($response['status']) {
           $this->dispatch('open-toast', $response['message']); // Corrected the variable name
           $this->dispatch('sp-first-step-succeeded');
            $this->form->reset();
         }else{
            $this->dispatch('open-errors', $response['errors']);
         }

    }


    public function render()
    {
        return view('livewire.default.super-admin.site-parameters.first-step');
    }
}
