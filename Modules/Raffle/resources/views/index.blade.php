@extends('raffle::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Gestión de Rifas</h1>
    <a href="{{ route('raffles.create') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg mb-4">Nueva Rifa</a>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600">Organizador</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600">Lotería</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600">Precio del Ticket</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($raffles as $raffle)
                    <tr class="hover:bg-gray-100">
                        <td class="px-6 py-4">{{ $raffle->organizer->name }}</td>
                        <td class="px-6 py-4">{{ $raffle->lottery->name }}</td>
                        <td class="px-6 py-4">${{ number_format($raffle->ticket_price, 2) }}</td>
                        <td class="px-6 py-4">
                            <a href="{{ route('raffles.edit', $raffle->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Editar</a>
                            <form action="{{ route('raffles.destroy', $raffle->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <active-raffles></active-raffles>
    </div>
</div>
@endsection
