@extends('multimedia::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Gestión de Archivos Multimedia</h1>
    <a href="{{ route('multimedia.create') }}" class="px-6 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700">Nuevo Archivo</a>

    <div class="bg-white shadow-lg rounded-lg mt-6">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Tipo</th>
                    <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($multimediaFiles as $file)
                <tr class="hover:bg-gray-100">
                    <td class="px-6 py-4">{{ $file->file_name }}</td>
                    <td class="px-6 py-4">{{ $file->file_type }}</td>
                    <td class="px-6 py-4 flex gap-2">
                        <a href="{{ route('multimedia.edit', $file->id) }}" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">Editar</a>
                        <form action="{{ route('multimedia.destroy', $file->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-6">
        {{ $multimediaFiles->links() }}
    </div>
</div>
@endsection
