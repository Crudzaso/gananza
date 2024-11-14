<!-- resources/views/raffles/index.blade.php -->

@extends('adminlte::page')

@section('title', 'Gestión de Rifas')

@section('content_header')
    <h1>Gestión de Rifas</h1>
@stop

@section('content')
<div class="container-fluid">
    <!-- Botón para crear nueva rifa -->
    <div class="mb-4">
        <a href="{{ route('raffles.create') }}" class="btn btn-success">
            <i class="fas fa-plus mr-2"></i> Nueva Rifa
        </a>
    </div>

    <!-- Contenedor de la tabla -->
    <div class="card">
        <div class="card-header bg-primary">
            <h3 class="card-title text-white">Lista de Rifas</h3>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Organizador</th>
                        <th>Nombre</th>
                        <th>Lotería</th>
                        <th>Precio del Ticket</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($raffles as $raffle)
                        <tr>
                            <td>{{ $raffle->organizer->name }}</td>
                            <td>{{ $raffle->name }}</td>
                            <td>{{ $raffle->lottery->name }}</td>
                            <td>${{ number_format($raffle->ticket_price, 2) }}</td>
                            <td>
                                <!-- Botón Editar -->
                                <a href="{{ route('raffles.edit', $raffle->id) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> Editar
                                </a>
                                <!-- Botón Eliminar -->
                                <form action="{{ route('raffles.destroy', $raffle->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de eliminar esta rifa?')">
                                        <i class="fas fa-trash-alt"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">No hay rifas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="card-footer clearfix">
            <!-- Paginación personalizada -->
            @if ($raffles->hasPages())
                <nav class="pagination-custom">
                    <ul class="pagination d-flex justify-content-center">
                        {{-- Botón "Anterior" --}}
                        @if ($raffles->onFirstPage())
                            <li class="page-item disabled">
                                <span class="page-link">&laquo; Anterior</span>
                            </li>
                        @else
                            <li class="page-item">
                                <a href="{{ $raffles->previousPageUrl() }}" class="page-link">&laquo; Anterior</a>
                            </li>
                        @endif

                        {{-- Números de página --}}
                        @foreach ($raffles->getUrlRange(1, $raffles->lastPage()) as $page => $url)
                            @if ($page == $raffles->currentPage())
                                <li class="page-item active">
                                    <span class="page-link">{{ $page }}</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                                </li>
                            @endif
                        @endforeach

                        {{-- Botón "Siguiente" --}}
                        @if ($raffles->hasMorePages())
                            <li class="page-item">
                                <a href="{{ $raffles->nextPageUrl() }}" class="page-link">Siguiente &raquo;</a>
                            </li>
                        @else
                            <li class="page-item disabled">
                                <span class="page-link">Siguiente &raquo;</span>
                            </li>
                        @endif
                    </ul>
                </nav>
            @endif
        </div>
    </div>

    <!-- Componente de Livewire para rifas activas -->
    <div class="mt-4">
        <active-raffles></active-raffles>
    </div>
</div>
@stop

@section('css')
    <style>
        /* Estilos adicionales */
        .btn {
            font-size: 0.9rem;
        }

        /* Estilos para la paginación personalizada */
        .pagination-custom .pagination {
            padding: 0;
            list-style: none;
        }

        .pagination-custom .page-item {
            display: inline-block;
            margin: 0 5px;
        }

        .pagination-custom .page-link {
            padding: 0.5rem 0.75rem;
            color: #007bff;
            text-decoration: none;
            border: 1px solid #ddd;
            border-radius: 0.25rem;
        }

        .pagination-custom .page-item.active .page-link {
            background-color: #007bff;
            color: #fff;
            border-color: #007bff;
        }

        .pagination-custom .page-item.disabled .page-link {
            color: #6c757d;
            pointer-events: none;
            background-color: #f8f9fa;
        }
    </style>
@stop

@section('js')
    <script>
        // Mensaje de confirmación para eliminar
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function (event) {
                if (!confirm('¿Estás seguro de eliminar esta rifa?')) {
                    event.preventDefault();
                }
            });
        });
    </script>
@stop
