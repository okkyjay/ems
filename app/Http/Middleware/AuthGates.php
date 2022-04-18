<?php

namespace App\Http\Middleware;

use App\EMS\Role\Role;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthGates
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if ($user) {
            $roles = Role::with('permissions')->get();
            $permissionsArray = [];
            foreach ($roles as $role) {
                foreach ($role->permissions as $permissions) {
                    $permissionsArray[$permissions->title][] = $role->id;
                }
            }
            foreach ($permissionsArray as $title => $roles) {
                Gate::define($title, function ($user) use ($roles) {
                    return count(array_intersect([$user->role_id], $roles)) > 0;
                });
            }
        }

        return $next($request);
    }
}