<?php

namespace Modules\Raffle\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Raffle\Models\Raffle;
use Modules\Lottery\Models\Lottery;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;

class RaffleController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $raffles = Raffle::with('organizer', 'lottery')
            ->where('organizer_id', $user->id)
            ->paginate(10);

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
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|max:2048', // Validar si es una imagen
        ]);

        $imagePath = null;

        // Verificar si se subió una imagen
        if ($request->hasFile('image')) {
            // Guardar la imagen en el disco 'public' y obtener la ruta
            $imagePath = $request->file('image')->store('raffle_images', 'public');
        }

        // Crear la rifa
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
            'total_sales' => 0, // Valor predeterminado
            'image' => $imagePath, // Guardar la ruta de la imagen en la base de datos
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
        $raffle = Raffle::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'end_date' => 'required|date|after:start_date',
            'image' => 'nullable|image|max:2048', // Validar si es una imagen
        ]);

        // Manejar imagen si se sube un nuevo archivo
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('raffle_images', 'public');
            $raffle->image = $imagePath; // Actualizar la ruta de la imagen
        }

        // Actualizar otros campos
        $raffle->update([
            'name' => $request->name,
            'description' => $request->description,
            'end_date' => $request->end_date,
        ]);

        return redirect()->route('raffles.index')->with('success', 'Rifa actualizada exitosamente.');
    }

    public function destroy($id)
    {
        $raffle = Raffle::findOrFail($id);
        $raffle->delete();

        return redirect()->route('raffles.index')->with('success', 'Rifa eliminada exitosamente.');
    }

    private function processExpiredRaffles($date = null)
    {
        // Usa la fecha proporcionada o la fecha actual
        $date = $date ? \Carbon\Carbon::parse($date)->format('Y-m-d') : now()->format('Y-m-d');
        
        Log::info("Iniciando procesamiento de rifas expiradas para la fecha: {$date}");
        
        // Obtener todas las rifas cuya end_date sea igual a la fecha proporcionada
        $expiredRaffles = Raffle::whereDate('end_date', $date)
            ->with(['lottery:id,slug'])
            ->get();
        
        if ($expiredRaffles->isEmpty()) {
            Log::info("No se encontraron rifas expiradas para la fecha: {$date}");
            return;
        }
        
        Log::info("Se encontraron {$expiredRaffles->count()} rifa(s) expiradas para procesar.");
        
        $response = Http::get("https://api-resultadosloterias.com/api/results/{$date}");
        
        if ($response->failed()) {
            Log::error("Error al consultar la API de resultados de loterías para la fecha: {$date}");
            throw new \Exception('Error al consultar la API de resultados de loterías.');
        }
        
        $results = collect($response->json()['data']);
        Log::info("Resultados obtenidos de la API: " . $results->count() . " registros.");
        
        foreach ($expiredRaffles as $raffle) {
            $lotterySlug = $raffle->lottery->slug;
            $lotteryResult = $results->firstWhere('slug', $lotterySlug);
        
            if ($lotteryResult) {
                // Extraer los últimos dos dígitos del resultado
                $lastTwoDigits = substr($lotteryResult['result'], -2);
    
                $raffle->update([
                    'winner_number' => $lastTwoDigits, // Guardar los dos últimos dígitos
                ]);
    
                Log::info("Rifa '{$raffle->name}' actualizada con el número ganador: {$lastTwoDigits}");
            } else {
                Log::warning("No se encontró resultado en la API para la lotería con slug: {$lotterySlug}");
            }
        }
        
        Log::info("Procesamiento completado para rifas expiradas en la fecha: {$date}");
    }
    

    public function getRaffles(Request $request)
{
    $this->processExpiredRaffles('2024-12-08');

    // Comenzamos la consulta con las relaciones
    $query = Raffle::with('organizer', 'lottery')
        // Filtramos por rifas activas o rifas expiradas sin ganador dentro de los últimos 2 días
        ->where(function ($query) {
            $query->where('end_date', '>=', now()) // Rifas activas
                  ->orWhere(function ($query) {
                      $query->whereNull('winner_number') // Rifas sin ganador
                            ->where('end_date', '>=', now()->subDays(2)); // Expiradas hace menos de 2 días
                  });
        })
        // Ordenamos por la fecha de creación o fin, de más reciente a más antiguo
        ->orderBy('created_at', 'desc');

    // Filtros de precio mínimo y máximo
    if ($request->has('min_price')) {
        $query->where('ticket_price', '>=', $request->input('min_price'));
    }
    if ($request->has('max_price')) {
        $query->where('ticket_price', '<=', $request->input('max_price'));
    }

    // Filtramos por la fecha de fin si se proporciona
    if ($request->has('end_date')) {
        $query->where('end_date', '<=', $request->input('end_date'));
    }

    // Paginamos los resultados (6 resultados por página)
    $raffles = $query->paginate(6);

    return response()->json($raffles);
}

    public function getLastChanceRaffles()
    {
        $this->processExpiredRaffles();


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
        $this->processExpiredRaffles();

        $activeRaffles = Raffle::where('end_date', '>', now())->get();
        return response()->json(['active_raffles' => $activeRaffles]);
    }

    public function getFilteredRaffles(Request $request)
    {
        $this->processExpiredRaffles();

        $filter = $request->input('filter');
        $date = $request->input('date');
        $query = Raffle::with('organizer', 'lottery');

        // Filtro adicional por fecha específica
        if ($date) {
            $query->whereDate('end_date', '>', $date);
        }

        switch ($filter) {
            case 'popular':
                // Rifas populares con más de 50 tickets vendidos y activas
                $query->where('tickets_sold', '>=', 50)
                    ->where('end_date', '>', now())
                    ->orderBy('tickets_sold', 'desc');
                break;

            case 'last_chance':
                // Rifas activas ordenadas por el end_date más próximo
                $query->where('end_date', '>', now())
                    ->orderBy('end_date', 'asc');
                break;

            case 'flash':
                // Rifas con menos de 50 tickets y activas, ordenadas por creación más reciente
                $query->where('end_date', '>', now())
                    ->orderBy('created_at', 'desc');
                break;

            default:
                // Por defecto, todas las rifas activas
                $query->where('end_date', '>', now())
                    ->orderBy('end_date', 'asc');
                break;
        }

        $raffles = $query->paginate(6);
        return response()->json($raffles);
    }
}
