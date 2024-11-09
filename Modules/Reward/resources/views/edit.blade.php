@extends('reward::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Editar Recompensa</h1>
    <form action="{{ route('rewards.update', $reward->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label>Usuario</label>
            <select name="user_id" class="w-full">
                @foreach($users as $user)
                    <option value="{{ $user->id }}" {{ $reward->user_id == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label>Puntos</label>
            <input type="number" name="points" value="{{ $reward->points }}" class="w-full" required>
        </div>
        <div class="mb-4">
            <label>Puntos Canjeados</label>
            <input type="number" name="redeemed_points" value="{{ $reward->redeemed_points }}" class="w-full">
        </div>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Actualizar</button>
    </form>
</div>
@endsection
