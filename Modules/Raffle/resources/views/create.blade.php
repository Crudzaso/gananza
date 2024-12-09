@extends('adminlte::page')

@section('title', 'Registrar Nueva Rifa')

@section('content_header')
    <h1>Crear rifa</h1>
@stop

@section('content')
<div class="container mx-auto px-6 py-10">
    <h1 class="text-3xl font-extrabold text-gray-800 mb-6">Registrar Nueva Rifa</h1>
    <form action="{{ route('raffles.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Organizador -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Organizador</label>
            <input type="text" name="organizer_name" class="form-control" value="{{ auth()->user()->name }}" readonly>
            <input type="hidden" name="organizer_id" value="{{ auth()->user()->id }}">
        </div>

        <!-- Nombre de la rifa -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Nombre de la rifa</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <!-- Lotería -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Lotería</label>
            <select name="lottery_id" class="form-control" required>
                <option value="">Seleccione una lotería</option>
                @foreach($lotteries as $lottery)
                    <option value="{{ $lottery->id }}">{{ $lottery->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Imagen de la Rifa -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Imagen de la Rifa</label>
            <input type="file" name="image" class="form-control" accept="image/*">
        </div>

        <!-- Total a Recaudar -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Total a Recaudar</label>
            <input type="number" name="total_to_collect" id="total_to_collect" class="form-control" step="0.01" max="2000000" required>
        </div>

        <!-- Total de Tickets -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Total de Tickets</label>
            <input type="number" name="total_tickets" id="total_tickets" class="form-control" max="100" required>
        </div>

        <!-- Precio del Ticket -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Precio del Ticket</label>
            <input type="number" name="ticket_price" id="ticket_price" class="form-control" step="0.01" readonly required>
        </div>

        <!-- Tickets Vendidos -->
        <input type="hidden" name="tickets_sold" value="0">

        <!-- Descripción -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Descripción</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <!-- Fecha de Inicio -->
        <input type="hidden" name="start_date" value="{{ now()->toDateTimeLocalString() }}">

        <!-- Fecha de Finalización -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Fecha de Finalización</label>
            <input type="datetime-local" name="end_date" class="form-control" required>
        </div>

        <!-- Botón Guardar -->
        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>
@stop

@section('css')
    {{-- Añade estilos adicionales aquí si es necesario --}}
@stop

@section('js')
    <script>
        // Calcular precio del ticket dinámicamente
        document.getElementById('total_to_collect').addEventListener('input', calculateTicketPrice);
        document.getElementById('total_tickets').addEventListener('input', calculateTicketPrice);

        function calculateTicketPrice() {
            const totalToCollect = parseFloat(document.getElementById('total_to_collect').value);
            const totalTickets = parseInt(document.getElementById('total_tickets').value);

            if (totalToCollect > 0 && totalTickets > 0) {
                const ticketPrice = (totalToCollect / totalTickets).toFixed(2);
                document.getElementById('ticket_price').value = ticketPrice;
            }
        }
    </script>
@stop