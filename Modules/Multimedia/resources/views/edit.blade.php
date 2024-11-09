@extends('multimedia::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Editar Archivo Multimedia</h1>
    <form action="{{ route('multimedia.update', $multimedia->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <input type="text" name="file_name" value="{{ $multimedia->file_name }}" class="w-full px-4 py-2 border rounded-lg" required>
        <input type="text" name="file_path" value="{{ $multimedia->file_path }}" class="w-full px-4 py-2 border rounded-lg" required>
        <select name="file_type" class="w-full px-4 py-2 border rounded-lg">
            <option value="VIDEO" {{ $multimedia->file_type == 'VIDEO' ? 'selected' : '' }}>Video</option>
            <option value="PDF" {{ $multimedia->file_type == 'PDF' ? 'selected' : '' }}>PDF</option>
            <option value="IMAGEN" {{ $multimedia->file_type == 'IMAGEN' ? 'selected' : '' }}>Imagen</option>
        </select>
        <input type="number" name="size" value="{{ $multimedia->size }}" class="w-full px-4 py-2 border rounded-lg">
        <input type="number" name="model_id" value="{{ $multimedia->model_id }}" class="w-full px-4 py-2 border rounded-lg" required>
        <select name="model_type" class="w-full px-4 py-2 border rounded-lg">
            <option value="raffles" {{ $multimedia->model_type == 'raffles' ? 'selected' : '' }}>Raffles</option>
            <option value="tickets" {{ $multimedia->model_type == 'tickets' ? 'selected' : '' }}>Tickets</option>
        </select>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Actualizar</button>
    </form>
</div>
@endsection
