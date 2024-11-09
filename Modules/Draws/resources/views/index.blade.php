@extends('draws::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <!-- Encabezado -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Gestión de Sorteos</h1>
        <a href="{{ route('draws.create') }}" class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700">
            Nuevo Sorteo
        </a>
    </div>

    <!-- Tabla de Sorteos -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Lotería</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Fecha</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Números Ganadores</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse ($draws as $draw)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $draw->lottery->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $draw->draw_date }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $draw->winning_numbers ?? 'N/A' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap flex gap-3">
                            <!-- Botón Editar -->
                            <a href="{{ route('draws.edit', $draw->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                                Editar
                            </a>
                            <!-- Botón Eliminar -->
                            <form action="{{ route('draws.destroy', $draw->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar este sorteo?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-red-700">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-600">No hay sorteos registrados.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Paginación -->
    <div class="flex justify-between items-center mt-6">
        <p class="text-sm text-gray-600">
            Mostrando página {{ $draws->currentPage() }} de {{ $draws->lastPage() }}.
        </p>
        <div class="flex gap-2">
            @if ($draws->onFirstPage())
                <span class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow cursor-not-allowed">Anterior</span>
            @else
                <a href="{{ $draws->previousPageUrl() }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400">Anterior</a>
            @endif

            @if ($draws->hasMorePages())
                <a href="{{ $draws->nextPageUrl() }}" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow hover:bg-gray-400">Siguiente</a>
            @else
                <span class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg shadow cursor-not-allowed">Siguiente</span>
            @endif
        </div>
    </div>
</div>
@endsection
