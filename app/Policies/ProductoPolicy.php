<?php

namespace App\Policies;

use App\Models\Producto;
use App\Models\Usuario;

class ProductoPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return true;
    }

    public function view(Usuario $usuario, Producto $producto): bool
    {
        return true;
    }

    public function create(Usuario $usuario): bool
    {
        return in_array($usuario->rol, ['administrador', 'gerente']);
    }

    public function update(Usuario $usuario, Producto $producto): bool
    {
        return in_array($usuario->rol, ['administrador', 'gerente']);
    }

    public function delete(Usuario $usuario, Producto $producto): bool
    {
        return $usuario->rol === 'administrador';
    }
}