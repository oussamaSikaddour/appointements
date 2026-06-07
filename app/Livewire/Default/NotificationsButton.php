<?php

namespace App\Livewire\Default;

use App\Enum\Web\RoutesNames;
use App\Models\Notification;
use Livewire\Attributes\Computed;
use Livewire\Component;

class NotificationsButton extends Component
{
    public $notificationsCount = 0;

    // Refresh the notifications on the frontend
    public function refreshNotifications()
    {
        $this->dispatch('refresh-notifications');
    }

    // Computed property to fetch notifications
    #[Computed()]
    public function notifications()
    {
        $query = Notification::query();

        // Admin-specific notifications
        if (auth()->user()->can('super-admin-access')) {
            $query->where('active', true)
                ->where('targetable_type', 'super-admin');
        } else {
            $query->where('targetable_id', auth()->user()->id)
                ->where('active', true);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    // Mount method to set the notification count
    public function mount()
    {
        $this->notificationsCount = $this->notifications->count();
    }

    // Manage notification (mark as inactive and handle redirection)
    public function manageNotification(Notification $notification)
    {
        $notification->update(['active' => false]);


        if ($notification->for_type === "message") {
            return redirect()->route(RoutesNames::MESSAGES);
        }
    }

    public function render()
    {
        return view('livewire.default.notifications-button');
    }
}
