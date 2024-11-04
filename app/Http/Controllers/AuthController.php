<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Str;
use App\Notifications\DiscordNotification;

class AuthController extends Controller
{
    public function redirectToGitHub()
    {
        return Socialite::driver('github')->redirect();
    }

    public function handleGitHubCallback()
    {
        try {
            $githubUser = Socialite::driver('github')->user();

            // Verifica los datos recibidos
            Log::info('Usuario de GitHub: ', [
                'id' => $githubUser->id,
                'nickname' => $githubUser->nickname,
                'name' => $githubUser->name,
                'email' => $githubUser->email,
                'avatar' => $githubUser->avatar,
            ]);

            // Encuentra o crea un usuario
            $user = User::firstOrCreate([
                'email' => $githubUser->email,
            ], [
                'name' => $githubUser->name ?: 'Nombre por defecto',
                'github_id' => $githubUser->id,
                'lastname' => 'Apellidos por defecto',
                'password' => bcrypt('random_password'),
                'phone_number' => 'Número por defecto',
                'document' => '00000000',
                'document_type' => 'CC',
            ]);

            // Inicia sesión al usuario
            Auth::login($user);

            return redirect('/dashboard');
        } catch (\Exception $e) {
            // Registra el error
            Log::error('Error en la autenticación de GitHub: ' . $e->getMessage());
            return redirect('/')->with('error', 'No se pudo iniciar sesión con GitHub.');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            Log::info('Entrando en el callback de Google.');

            // Obtener el usuario de Google
            $googleUser = Socialite::driver('google')->user();

            Log::info('Usuario de Google obtenido', [
                'email' => $googleUser->getEmail(),
                'name' => $googleUser->getName(),
                'id' => $googleUser->getId(),
            ]);

            // Buscar o crear un usuario en tu base de datos
            $authUser = User::firstOrCreate(
                ['email' => $googleUser->getEmail()],
                [
                    'name' => $googleUser->getName(),
                    'google_id' => $googleUser->getId(), // Guarda el google_id
                    'lastname' => 'Apellidos por defecto', // Asegúrate de que este campo exista
                    'password' => bcrypt(Str::random(10)), // Genera una contraseña aleatoria y segura
                    'phone_number' => 'Número por defecto', // Asegúrate de que este campo exista
                    'document' => uniqid(), // O una lógica para generar un documento único
                    'document_type' => 'CC', // Asegúrate de que este campo exista
                ]
            );

            Log::info('Usuario autenticado o creado', [
                'authUser' => $authUser,
                'id' => $authUser->id,
                'email' => $authUser->email,
            ]);

            // Iniciar sesión con el usuario autenticado
            Auth::login($authUser, true);
            Log::info('Usuario ha sido autenticado y ha iniciado sesión', [
                'user_id' => $authUser->id,
            ]);

            // Enviar notificación a Discord
            try {
                $authUser->notify(new DiscordNotification($authUser->name, $authUser->email));
                Log::info('Notificación enviada a Discord');
            } catch (\Exception $e) {
                Log::error('Error al enviar notificación a Discord: ' . $e->getMessage(), [
                    'exception' => $e,
                ]);
            }

            // Redirigir a la página deseada
            Log::info('Redirigiendo al usuario a la página de dashboard');
            return redirect()->route('dashboard'); // Cambia a la ruta que desees
        } catch (\Exception $e) {
            // Registra el error
            Log::error('Error en la autenticación de Google: ' . $e->getMessage(), [
                'exception' => $e,
            ]);
            return redirect('/')->with('error', 'No se pudo iniciar sesión con Google.');
        }
    }
}
