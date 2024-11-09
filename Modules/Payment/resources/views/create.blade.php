@extends('payment::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Registrar Nuevo Pago</h1>
    <form action="{{ route('payment.store') }}" method="POST" class="space-y-6">
        @csrf

        <!-- Usuario -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Usuario</label>
            <select name="user_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Seleccione un usuario</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Rifa -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Rifa</label>
            <select name="raffle_id" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="">Seleccione una rifa</option>
                @foreach($raffles as $raffle)
                    <option value="{{ $raffle->id }}">{{ $raffle->description }}</option>
                @endforeach
            </select>
        </div>

        <!-- Método de Pago -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Método de Pago</label>
            <select name="payment_method" class="w-full px-4 py-2 border rounded-lg" required>
                <option value="NEQUI">Nequi</option>
                <option value="EFECTIVO">Efectivo</option>
            </select>
        </div>

        <!-- Monto -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Monto</label>
            <input type="number" step="0.01" name="amount" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Fecha de Pago -->
        <div>
            <label class="block text-sm font-medium text-gray-700">Fecha de Pago</label>
            <input type="datetime-local" name="payment_date" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Botón Guardar -->
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Guardar</button>
    </form>
</div>
@endsection
