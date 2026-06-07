<?php

namespace App\View\Components\Default\Table;

use App\Traits\Common\GeneralTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Log;

class Link extends Component
{
    use GeneralTrait;

    public string $routeUrl;
    public ?string $iconHtml;
    public function __construct(
        public string $route,
        public string $icon,
        public array $parameters = [],
        public bool $newTab = false,
        public ?string $toolTipMessage = null
    ) {
        // Resolving route name and URL
        $routeName = $this->resolveRouteName($this->route);
        $this->routeUrl = $routeName ? route($routeName, $this->parameters) : '#';
        // Resolve icon HTML
        $iconsArray = config('constants')['ICONS'] ?? [];
        $this->iconHtml = $iconsArray[$this->icon] ?? '<svg><!-- Default Icon --></svg>'; // Default fallback icon
    }

    public function render(): View|Closure|string
    {
        return view('components.default.table.link', [
            'routeUrl' => $this->routeUrl,
            'iconHtml' => $this->iconHtml,
            'toolTipMessage' => $this->toolTipMessage,
            'newTab' => $this->newTab,
        ]);
    }
}
