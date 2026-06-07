<?php

namespace App\Providers;

use App\Enum\Web\RoutesNames;
use App\Policies\UserPolicy;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // No additional services to register here
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Redirect unauthenticated users to login route
        Authenticate::redirectUsing(
            fn ($request) => route(RoutesNames::LOGIN->value)
        );

        $this->definePolicyGates();
        $this->defineSessionBasedGates();
    }

    /**
     * Define gates that use UserPolicy methods.
     */
    protected function definePolicyGates(): void
    {
        $gates = [
            'super-admin-access'   => 'isSuperAdmin',
            'admin-access'         => 'isAdmin',
            'author-access'        => 'isAuthor',
            'user-access'          => 'isUser',
            'only-owner-access'    => 'onlyOwner',
            'approver-access'      => 'isApprover',
            'doctor-access'        => 'isDoctor',
            'has-any-role'         => 'hasAnyRole',
        ];

        foreach ($gates as $gate => $method) {
            Gate::define($gate, [UserPolicy::class, $method]);
        }
    }

    /**
     * Define session-based gates (for contextual admin access).
     */
    protected function defineSessionBasedGates(): void
    {
        $this->defineSessionGate(
            gate: 'establishment-admin-access',
            sessionKey: 'establishment_id',
            userField: 'establishment_id',
            roleSlug: 'establishment_admin'
        );

        $this->defineSessionGate(
            gate: 'appointments-location-admin-access',
            sessionKey: 'appointments_location_id',
            userField: 'appointments_location_id',
            roleSlug: 'appointments_location_admin'
        );

        $this->defineSessionGate(
            gate: 'service-admin-access',
            sessionKey: 'service_id',
            userField: 'service_id',
            roleSlug: 'service_admin'
        );
    }

    /**
     * Helper to register session-based gates.
     */
    protected function defineSessionGate(
        string $gate,
        string $sessionKey,
        string $userField,
        string $roleSlug
    ): void {
        Gate::define($gate, function ($user) use ($sessionKey, $userField, $roleSlug) {
            $sessionId = session($sessionKey);

            if (empty($sessionId) || (int) $user->{$userField} !== (int) $sessionId) {
                return false;
            }

            if (!$user->relationLoaded('roles')) {
                $user->load('roles');
            }

            return $user->roles->pluck('slug')->contains($roleSlug);
        });
    }
}
