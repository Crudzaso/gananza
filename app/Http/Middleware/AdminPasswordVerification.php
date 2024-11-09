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
        // Verificar si el usuario está autenticado y tiene el rol de 'admin'
        if (!Auth::check() || !Auth::user()->hasRole('admin')) {
            return redirect()->route('login');
        }

        $currentPath = $request->path();

        // Solicitar verificación de contraseña para /admin y sus subrutas
        if ($currentPath === 'admin' || str_starts_with($currentPath, 'admin/')) {
            if (!Session::has('admin_password_verified')) {
                // Guardar la URL intentada para redireccionar después de la verificación
                $request->session()->put('url.intended', $request->fullUrl());
                return redirect()->route('admin.verify-password');
            }

            // Limpiar el estado de verificación después del acceso
            Session::forget('admin_password_verified');
            return $next($request);
        }

        // Solicitar verificación de contraseña para /dashboard/admin
        if ($currentPath === 'dashboard/admin') {
            if (!Session::has('admin_password_verified')) {
                // Guardar la URL intentada para redireccionar después de la verificación
                $request->session()->put('url.intended', $request->fullUrl());
                return redirect()->route('admin.verify-password');
            }

            // Limpiar el estado de verificación después del acceso
            Session::forget('admin_password_verified');
            return $next($request);
        }

        return $next($request);
    }
    
    
    
}
