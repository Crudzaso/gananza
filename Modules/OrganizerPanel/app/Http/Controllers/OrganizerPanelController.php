<?php

namespace Modules\OrganizerPanel\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Raffle\Models\Raffle;

class OrganizerPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('organizerpanel::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('organizerpanel::create');
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('organizerpanel::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('organizerpanel::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
