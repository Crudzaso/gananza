<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ImapService;

class PaymentVerificationController extends Controller
{
    protected $imapService;

    public function __construct(ImapService $imapService)
    {
        $this->imapService = $imapService;
    }

    public function verifyPayment(Request $request)
    {
        $numeroComprobante = $request->input('referenceNumber');
        $monto = $request->input('monto');

        $result = $this->imapService->searchEmailByComprobante($numeroComprobante, $monto);

        if ($result['status'] === 'success') {
            return response()->json(['status' => 'success', 'message' => $result['message']]);
        }

        return response()->json(['status' => 'error', 'message' => $result['message']], 400);
    }
}
