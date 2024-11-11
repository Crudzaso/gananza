<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Raffle\Models\Raffle;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;


class RaffleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $raffles = Raffle::with('lottery')->get();
        return response()->json($raffles);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('resources.js.pages.RaffleCreate');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         try {
        Log::info('Datos recibidos para crear rifa:', $request->all());

        // Convertir las fechas a un formato compatible con la base de datos
        $data = $request->all();
        $data['start_date'] = date('Y-m-d H:i:s', strtotime($data['start_date']));
        $data['end_date'] = date('Y-m-d H:i:s', strtotime($data['end_date']));

        $raffle = Raffle::create($data);

        return response()->json([
            'message' => 'Rifa creada exitosamente',
            'raffle' => $raffle
        ], 201);

    } catch (\Exception $e) {
        Log::error('Error al crear la rifa:', ['error' => $e->getMessage()]);

        return response()->json([
            'message' => 'Error al crear la rifa',
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
