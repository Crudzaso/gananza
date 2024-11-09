@extends('ticket::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Editar Ticket</h1>
    <form action="{{ route('tickets.update', $ticket->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label>Usuario</label>
            <select name="user_id" class="w-full">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $ticket->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Rifa</label>
            <select name="raffle_id" class="w-full">
                @foreach($raffles as $raffle)
                    <option value="{{ $raffle->id }}" {{ $ticket->raffle_id == $raffle->id ? 'selected' : '' }}>{{ $raffle->description }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Número de Ticket</label>
            <input type="text" name="ticket_number" value="{{ $ticket->ticket_number }}" class="w-full" required>
        </div>
        <div class="mb-4">
            <label>Código de Verificación</label>
            <input type="text" name="verification_code" value="{{ $ticket->verification_code }}" class="w-full" required>
        </div>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Actualizar</button>
    </form>
</div>
@endsection
