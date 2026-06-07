<?php

namespace App\Livewire\Default;

use Livewire\Attributes\On;
use Livewire\Component;

class ErrorsHandler extends Component
{
    public $isOpen = false;
    public $errors = [];

    #[On('open-errors')]
    public function openErrors($errors)
    {
        $this->toggleErrors($errors);
    }

    public function toggleErrors($errors)
    {
        // Ensure $errors is always an array, even if it's passed as a string
        if (is_string($errors)) {
            $errors = explode("\n", $errors); // Split the string into an array of errors
        }

        // Process the errors array
        $processedErrors = [];
        foreach ($errors as $error) {
            // Trim the error to avoid leading/trailing spaces
            $trimmedError = trim($error);

            // If the error is not empty or just whitespace, we process it
            if ($trimmedError !== '') {
                // Check if the error contains "\n" and split it into multiple entries
                if (str_contains($trimmedError, "\n")) {
                    // Split the error by newline and add each part to the processedErrors array
                    $splitErrors = explode("\n", $trimmedError);
                    foreach ($splitErrors as $splitError) {
                        // Ensure no empty or just-whitespace errors are added
                        $processedErrors[] = trim($splitError);
                    }
                } else {
                    // If it's a single line error, simply add it
                    $processedErrors[] = $trimmedError;
                }
            }
        }


        // Update the errors array with the processed errors
        $this->errors = count($processedErrors) > 0 ? $processedErrors : [];
        // Toggle the visibility of the errors panel
        $this->isOpen = !$this->isOpen;

        // Notify other components about the state change
        $this->dispatch("handle-errors-state");
    }

    public function render()
    {
        return view('livewire.default.errors-handler');
    }
}
