@extends('lotery::layouts.master')

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Editar Lotería</h1>
    <form action="{{ route('lotery.update', $lotery->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="name" value="{{ $lotery->name }}" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded-lg">{{ $lotery->description }}</textarea>
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700">URL de la Imagen</label>
            <input type="url" name="image_url" value="{{ $lotery->image_url }}" class="w-full px-4 py-2 border rounded-lg">
        </div>
        <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg">Actualizar</button>
    </form>
</div>
@endsection
