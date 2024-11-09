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
            return response()->json([
                'success' => true,
                'redirect' => '/admin'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'La contraseña es incorrecta.'
        ], 422);
    }

    // Método opcional para cerrar la verificación manualmente
    public function clearVerification()
    {
        Session::forget('admin_password_verified');
        return redirect('/');
    }
}