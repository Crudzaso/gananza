@extends('reward::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Registrar Nueva Recompensa</h1>
    <form action="{{ route('rewards.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label>Usuario</label>
            <select name="user_id" class="w-full">
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Puntos</label>
            <input type="number" name="points" class="w-full" required>
        </div>
        <div class="mb-4">
            <label>Puntos Canjeados</label>
            <input type="number" name="redeemed_points" class="w-full">
        </div>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Guardar</button>
    </form>
</div>
@endsection
