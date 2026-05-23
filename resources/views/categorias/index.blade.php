@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">Lista de categorías</h2>
                <a href="{{ route('categorias.create') }}" class="btn btn-success">Crear categoría</a>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Productos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($categorias as $categoria)
                            <tr>
                                <td>{{ $categoria->id }}</td>
                                <td>{{ $categoria->nombre }}</td>
                                <td>{{ $categoria->descripcion }}</td>
                                <td>
                                    @forelse ($categoria->productos as $producto)
                                        <span class="badge bg-primary">{{ $producto->nombre }}</span>
                                    @empty
                                        <span class="text-muted">Sin productos</span>
                                    @endforelse
                                </td>
                                <td class="d-flex gap-1">
                                    @can('update', $categoria)
                                        <a href="{{ route('categorias.edit', $categoria->id) }}"
                                            class="btn btn-sm btn-warning">Editar</a>
                                    @endcan
                                    @can('delete', $categoria)
                                        <form action="{{ route('categorias.destroy', $categoria->id) }}" method="POST"
                                            onsubmit="return confirm('¿Eliminar categoría?')">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm btn-danger">Eliminar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay categorías registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
