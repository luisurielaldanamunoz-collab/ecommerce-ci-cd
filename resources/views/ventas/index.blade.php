@extends('layouts.app')

@section('title', 'Ventas')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Lista de ventas</h2>
                @can('create', App\Models\Venta::class)
                    <a href="{{ route('ventas.create') }}" class="btn btn-warning">Crear venta</a>
                @endcan
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Producto</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>Total</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Ticket</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->producto->nombre ?? 'Sin producto' }}</td>
                                <td>{{ $venta->cliente->nombre ?? 'Sin cliente' }}</td>
                                <td>{{ $venta->vendedor->nombre ?? 'Sin vendedor' }}</td>
                                <td>${{ number_format($venta->total, 2) }}</td>
                                <td>{{ $venta->fecha }}</td>
                                <td>
                                    @if ($venta->validada)
                                        <span class="badge bg-success">Validada</span>
                                        @if ($venta->validador)
                                            <div class="small text-muted">Por {{ $venta->validador->nombre }}</div>
                                        @endif
                                    @else
                                        <span class="badge bg-secondary">Pendiente</span>
                                    @endif
                                </td>
                                <td>
                                    @can('viewTicket', $venta)
                                        @if ($venta->ticket)
                                            <div class="position-relative">
                                                <img src="{{ route('ventas.ticket', $venta->id) }}"
                                                    alt="Ticket #{{ $venta->id }}" style="max-height: 60px; cursor: pointer;"
                                                    class="rounded" data-bs-toggle="modal"
                                                    data-bs-target="#ticketModal{{ $venta->id }}">
                                            </div>

                                            <div class="modal fade" id="ticketModal{{ $venta->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Ticket #{{ $venta->id }}</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body text-center">
                                                            <img src="{{ route('ventas.ticket', $venta->id) }}"
                                                                alt="Ticket #{{ $venta->id }}"
                                                                style="max-width: 100%; height: auto;">
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('ventas.ticket', $venta->id) }}"
                                                                class="btn btn-primary"
                                                                download="ticket_{{ $venta->id }}.jpg">
                                                                Descargar
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <span class="text-muted">Sin ticket</span>
                                        @endif
                                    @else
                                        <span class="text-muted">No autorizado</span>
                                    @endcan
                                </td>
                                <td>
                                    <div class="d-flex flex-column gap-1">
                                        @can('validate', $venta)
                                            <form action="{{ route('ventas.validate', $venta) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit" class="btn btn-sm btn-success w-100">Validar</button>
                                            </form>
                                        @endcan
                                        @can('update', $venta)
                                            <a href="{{ route('ventas.edit', $venta->id) }}"
                                                class="btn btn-sm btn-warning">Editar</a>
                                        @endcan
                                        @can('delete', $venta)
                                            <form action="{{ route('ventas.destroy', $venta->id) }}" method="POST"
                                                onsubmit="return confirm('¿Eliminar venta?')">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger w-100">Eliminar</button>
                                            </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No hay ventas registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
