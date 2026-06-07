<?php

namespace App\Livewire\Default;

use Livewire\Attributes\On;
use Livewire\Component;

class Toast extends Component
{

    public bool $isOpen = false; // Controls the visibility of the toast
    public string $message = ""; // The message to display in the toast

    /**
     * Open the toast with a message.
     *
     * @param string $message - The message to display.
     */
    #[On('open-toast')]
    public function openToast(string $message)
    {
        $this->message = $message;
        $this->toggleToast();
    }

    /**
     * Toggle the toast's visibility.
     */
    public function toggleToast()
    {
        $this->isOpen = !$this->isOpen;
        $this->dispatch("handle-toast-state"); // Notify the frontend of the state change
    }

    public function render()
    {
        return view('livewire.default.toast');
    }
}
