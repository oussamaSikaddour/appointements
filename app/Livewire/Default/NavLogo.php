<?php

namespace App\Livewire\Default;

use App\Enum\Web\RoutesNames;
use App\Models\GeneralSetting;
use Livewire\Attributes\Computed;
use Livewire\Component;

class NavLogo extends Component
{
    public $gSettings;
    public $route;

    public function mount()
    {
        // Retrieve general settings with caching

        $this->route= RoutesNames::INDEX;
        $this->gSettings = cache()->remember('general_settings', 3600, function () {
            return GeneralSetting::with('logo')->first();
        });
    }

    // Computed property for logo URL
    #[Computed]
    public function logoUrl()
    {
        return $this->gSettings?->logo?->url ?? asset('img/logo.png');
    }

    public function render()
    {
        return view('livewire.default.nav-logo');
    }
}
