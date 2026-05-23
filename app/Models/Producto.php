<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'existencia',
        'fotos',
        'usuario_id',
    ];

    protected $casts = [
        'fotos' => 'array',
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function categorias()
    {
        return $this->belongsToMany(Categoria::class, 'categoria_producto');
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }
}
