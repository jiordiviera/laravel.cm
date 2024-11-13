<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

final class CheckIfBanned
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $user = Auth::user();
        
            if ($user && $user->banned_at) {
                Auth::logout();
                
                return redirect()->route('login')->withErrors([
                    'email' => __('global.ban.message'),
                ]);
            }
        }
        
        return $next($request);
    }
}