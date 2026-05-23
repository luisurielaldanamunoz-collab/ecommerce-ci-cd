<?php

namespace App\Policies;

use App\Models\Usuario;

class UsuarioPolicy
{
    public function create(Usuario $usuario): bool
    {
        return $usuario->esAdministrador();
    }

    public function viewDashboard(Usuario $usuario): bool
    {
        return $usuario->esAdministrador();
    }

    public function viewStatistics(Usuario $usuario): bool
    {
        return $usuario->esAdministrador();
    }
}
