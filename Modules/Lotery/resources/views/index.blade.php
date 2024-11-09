@extends('lotery::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">Gestión de Loterías</h1>
        <button
            onclick="window.location='{{ route('lotery.create') }}'"
            class="px-6 py-2 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700">
            Nueva Lotería
        </button>
    </div>

    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($lotteries as $lotery)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $lotery->name }}</td>
                    <td class="px-6 py-4 text-sm text-gray-800">{{ $lotery->description }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('lotery.edit', $lotery->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">Editar</a>
                        <form action="{{ route('lotery.destroy', $lotery->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">
        {{ $lotteries->links() }}
    </div>
</div>
@endsection
