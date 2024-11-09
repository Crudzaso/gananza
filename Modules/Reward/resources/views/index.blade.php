@extends('reward::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Gestión de Recompensas</h1>
    <a href="{{ route('rewards.create') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg mb-4">Nueva Recompensa</a>
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Puntos</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Puntos Canjeados</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($rewards as $reward)
                <tr>
                    <td class="px-6 py-4">{{ $reward->user->name }}</td>
                    <td class="px-6 py-4">{{ $reward->points }}</td>
                    <td class="px-6 py-4">{{ $reward->redeemed_points }}</td>
                    <td class="px-6 py-4">
                        <a href="{{ route('rewards.edit', $reward->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg">Editar</a>
                        <form action="{{ route('rewards.destroy', $reward->id) }}" method="POST" class="inline-block">
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
    <div class="mt-6">{{ $rewards->links() }}</div>
</div>
@endsection
