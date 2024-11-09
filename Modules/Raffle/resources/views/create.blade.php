@extends('raffle::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Registrar Nueva Rifa</h1>
    <form action="{{ route('raffles.store') }}" method="POST">
        @csrf

        <!-- Organizador -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Organizador</label>
            <select name="organizer_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Seleccione un organizador</option>
                @foreach($organizers as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Lotería -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Lotería</label>
            <select name="lottery_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Seleccione una lotería</option>
                @foreach($lotteries as $lottery)
                    <option value="{{ $lottery->id }}">{{ $lottery->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Precio del Ticket -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Precio del Ticket</label>
            <input type="number" name="ticket_price" step="0.01" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Total de Tickets -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Total de Tickets</label>
            <input type="number" name="total_tickets" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Tickets Vendidos -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tickets Vendidos</label>
            <input type="number" name="tickets_sold" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <!-- Descripción -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded-lg"></textarea>
        </div>

        <!-- Fecha de Inicio -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
            <input type="datetime-local" name="start_date" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Fecha de Finalización -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Fecha de Finalización</label>
            <input type="datetime-local" name="end_date" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Botón Guardar -->
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Guardar</button>
    </form>
</div>
@endsection
