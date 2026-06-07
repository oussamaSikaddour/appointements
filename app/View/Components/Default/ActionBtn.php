<?php

namespace App\View\Components\Default;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use Illuminate\Support\Str;

class ActionBtn extends Component
{
    public string $iconHtml;
    public string $htmlId;

    /**
     * Create a new component instance.
     *
     * @param string|null $htmlId The unique identifier for the button (default: random).
     * @param string $tooltip The tooltip text to display on hover.
     * @param string $icon The key for the icon in the configuration.
     * @param string $function The Livewire function name to call.
     * @param array $parameters The parameters to pass to the Livewire function.
     */
    public function __construct(
        public string $tooltip,
        public string $icon,
        public string $function,
        public array $parameters = []
    ) {
        $this->htmlId = 'id-' . Str::random(8); // Generate a random ID if none is provided
        $this->iconHtml = $this->resolveIconHtml($icon);
    }

    private function getIconFromConfig(string $icon): string
    {
        return config("constants.ICONS.$icon", '<i class="fa-solid fa-question"></i>'); // Default icon
    }

    private function resolveIconHtml(string $icon): string
    {
        $iconHtml = $this->getIconFromConfig($icon);
        if (empty($iconHtml)) {
            Log::warning("Icon '$icon' not found in configuration.");
        }
        return $iconHtml;
    }

    public function render(): View|Closure|string
    {
        return view('components.default.action-btn', [
            'iconHtml' => $this->iconHtml,
            'htmlId' => $this->htmlId,
            'ariaLabel' => $this->tooltip,
            'function' => $this->function,
            'parameters' => $this->parameters
        ]);
    }
}
