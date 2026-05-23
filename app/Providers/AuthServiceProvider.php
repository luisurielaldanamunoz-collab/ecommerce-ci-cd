<?php

namespace App\Providers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use App\Policies\CategoriaPolicy;
use App\Policies\ProductoPolicy;
use App\Policies\UsuarioPolicy;
use App\Policies\VentaPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Categoria::class => CategoriaPolicy::class,
        Producto::class => ProductoPolicy::class,
        Usuario::class => UsuarioPolicy::class,
        Venta::class => VentaPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}
