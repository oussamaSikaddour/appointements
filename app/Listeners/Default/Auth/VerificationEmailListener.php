<?php

namespace App\Listeners\Default\Auth;

use App\Events\Default\Auth\VerificationEmailEvent;
use App\Mail\Auth\VerificationMail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class VerificationEmailListener
{
    /**
     * Handle the event.
     *
     * @param VerificationEmailEvent $event The event that was fired, containing the User model
     */
    public function handle(VerificationEmailEvent $event): void
    {
        // Retrieve the user from the event
        $user = $event->user;

        // Send the verification email to the user's email address
        Mail::to($user->email)->send(new VerificationMail($user));
    }
}
