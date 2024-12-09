<?php

namespace App\Services;

use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use App\Events\ErrorOccurred;
use Illuminate\Support\Facades\Log;

class MPService
{
    public function __construct()
    {
        $this->authenticate();
    }

    protected function authenticate()
    {
        $mpAccessToken = env('MERCADOPAGO_ACCESS_TOKEN');
        MercadoPagoConfig::setAccessToken($mpAccessToken);
    }

    public function createPaymentPreference($items, $payer)
    {
        $paymentMethods = [
            "excluded_payment_methods" => [],  // Métodos de pago excluidos, si es necesario
            "installments" => 12,  // Número de cuotas disponibles
            "default_installments" => 1,  // Cuotas predeterminadas
        ];

        $backUrls = [
            'success' => route('mercadopago.success'),
            'failure' => route('mercadopago.failed'),
        ];

        $request = [
            "items" => $items,
            "payer" => $payer,
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor" => "NOMBRE_EN_FACTURA",  // Nombre que aparecerá en la factura
            "external_reference" => "1234567890",
            "expires" => false,
            "auto_return" => 'approved',  // Automáticamente regresa cuando el pago es aprobado
        ];

        $client = new PreferenceClient();

        try {
            // Crear la preferencia de pago
            $preference = $client->create($request);
            return $preference;
        } catch (MPApiException $e) {
            // Log de error más detallado
            Log::error('Mercado Pago error:', [
                'message' => $e->getMessage(),
                'code' => $e->getCode(),
                'trace' => $e->getTraceAsString(),
            ]);

            // Aquí puedes lanzar un evento para manejar el error si lo deseas
            event(new ErrorOccurred('Error al crear la preferencia de pago con Mercado Pago', $e->getMessage()));
            return null;  // Si hay error, devuelve null
        }
    }
}