<?php

namespace App\View\Components\Default\Nav;

use App\Traits\Common\GeneralTrait;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DropdownLink extends Component
{
    use GeneralTrait;

    public string $renderedItems;
    public array $icons;

    public function __construct(
        public array $items = [],
        public string $dropdownLink = ''
    ) {
        $this->icons = config('constants.ICONS', []);
        $this->renderedItems = $this->renderItems($items);
    }

    protected function renderItems(array $items): string
    {
        return collect($items)->map(function ($item) {
            $isDirectLink = $item['directLink'] ?? false;
            $routeUrl = $this->resolveRouteUrl($item, $isDirectLink);
            $isActive = !$isDirectLink && $this->isRouteActive($item['route'] ?? '');

            return sprintf(
                '<li role="none" class="%s"><a href="%s" role="menuitem">%s%s</a></li>',
                e($isActive ? 'active' : ''),
                e($routeUrl),
                e($item['label'] ?? ''),
                $this->getIconHtml($item['icon'] ?? null)
            );
        })->implode('');
    }

    protected function resolveRouteUrl(array $item, bool $isDirectLink): string
    {
        if ($isDirectLink) {
            return $item['route'] ?? '#';
        }

        $routeName = $this->resolveRouteName($item['route'] ?? '');
        return $routeName ? route($routeName, $item['parameters'] ?? []) : '#';
    }

    protected function isRouteActive(string $routeName): bool
    {
        return $routeName && request()->routeIs($routeName);
    }

    protected function getIconHtml(?string $icon): string
    {
        return $icon && isset($this->icons[$icon])
            ? sprintf('<span aria-hidden="true">%s</span>', $this->icons[$icon])
            : '';
    }

    public function render(): View|Closure|string
    {
        return view('components.default.nav.dropdown-link', [
            'dropdownLink' => $this->dropdownLink,
            'renderedItems' => $this->renderedItems,
        ]);
    }
}
