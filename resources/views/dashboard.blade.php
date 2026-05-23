@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    <div class="mb-4">
        <h2 class="mb-1">Dashboard general</h2>
        <p class="text-muted mb-0">Consultas administrativas resueltas con relaciones Eloquent.</p>
    </div>

    <div class="row g-3">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Usuarios</p>
                    <h3 class="mb-0">{{ $totalUsuarios }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Vendedores</p>
                    <h3 class="mb-0">{{ $totalVendedores }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <p class="text-muted mb-2">Compradores</p>
                    <h3 class="mb-0">{{ $totalCompradores }}</h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="mb-3">Productos por categoría</h5>
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Categoría</th>
                            <th>Total productos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productosPorCategoria as $categoria)
                            <tr>
                                <td>{{ $categoria->nombre }}</td>
                                <td>{{ $categoria->productos->count() }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="2" class="text-center">Sin categorías registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="mb-3">Producto más vendido</h5>
            @if ($productoMasVendido && $productoMasVendido->ventas_count > 0)
                <p class="mb-1"><strong>{{ $productoMasVendido->nombre }}</strong></p>
                <p class="mb-0 text-muted">Ventas registradas: {{ $productoMasVendido->ventas_count }}</p>
            @else
                <p class="mb-0 text-muted">Aún no hay ventas registradas.</p>
            @endif
        </div>
    </div>

    <div class="card shadow-sm mt-4">
        <div class="card-body">
            <h5 class="mb-3">Comprador más frecuente por categoría</h5>
            <div class="table-responsive">
                <table class="table table-sm table-bordered mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Categoría</th>
                            <th>Comprador más frecuente</th>
                            <th>Total compras</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($compradorFrecuentePorCategoria as $dato)
                            <tr>
                                <td>{{ $dato['categoria']->nombre }}</td>
                                <td>
                                    @if ($dato['comprador'])
                                        {{ $dato['comprador']->nombre }} {{ $dato['comprador']->apellidos }}
                                    @else
                                        <span class="text-muted">Sin compras</span>
                                    @endif
                                </td>
                                <td>{{ $dato['total'] }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Sin datos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
