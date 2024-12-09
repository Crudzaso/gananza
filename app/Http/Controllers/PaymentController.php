<?php

namespace App\Http\Controllers;

use App\Services\MPService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $mercadoPagoService;

    public function __construct(MPService $mercadoPagoService)
    {
        $this->mercadoPagoService = $mercadoPagoService;
    }

    // Mostrar el formulario de pago
    public function showPaymentForm()
    {
        return view('mercadopago.payment');
    }

    // Crear la preferencia de pago
    public function createPayment(Request $request)
    {
        $user = auth()->user();


        $items = [
            [
                "id" => "1234567890",
                "title" => "Producto 1",
                "description" => "Descripción del producto 1",
                "currency_id" => "COP",
                "quantity" => 1,
                "unit_price" => 1000.00
            ]
        ];

        $payer = [
            "name" => $user->name,
            "surname" => $user->lastname,
            "email" => $user->email,
        ];

        $preference = $this->mercadoPagoService->createPaymentPreference($items, $payer);

        if ($preference) {
            return response()->json(['id' => $preference->id]); // Devolver el ID de la preferencia
        } else {
            return response()->json(['error' => 'No se pudo crear la preferencia de pago.'], 500);
        }
    }

    // Página de éxito del pago
    public function success()
    {
        return redirect()->route('mercadopago.payment');
    }

    // Página de fallo en el pago
    public function failure()
    {
        return redirect()->route('mercadopago.payment');
    }
}