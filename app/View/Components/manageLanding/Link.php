<?php

namespace App\View\Components\manageLanding;

use App\Traits\Common\GeneralTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Component;

class Link extends Component
{
    use GeneralTrait;
    public string $routeUrl;

    public function __construct(
        public string $route,
        public string $label,
        public string $img,
        public array $parameters = [],
    ) {

        // Resolve the route name from the enum or use it directly
        $routeName = $this->resolveRouteName($route);

        // Generate the route URL and determine if it's active
        $this->routeUrl = $routeName ? route($routeName, $this->parameters) : '#';

    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.manage-landing.link',
        [
            'routeUrl' => $this->routeUrl,
        ]

    );
    }

}
