<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureRole
{
    /**
     * Role names are: admin, doctor, patient, staff
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $role = strtolower($role);

        $roleName = null;

        if (Auth::guard('web_admin')->check()) {
            $user = Auth::guard('web_admin')->user();
            $roleName = strtolower(optional($user?->role)->name ?? 'admin');
        } elseif (Auth::guard('web_user')->check()) {
            $user = Auth::guard('web_user')->user();
            $roleName = strtolower(optional($user?->role)->name ?? 'patient');
        } elseif (Auth::guard('web_employee')->check()) {
            $user = Auth::guard('web_employee')->user();
            $roleName = strtolower(optional($user?->role)->name);
        }

        if ($roleName === $role) {
            return $next($request);
        }

        abort(403);
    }
}

