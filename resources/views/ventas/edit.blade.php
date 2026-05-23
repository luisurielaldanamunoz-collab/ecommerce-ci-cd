@extends('layouts.app')

@section('title', 'Editar venta')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4">Editar venta #{{ $venta->id }}</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('ventas.update', $venta->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Producto</label>
                    <select name="producto_id" class="form-select">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}"
                                {{ $venta->producto_id == $producto->id ? 'selected' : '' }}>
                                {{ $producto->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" class="form-select">
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}" {{ $venta->cliente_id == $cliente->id ? 'selected' : '' }}>
                                {{ $cliente->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Total</label>
                    <input type="number" step="0.01" name="total" class="form-control"
                        value="{{ old('total', $venta->total) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ticket (dejar vacío para mantener el actual)</label>
                    <input type="file" name="ticket" class="form-control" accept="image/*">
                    @if ($venta->ticket)
                        <small class="text-muted">Ticket actual: {{ basename($venta->ticket) }}</small>
                    @endif
                </div>

                <button type="submit" class="btn btn-primary">Actualizar venta</button>
                <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
@endsection
