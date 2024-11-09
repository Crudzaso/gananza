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
    
        // Evitar bucle infinito al manejar Filament en /admin
        if ($currentPath === 'admin' || str_starts_with($currentPath, 'admin/')) {
            if (!Session::has('admin_password_verified')) {
                // Guardar la URL intentada para redireccionar después de la verificación
                $request->session()->put('url.intended', $request->fullUrl());
                return redirect()->route('admin.verify-password');
            }
    
            return $next($request);
        }
    
        // Manejar la ruta personalizada de administración
        if ($currentPath === 'dashboard/admin') {
            if (!Session::has('admin_password_verified')) {
                // Guardar la URL intentada para redireccionar después de la verificación
                $request->session()->put('url.intended', $request->fullUrl());
                return redirect()->route('admin.verify-password');
            }
        }
    
        return $next($request);
    }
    
    
    
}
