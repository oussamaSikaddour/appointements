<?php

namespace App\View\Components\Default\Form;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Selector extends Component
{
    public function __construct(
        public string $model,
        public string $htmlId,
        public string $label,
        public array $data,
        public string $type = '',
        public bool $showError = false,
        public ?string $toTranslate = null
    ) {}

    /**
     * Translate option labels if needed.
     */


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.default.form.selector', [
            'data' => $this->data,
        ]);
    }
}
