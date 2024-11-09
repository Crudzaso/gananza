@extends('raffle::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Editar Rifa</h1>
    <form action="{{ route('raffles.update', $raffle->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Organizador</label>
            <select name="organizer_id" class="w-full px-4 py-2 border rounded-lg" required>
                @foreach($organizers as $user)
                    <option value="{{ $user->id }}" {{ $raffle->organizer_id == $user->id ? 'selected' : '' }}>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Lotería</label>
            <select name="lottery_id" class="w-full px-4 py-2 border rounded-lg" required>
                @foreach($lotteries as $lottery)
                    <option value="{{ $lottery->id }}" {{ $raffle->lottery_id == $lottery->id ? 'selected' : '' }}>
                        {{ $lottery->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Precio del Ticket</label>
            <input type="number" name="ticket_price" value="{{ $raffle->ticket_price }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Total de Tickets</label>
            <input type="number" name="total_tickets" value="{{ $raffle->total_tickets }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Tickets Vendidos</label>
            <input type="number" name="tickets_sold" value="{{ $raffle->tickets_sold }}" class="w-full px-4 py-2 border rounded-lg">
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded-lg">{{ $raffle->description }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
            <input type="datetime-local" name="start_date" value="{{ \Carbon\Carbon::parse($raffle->start_date)->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Fecha de Finalización</label>
            <input type="datetime-local" name="end_date" value="{{ \Carbon\Carbon::parse($raffle->end_date)->format('Y-m-d\TH:i') }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Actualizar</button>
    </form>
</div>
@endsection
