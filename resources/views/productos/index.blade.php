@extends('layouts.app')

@section('title', 'Productos')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Lista de productos</h2>

                @if (in_array(auth()->user()->rol, ['administrador', 'gerente']))
                    <a href="{{ route('productos.create') }}" class="btn btn-primary">Crear producto</a>
                @endif
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Fotos</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Existencia</th>
                            <th>Vendedor</th>
                            <th>Categorías</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>
                                    @if (!empty($producto->fotos))
                                        <div class="d-flex gap-1 flex-wrap">
                                            @foreach ($producto->fotos as $foto)
                                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto"
                                                    style="width: 50px; height: 50px; object-fit: cover; border-radius: 6px;">
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-muted">Sin fotos</span>
                                    @endif
                                </td>
                                <td>{{ $producto->descripcion }}</td>
                                <td>${{ number_format($producto->precio, 2) }}</td>
                                <td>{{ $producto->existencia }}</td>
                                <td>{{ $producto->usuario->nombre ?? 'Sin vendedor' }}</td>
                                <td>
                                    @forelse ($producto->categorias as $categoria)
                                        <span class="badge bg-secondary">{{ $categoria->nombre }}</span>
                                    @empty
                                        <span class="text-muted">Sin categorías</span>
                                    @endforelse
                                </td>
                                <td>
                                    @if (in_array(auth()->user()->rol, ['administrador', 'gerente']))
                                        <a href="{{ route('productos.edit', $producto->id) }}"
                                            class="btn btn-warning btn-sm mb-1">
                                            Editar
                                        </a>
                                    @endif

                                    @if (auth()->user()->rol === 'administrador')
                                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No hay productos registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
