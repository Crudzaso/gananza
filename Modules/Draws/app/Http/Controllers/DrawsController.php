<?php

namespace Modules\Draws\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Draws\Models\Draws;
use Modules\Lotery\Models\Lotery;

class DrawsController extends Controller
{
    public function index()
    {
        $draws = Draws::with('lottery')->paginate(10);
        return view('draws::index', compact('draws'));
    }

    public function create()
    {
        $lotteries = Lotery::all();
        return view('draws::create', compact('lotteries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lottery_id' => 'required|exists:lotteries,id',
            'draw_date' => 'required|date',
            'winning_numbers' => 'nullable|string',
        ]);

        Draws::create($request->all());

        return redirect()->route('draws.index')->with('success', 'Sorteo creado exitosamente.');
    }

    public function edit($id)
    {
        $draw = Draws::findOrFail($id);
        $lotteries = Lotery::all();
        return view('draws::edit', compact('draw', 'lotteries'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'lottery_id' => 'required|exists:lotteries,id',
            'draw_date' => 'required|date',
            'winning_numbers' => 'nullable|string',
        ]);

        $draw = Draws::findOrFail($id);
        $draw->update($request->all());

        return redirect()->route('draws.index')->with('success', 'Sorteo actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $draw = Draws::findOrFail($id);
        $draw->delete();

        return redirect()->route('draws.index')->with('success', 'Sorteo eliminado exitosamente.');
    }
}
