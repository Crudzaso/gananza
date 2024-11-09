@extends('draws::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Editar Sorteo</h1>
    <form action="{{ route('draws.update', $draw->id) }}" method="POST" class="bg-white shadow-lg rounded-lg p-6">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label class="block text-gray-700">Lotería</label>
            <select name="lottery_id" class="w-full px-4 py-2 rounded-lg border">
                @foreach($lotteries as $lottery)
                <option value="{{ $lottery->id }}" {{ $draw->lottery_id == $lottery->id ? 'selected' : '' }}>{{ $lottery->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Fecha del Sorteo</label>
            <input type="datetime-local" name="draw_date" value="{{ $draw->draw_date }}" class="w-full px-4 py-2 rounded-lg border">
        </div>
        <div class="mb-4">
            <label class="block text-gray-700">Números Ganadores</label>
            <input type="text" name="winning_numbers" value="{{ $draw->winning_numbers }}" class="w-full px-4 py-2 rounded-lg border">
        </div>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Actualizar</button>
    </form>
</div>
@endsection
