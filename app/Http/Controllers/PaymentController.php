<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Payment\Models\Payment;
use Modules\Raffle\Models\Raffle;
use Modules\Ticket\Models\Ticket;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;

class PaymentController extends Controller
{
    public function create(Request $request)
    {
        $raffle = Raffle::find($request->raffle_id);
        $user = auth()->user();

        // Datos del pago
        $amount = $raffle->ticket_price;
        $nequiNumber = config('services.nequi.number'); // Número de Nequi de la plataforma

        // Generar enlace de pago
        $paymentLink = "https://recarga.nequi.com/$nequiNumber?amount=$amount";

        return response()->json([
            'paymentLink' => $paymentLink,
            'qrCode' => "https://api.qrserver.com/v1/create-qr-code/?data=$paymentLink",
        ]);
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $raffle = Raffle::find($request->raffle_id);

        // Crear ticket
        $ticket = Ticket::create([
            'raffle_id' => $raffle->id,
            'user_id' => $user->id,
            'ticket_number' => $request->ticket_number,
            'purchase_date' => Carbon::now(),
            'verification_code' => uniqid(),
        ]);

        // Registrar pago
        $payment = Payment::create([
            'user_id' => $user->id,
            'raffle_id' => $raffle->id,
            'amount' => $raffle->ticket_price,
            'payment_method' => 'Nequi',
            'payment_date' => Carbon::now(),
        ]);

        return response()->json([
            'message' => 'Pago registrado exitosamente',
            'ticket' => $ticket,
            'payment' => $payment,
        ]);
    }
    public function createPreference(Request $request)
    {
        // Configura el token de acceso de MercadoPago
        MercadoPagoConfig::setAccessToken(env('MERCADOPAGO_ACCESS_TOKEN'));
    
        // Obtiene al usuario autenticado
        $user = auth()->user();
    
        // Obtiene el monto y los números seleccionados
        $amount = $request->input('amount'); // Monto enviado desde el frontend
        $numbers = $request->input('numbers', []); // Números seleccionados (opcional)
    
        // Crear la preferencia
        $client = new PreferenceClient();
        $preference = $client->create([
            "items" => [
                [
                    "title" => "Compra de Tickets de Rifa",
                    "quantity" => 1,
                    "unit_price" => $amount, // Monto dinámico enviado desde el frontend
                ]
            ],
            "payer" => [
                "name" => $user->name,
                "surname" => $user->lastname,
                "email" => $user->email,
                "phone" => [
                    "area_code" => substr($user->phone_number, 0, 3), // Primera parte del número
                    "number" => substr($user->phone_number, 3), // Resto del número
                ],
                "identification" => [
                    "type" => $user->document_type, // Tipo de documento (ejemplo: DNI, CC)
                    "number" => $user->document, // Número del documento
                ],
            ],
            "back_urls" => [
                "success" => route('payment.success'),
                "failure" => route('payment.failure'),
                "pending" => route('payment.pending'),
            ],
            "auto_return" => "approved",
            "external_reference" => "TICKETS_RIFA-" . uniqid(), // Referencia única
            "statement_descriptor" => "RIFA_TICKETS", // Descripción en extracto bancario
        ]);
    
        // Retorna el ID de la preferencia al frontend
        return response()->json([
            'id' => $preference->id,
            'numbers' => $numbers, // Devuelve los números seleccionados (opcional)
        ]);
    }
    
    public function handleSuccess()
    {
        // Opcional: puedes procesar información del pago aquí
        return redirect('/dashboard')->with('success', 'Pago completado exitosamente.');
    }

    public function handleFailure()
    {
        // Opcional: puedes registrar errores o mostrar mensajes
        return redirect('/dashboard')->with('error', 'El pago no se pudo completar. Inténtalo de nuevo.');
    }

    public function handlePending()
    {
        // Opcional: maneja pagos pendientes
        return redirect('/dashboard')->with('info', 'El pago está pendiente de aprobación.');
    }
}
