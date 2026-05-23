<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';

    protected $fillable = [
        'nombre',
        'apellidos',
        'correo',
        'clave',
        'rol',
    ];

    protected $hidden = [
        'clave',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->clave;
    }

    public function productos()
    {
        return $this->hasMany(Producto::class);
    }

    public function ventasComoCliente()
    {
        return $this->hasMany(Venta::class, 'cliente_id');
    }

    public function ventasComoVendedor()
    {
        return $this->hasMany(Venta::class, 'vendedor_id');
    }

    public function esAdministrador()
    {
        return $this->rol === 'administrador';
    }

    public function esGerente()
    {
        return $this->rol === 'gerente';
    }

    public function esCliente()
    {
        return $this->rol === 'cliente';
    }
}