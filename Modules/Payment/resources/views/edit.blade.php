@extends('payment::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Editar Pago</h1>
    <form action="{{ route('payment.update', $payment->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <select name="user_id" class="w-full px-4 py-2 border rounded-lg" required>
            @foreach ($users as $user)
            <option value="{{ $user->id }}" {{ $payment->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
            @endforeach
        </select>
        <select name="raffle_id" class="w-full px-4 py-2 border rounded-lg" required>
            @foreach ($raffles as $raffle)
            <option value="{{ $raffle->id }}" {{ $payment->raffle_id == $raffle->id ? 'selected' : '' }}>{{ $raffle->name }}</option>
            @endforeach
        </select>
        <input type="number" name="amount" value="{{ $payment->amount }}" class="w-full px-4 py-2 border rounded-lg" required>
        <select name="payment_method" class="w-full px-4 py-2 border rounded-lg">
            <option value="NEQUI" {{ $payment->payment_method == 'NEQUI' ? 'selected' : '' }}>NEQUI</option>
            <option value="EFECTIVO" {{ $payment->payment_method == 'EFECTIVO' ? 'selected' : '' }}>Efectivo</option>
        </select>
        <input type="datetime-local" name="payment_date" value="{{ $payment->payment_date }}" class="w-full px-4 py-2 border rounded-lg" required>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Actualizar</button>
    </form>
</div>
@endsection
