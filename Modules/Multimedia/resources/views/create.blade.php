@extends('multimedia::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Subir Archivo Multimedia</h1>
    <form action="{{ route('multimedia.store') }}" method="POST" class="space-y-6">
        @csrf
        <input type="text" name="file_name" placeholder="Nombre del archivo" class="w-full px-4 py-2 border rounded-lg" required>
        <input type="text" name="file_path" placeholder="Ruta del archivo" class="w-full px-4 py-2 border rounded-lg" required>
        <select name="file_type" class="w-full px-4 py-2 border rounded-lg">
            <option value="">Seleccione un tipo</option>
            <option value="VIDEO">Video</option>
            <option value="PDF">PDF</option>
            <option value="IMAGEN">Imagen</option>
        </select>
        <input type="number" name="size" placeholder="Tamaño (bytes)" class="w-full px-4 py-2 border rounded-lg">
        <input type="number" name="model_id" placeholder="ID del Modelo" class="w-full px-4 py-2 border rounded-lg" required>
        <select name="model_type" class="w-full px-4 py-2 border rounded-lg">
            <option value="">Seleccione un tipo de modelo</option>
            <option value="raffles">Raffles</option>
            <option value="tickets">Tickets</option>
        </select>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Guardar</button>
    </form>
</div>
@endsection
