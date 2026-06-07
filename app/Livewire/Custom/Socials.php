<?php

namespace App\Livewire\Custom;

use App\Models\Social;
use Illuminate\Support\Facades\Cache;
use Livewire\Component;



    class Socials extends Component
    {
        public $socialLinks = [];

        public function mount()
        {
            // Retrieve social links with caching
            $this->socialLinks = Cache::remember('social_links', 3600, function () {
                return Social::first()?->toArray() ?? [];
            });
        }

    public function render()
    {
        return view('livewire.custom.socials');
    }
}
