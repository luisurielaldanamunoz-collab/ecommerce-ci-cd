<?php

namespace App\Policies;

use App\Models\Categoria;
use App\Models\Usuario;

class CategoriaPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return in_array($usuario->rol, ['administrador', 'gerente']);
    }

    public function view(Usuario $usuario, Categoria $categoria): bool
    {
        return in_array($usuario->rol, ['administrador', 'gerente']);
    }

    public function create(Usuario $usuario): bool
    {
        return in_array($usuario->rol, ['administrador', 'gerente']);
    }

    public function update(Usuario $usuario, Categoria $categoria): bool
    {
        return in_array($usuario->rol, ['administrador', 'gerente']);
    }

    public function delete(Usuario $usuario, Categoria $categoria): bool
    {
        return $usuario->rol === 'administrador';
    }
}
