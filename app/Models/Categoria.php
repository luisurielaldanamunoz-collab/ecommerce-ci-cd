<?php

namespace App\Models;

use App\Models\CategoriaProducto;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion',
    ];

    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'categoria_producto');
    }

    public function ventas(): HasManyThrough
    {
        return $this->hasManyThrough(
            Venta::class,
            CategoriaProducto::class,
            'categoria_id',
            'producto_id',
            'id',
            'producto_id'
        );
    }
}
