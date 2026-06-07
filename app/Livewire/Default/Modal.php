<?php

namespace App\Livewire\Default;

use Livewire\Attributes\On;
use Livewire\Component;

class Modal extends Component
{


    public $isOpen = false;
    public $title = "";
    public $titleOptions=[];
    public $type = "";
    public $component = [];
    public $containsTinyMce = false;

    #[On("open-modal")]
    public function openModal($data)
    {
        $this->isOpen = true;
        $this->title = $data['title'] ?? '';
        $this->titleOptions=$data['title_options']?? [];
        $this->type = $data['type'] ?? '';
        $this->component = $data['component'] ?? [];
        $this->containsTinyMce = $data['containsTinyMce'] ?? false;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->reset(); // Reset all properties to their default values
    }


    public function render()
    {
        return view('livewire.default.modal');
    }
}
