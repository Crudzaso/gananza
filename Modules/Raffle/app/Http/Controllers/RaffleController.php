<?php

namespace Modules\Raffle\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Raffle\Models\Raffle;
use Modules\Lottery\Models\Lottery;
use App\Models\User;
use Inertia\Inertia;

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
        $lotteries = Lottery::all();
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

        Raffle::create([
        'name' => $request->name,
        'organizer_id' => $request->organizer_id,
        'lottery_id' => $request->lottery_id,
       
        'total_tickets' => $request->total_tickets,
        'ticket_price' => $request->ticket_price,
        'tickets_sold' => $request->tickets_sold ?? 0,
        'description' => $request->description,
        'start_date' => $request->start_date,
        'end_date' => $request->end_date,
        'total_sales' => 0, // valor predeterminado de total_sales
    ]);

        return redirect()->route('raffles.index')->with('success', 'Rifa creada exitosamente.');
    }

    public function edit($id)
    {
        $raffle = Raffle::findOrFail($id);
        $organizers = User::all();
        $lotteries = Lottery::all();
        return view('raffle::edit', compact('raffle', 'organizers', 'lotteries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'organizer_id' => 'required|exists:users,id',
            'image' => 'nullable|string',
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

    public function getRaffles(Request $request)
    {
        $query = Raffle::with('organizer', 'lottery');

        if ($request->has('min_price')) {
            $query->where('ticket_price', '>=', $request->input('min_price'));
        }
        if ($request->has('max_price')) {
            $query->where('ticket_price', '<=', $request->input('max_price'));
        }

        if ($request->has('end_date')) {
            $query->where('end_date', '<=', $request->input('end_date'));
        }

        $raffles = $query->paginate(6);
        return response()->json($raffles);
    }

    public function getLastChanceRaffles()
    {
        $raffles = Raffle::where('end_date', '<', now()->addDays(10))
            ->whereColumn('tickets_sold', '<', 'total_tickets')
            ->with('organizer') // Incluir los datos del organizador
            ->orderBy('end_date', 'asc')
            ->limit(5)
            ->get();

        return response()->json($raffles);
    }


    public function getActiveRaffles()
    {
        $activeRaffles = Raffle::where('end_date', '>', now())->get();
        return response()->json(['active_raffles' => $activeRaffles]);
    }

    public function getFilteredRaffles(Request $request)
    {
        $filter = $request->input('filter');
        $date = $request->input('date');
        $query = Raffle::with('organizer', 'lottery');
    
        // Aplicar filtro adicional por fecha
        if ($date) {
            $query->whereDate('end_date', '>', $date);
        }
    
        switch ($filter) {
            case 'popular':
                $query->where('tickets_sold', '>=', 50)
                      ->where('end_date', '>', now()->addDays(10));
                break;
            case 'last_chance':
                $query->where('end_date', '<', now()->addDays(3));
                break;
            case 'flash':
                $query->where('total_tickets', '<=', 50);
                break;
            default:
                $query->where('end_date', '>', now());
                break;
        }
    
        $raffles = $query->paginate(6);
        return response()->json($raffles);
    }
    
}
