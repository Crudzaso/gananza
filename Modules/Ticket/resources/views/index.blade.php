@extends('ticket::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Gestión de Tickets</h1>
    <a href="{{ route('tickets.create') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg mb-4">Nuevo Ticket</a>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Rifa</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Número de Ticket</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Código de Verificación</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($tickets as $ticket)
                <tr>
                    <td class="px-6 py-4">{{ $ticket->user->name }}</td>
                    <td class="px-6 py-4">{{ $ticket->raffle->description }}</td>
                    <td class="px-6 py-4">{{ $ticket->ticket_number }}</td>
                    <td class="px-6 py-4">{{ $ticket->verification_code }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('tickets.edit', $ticket->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Editar</a>
                        <form action="{{ route('tickets.destroy', $ticket->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">{{ $tickets->links() }}</div>
</div>
@endsection
