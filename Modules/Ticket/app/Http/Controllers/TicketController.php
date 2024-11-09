<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Ticket\Models\Ticket;
use Modules\Raffle\Models\Raffle;
use App\Models\User;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('raffle', 'user')->paginate(10);
        return view('ticket::index', compact('tickets'));
    }

    public function create()
    {
        $raffles = Raffle::all();
        $users = User::all();
        return view('ticket::create', compact('raffles', 'users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'raffle_id' => 'required|exists:raffles,id',
            'user_id' => 'required|exists:users,id',
            'ticket_number' => 'required|string|max:10',
            'purchase_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:purchase_date',
            'verification_code' => 'required|string|max:50',
        ]);

        Ticket::create($request->all());

        return redirect()->route('tickets.index')->with('success', 'Ticket creado exitosamente.');
    }

    public function edit($id)
    {
        $ticket = Ticket::findOrFail($id);
        $raffles = Raffle::all();
        $users = User::all();
        return view('ticket::edit', compact('ticket', 'raffles', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'raffle_id' => 'required|exists:raffles,id',
            'user_id' => 'required|exists:users,id',
            'ticket_number' => 'required|string|max:10',
            'purchase_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:purchase_date',
            'verification_code' => 'required|string|max:50',
        ]);

        $ticket = Ticket::findOrFail($id);
        $ticket->update($request->all());

        return redirect()->route('tickets.index')->with('success', 'Ticket actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $ticket = Ticket::findOrFail($id);
        $ticket->delete();

        return redirect()->route('tickets.index')->with('success', 'Ticket eliminado exitosamente.');
    }
}
