<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Filter role who can access the route. Admin is allways!
 */
class RoleRestriction
{
    /**
     * Summary of handle
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param array<string> $roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        if(!$user->is_admin) {
            if(!in_array($user->role, $roles)) {
                return redirect()->route('dashboard')->withErrors('Kamu tidak memiliki akses ke halaman yang dituju.');
            }
        }
        return $next($request);
    }
}
