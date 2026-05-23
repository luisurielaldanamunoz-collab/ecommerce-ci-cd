@extends('layouts.app')

@section('title', 'Crear usuario')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="mb-4">Crear usuario</h2>

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form action="{{ route('usuarios.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" value="{{ old('apellidos') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Correo</label>
                    <input type="email" name="correo" class="form-control" value="{{ old('correo') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label">Rol</label>
                    <select name="rol" class="form-select">
                        <option value="administrador" @selected(old('rol') === 'administrador')>Administrador</option>
                        <option value="gerente" @selected(old('rol') === 'gerente')>Gerente</option>
                        <option value="cliente" @selected(old('rol') === 'cliente')>Cliente</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Contraseña</label>
                    <input type="password" name="clave" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Confirmar contraseña</label>
                    <input type="password" name="clave_confirmation" class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Guardar usuario</button>
            </form>
        </div>
    </div>
@endsection
