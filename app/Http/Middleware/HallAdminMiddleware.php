<?php

namespace App\Http\Middleware;

use App\Enum\UserTypeEnum;
use Closure;
use Filament\Facades\Filament;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class HallAdminMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        $user = Filament::auth()->user();

        if (!$user || $user->type !== UserTypeEnum::WEDDING_ADMIN->value) {
            // Log out the user if they're logged in
            if ($user) {
                Filament::auth()->logout();
            }

            // Get the current panel
            $panel = Filament::getCurrentPanel();

            // Redirect to login page with error message
            return redirect($panel->getLoginUrl())
                ->with('error', 'Access denied. This area is restricted to wedding admin users only.');
        }

        return $next($request);
    }

}
