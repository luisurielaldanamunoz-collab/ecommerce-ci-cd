@extends('layouts.app')

@section('title', 'Crear venta')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4">Crear venta</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('ventas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Producto</label>
                    <select name="producto_id" class="form-select">
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <select name="cliente_id" class="form-select">
                        @foreach ($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Total</label>
                    <input type="number" step="0.01" name="total" class="form-control" value="{{ old('total') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Ticket (imagen)</label>
                    <input type="file" name="ticket" class="form-control" accept="image/*">
                    <small class="text-muted">Se guardará en disco privado.</small>
                </div>

                <button type="submit" class="btn btn-warning">Guardar venta</button>
            </form>
        </div>
    </div>
@endsection
