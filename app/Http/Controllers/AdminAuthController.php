<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AdminAuthController extends Controller
{
    public function showVerification(Request $request)
    {
        return Inertia::render('Admin/VerifyPassword', [
            'intended_url' => $request->session()->get('url.intended', '/admin')
        ]);
    }

    public function verifyPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string',
        ]);
    
        if (Hash::check($request->password, auth()->user()->password)) {
            session(['admin_password_verified' => true]);
    
            $redirectUrl = session()->pull('url.intended', '/dashboard/admin');
            return response()->json([
                'success' => true,
                'redirect' => $redirectUrl,
            ]);
        }
    
        return response()->json([
            'success' => false,
            'message' => 'La contraseña es incorrecta.',
        ], 422);
    }
    

    public function clearVerification()
    {
        Session::forget('admin_password_verified');
        return redirect('/');
    }

    public function showDashboard()
{
    return Inertia::render('Admin/AdminDashboard', [
        'title' => 'Panel de Administración',
        'description' => 'Bienvenido al panel de administración',
    ]);
}
}
