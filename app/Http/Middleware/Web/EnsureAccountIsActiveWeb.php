<?php

namespace App\Http\Middleware\Web;

use App\Enum\Web\RoutesNames;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountIsActiveWeb
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && !$user->is_active) {
            auth()->logout();
            return redirect()->route(RoutesNames::TOGGLE_ACCOUNT_STATUS->value);
        }

        return $next($request);
    }
}
