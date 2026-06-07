<?php

namespace App\Livewire\Default;

use Livewire\Component;

class TinyMceTextArea extends Component
{

    public $content = "";
    public $htmlId = "";
    public $contentUpdatedEvent = 'content-updated'; // Default event name


    public function mount()
    {
        $this->dispatch('initialize-tiny-mce'); // Emit event to initialize on mount
    }

    public function setContent($value)
    {
        $this->content = $value;
        $this->dispatch($this->contentUpdatedEvent, $value); // Dispatch default event
    }

    public function render()
    {
        return view('livewire.default.tiny-mce-text-area');
    }
}
