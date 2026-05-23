@extends('layouts.app')

@section('title', 'Editar producto')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4">Editar producto</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('productos.update', $producto->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control"
                        value="{{ old('precio', $producto->precio) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Existencia</label>
                    <input type="number" name="existencia" class="form-control"
                        value="{{ old('existencia', $producto->existencia) }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Reemplazar fotos del producto</label>
                    <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted">Si subes nuevas fotos, se reemplazan las actuales.</small>
                </div>

                @if (!empty($producto->fotos))
                    <div class="mb-3">
                        <label class="form-label d-block">Fotos actuales</label>
                        <div class="d-flex gap-2 flex-wrap">
                            @foreach ($producto->fotos as $foto)
                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto del producto"
                                    style="width: 80px; height: 80px; object-fit: cover; border-radius: 8px;">
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <label class="form-label">Categorías</label>
                    @foreach ($categorias as $categoria)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categorias[]" value="{{ $categoria->id }}"
                                id="categoria{{ $categoria->id }}"
                                {{ $producto->categorias->contains($categoria->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="categoria{{ $categoria->id }}">
                                {{ $categoria->nombre }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-warning">Actualizar producto</button>
            </form>
        </div>
    </div>
@endsection
