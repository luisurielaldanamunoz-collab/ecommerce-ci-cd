<?php

namespace App\Policies;

use App\Models\Usuario;
use App\Models\Venta;

class VentaPolicy
{
    public function viewAny(Usuario $usuario): bool
    {
        return $usuario->esGerente() || $usuario->esCliente();
    }

    public function view(Usuario $usuario, Venta $venta): bool
    {
        if ($usuario->esGerente()) {
            return true;
        }

        return $usuario->esCliente() && $venta->cliente_id === $usuario->id;
    }

    public function create(Usuario $usuario): bool
    {
        return $usuario->esGerente();
    }

    public function viewTicket(Usuario $usuario, Venta $venta): bool
    {
        if ($usuario->esGerente()) {
            return true;
        }

        return $usuario->esCliente() && $venta->cliente_id === $usuario->id;
    }

    public function validate(Usuario $usuario, Venta $venta): bool
    {
        return $usuario->esGerente() && ! $venta->validada;
    }

    public function update(Usuario $usuario, Venta $venta): bool
    {
        return $usuario->esAdministrador() ||
            ($usuario->esGerente() && $venta->vendedor_id === $usuario->id && ! $venta->validada);
    }

    public function delete(Usuario $usuario, Venta $venta): bool
    {
        return $usuario->esAdministrador();
    }
}
