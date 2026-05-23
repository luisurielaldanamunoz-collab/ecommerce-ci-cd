@extends('layouts.app')

@section('title', 'Crear producto')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4">Crear producto</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" rows="3">{{ old('descripcion') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Precio</label>
                    <input type="number" step="0.01" name="precio" class="form-control" value="{{ old('precio') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Existencia</label>
                    <input type="number" name="existencia" class="form-control" value="{{ old('existencia') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Fotos del producto</label>
                    <input type="file" name="fotos[]" class="form-control" accept="image/*" multiple>
                    <small class="text-muted">Puedes subir varias imágenes.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categorías</label>
                    @foreach ($categorias as $categoria)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categorias[]" value="{{ $categoria->id }}"
                                id="categoria{{ $categoria->id }}">
                            <label class="form-check-label" for="categoria{{ $categoria->id }}">
                                {{ $categoria->nombre }}
                            </label>
                        </div>
                    @endforeach
                </div>

                <button type="submit" class="btn btn-primary">Guardar producto</button>
            </form>
        </div>
    </div>
@endsection
