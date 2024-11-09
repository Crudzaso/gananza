<?php

namespace Modules\Raffle\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Raffle\Models\Raffle;
use Modules\Lotery\Models\Lotery;
use App\Models\User;

class RaffleController extends Controller
{
    public function index()
    {
        $raffles = Raffle::with('organizer', 'lottery')->paginate(10);
        return view('raffle::index', compact('raffles'));
    }

    public function create()
    {
        $organizers = User::all();
        $lotteries = Lotery::all();
        return view('raffle::create', compact('organizers', 'lotteries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'organizer_id' => 'required|exists:users,id',
            'lottery_id' => 'required|exists:lotteries,id',
            'ticket_price' => 'required|numeric|min:0',
            'total_tickets' => 'required|integer|min:1',
            'tickets_sold' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        Raffle::create($request->all());

        return redirect()->route('raffles.index')->with('success', 'Rifa creada exitosamente.');
    }

    public function edit($id)
    {
        $raffle = Raffle::findOrFail($id);
        $organizers = User::all();
        $lotteries = Lotery::all();
        return view('raffle::edit', compact('raffle', 'organizers', 'lotteries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'organizer_id' => 'required|exists:users,id',
            'lottery_id' => 'required|exists:lotteries,id',
            'ticket_price' => 'required|numeric|min:0',
            'total_tickets' => 'required|integer|min:1',
            'tickets_sold' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $raffle = Raffle::findOrFail($id);
        $raffle->update($request->all());

        return redirect()->route('raffles.index')->with('success', 'Rifa actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $raffle = Raffle::findOrFail($id);
        $raffle->delete();

        return redirect()->route('raffles.index')->with('success', 'Rifa eliminada exitosamente.');
    }
}
