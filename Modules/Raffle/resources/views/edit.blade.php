@extends('adminlte::page')

@section('title', 'Editar Rifa')

@section('content_header')
    <h1>Editar Rifa</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Editar Rifa</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('raffles.update', $raffle->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
            
                <!-- Nombre de la rifa -->
                <div class="form-group">
                    <label>Nombre de la rifa</label>
                    <input type="text" name="name" value="{{ $raffle->name }}" class="form-control" required>
                </div>
            
                <!-- Descripción -->
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="description" class="form-control">{{ $raffle->description }}</textarea>
                </div>
            
                <!-- Fecha de Finalización -->
                <div class="form-group">
                    <label>Fecha de Finalización</label>
                    <input type="datetime-local" name="end_date" value="{{ \Carbon\Carbon::parse($raffle->end_date)->format('Y-m-d\TH:i') }}" class="form-control" required>
                </div>
            
                <!-- Imagen -->
                <div class="form-group">
                    <label>Imagen de la Rifa</label>
                    <input type="file" name="image" class="form-control" accept="image/*">
                </div>
            
                <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
            
        </div>
    </div>
</div>
@stop

@section('css')
    <style>
        .select2-container .select2-selection--single {
            height: 38px !important;
        }
    </style>
@stop

@section('js')
    <script>
        // Inicializar Select2 para los dropdowns
        $(document).ready(function() {
            if ($.fn.select2) {
                $('.select2').select2();
            }
        });
    </script>
@stop