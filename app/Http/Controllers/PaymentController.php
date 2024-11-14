<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Modules\Payment\Models\Payment;
use Modules\Raffle\Models\Raffle;
use Modules\Ticket\Models\Ticket;

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
    }}
