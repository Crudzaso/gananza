<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminPasswordVerification
{
    public function handle(Request $request, Closure $next)
    {
        // Si no es admin, ni siquiera continuamos
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            return redirect()->route('login');
        }

        $currentPath = $request->path();
        
        // Si NO estamos en una ruta que comience con 'admin', limpiamos la sesión
        if (!str_starts_with($currentPath, 'admin')) {
            Session::forget('admin_password_verified');
            return $next($request);
        }
        
        // Si es específicamente la ruta 'admin' y no está verificado, pedimos verificación
        if ($currentPath === 'admin' && !Session::has('admin_password_verified')) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json(['require_password' => true], 403);
            }
            return redirect()->route('admin.verify-password');
        }

        return $next($request);
    }
}