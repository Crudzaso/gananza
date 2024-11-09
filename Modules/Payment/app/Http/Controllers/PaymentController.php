<?php

namespace Modules\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Payment\Models\Payment;
use App\Models\User;
use Modules\Raffle\Models\Raffle;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['user', 'raffle'])->paginate(10);
        return view('payment::index', compact('payments'));
    }

    public function create()
    {
        $users = User::all();
        $raffles = Raffle::all();
        return view('payment::create', compact('users', 'raffles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'raffle_id' => 'required|exists:raffles,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:NEQUI,EFECTIVO',
            'payment_date' => 'required|date',
        ]);

        Payment::create($request->all());

        return redirect()->route('payment.index')->with('success', 'Pago registrado exitosamente.');
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $users = User::all();
        $raffles = Raffle::all();
        return view('payment::edit', compact('payment', 'users', 'raffles'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'raffle_id' => 'required|exists:raffles,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|in:NEQUI,EFECTIVO',
            'payment_date' => 'required|date',
        ]);

        $payment = Payment::findOrFail($id);
        $payment->update($request->all());

        return redirect()->route('payment.index')->with('success', 'Pago actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->route('payment.index')->with('success', 'Pago eliminado exitosamente.');
    }
}
