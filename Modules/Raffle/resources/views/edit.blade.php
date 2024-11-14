<!-- resources/views/raffles/edit.blade.php -->

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
            <form action="{{ route('raffles.update', $raffle->id) }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Organizador -->
                <div class="form-group">
                    <label>Organizador</label>
                    <select name="organizer_id" class="form-control select2" style="width: 100%;" required>
                        @foreach($organizers as $user)
                            <option value="{{ $user->id }}" {{ $raffle->organizer_id == $user->id ? 'selected' : '' }}>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Lotería -->
                <div class="form-group">
                    <label>Lotería</label>
                    <select name="lottery_id" class="form-control select2" style="width: 100%;" required>
                        @foreach($lotteries as $lottery)
                            <option value="{{ $lottery->id }}" {{ $raffle->lottery_id == $lottery->id ? 'selected' : '' }}>
                                {{ $lottery->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Precio del Ticket -->
                <div class="form-group">
                    <label>Precio del Ticket</label>
                    <input type="number" name="ticket_price" value="{{ $raffle->ticket_price }}" class="form-control" required>
                </div>

                <!-- Total de Tickets -->
                <div class="form-group">
                    <label>Total de Tickets</label>
                    <input type="number" name="total_tickets" value="{{ $raffle->total_tickets }}" class="form-control" required>
                </div>

                <!-- Tickets Vendidos -->
                <div class="form-group">
                    <label>Tickets Vendidos</label>
                    <input type="number" name="tickets_sold" value="{{ $raffle->tickets_sold }}" class="form-control">
                </div>

                <!-- Descripción -->
                <div class="form-group">
                    <label>Descripción</label>
                    <textarea name="description" class="form-control">{{ $raffle->description }}</textarea>
                </div>

                <!-- Fecha de Inicio -->
                <div class="form-group">
                    <label>Fecha de Inicio</label>
                    <input type="datetime-local" name="start_date" value="{{ \Carbon\Carbon::parse($raffle->start_date)->format('Y-m-d\TH:i') }}" class="form-control" required>
                </div>

                <!-- Fecha de Finalización -->
                <div class="form-group">
                    <label>Fecha de Finalización</label>
                    <input type="datetime-local" name="end_date" value="{{ \Carbon\Carbon::parse($raffle->end_date)->format('Y-m-d\TH:i') }}" class="form-control" required>
                </div>

                <!-- Botón Actualizar -->
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                </div>
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
            $('.select2').select2();
        });
    </script>
@stop
