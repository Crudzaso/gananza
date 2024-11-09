<?php

namespace Modules\Lotery\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Lotery\Models\Lotery;

class LoteryController extends Controller
{
    public function index()
    {
        $lotteries = Lotery::paginate(10);
        return view('lotery::index', compact('lotteries'));
    }

    public function create()
    {
        return view('lotery::create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        Lotery::create($request->all());

        return redirect()->route('lotery.index')->with('success', 'Lotería creada exitosamente.');
    }

    public function edit($id)
    {
        $lotery = Lotery::findOrFail($id);
        return view('lotery::edit', compact('lotery'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'nullable|url',
        ]);

        $lotery = Lotery::findOrFail($id);
        $lotery->update($request->all());

        return redirect()->route('lotery.index')->with('success', 'Lotería actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $lotery = Lotery::findOrFail($id);
        $lotery->delete();

        return redirect()->route('lotery.index')->with('success', 'Lotería eliminada exitosamente.');
    }
}
