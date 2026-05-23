<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $table = 'ventas';

    protected $fillable = [
        'producto_id',
        'vendedor_id',
        'cliente_id',
        'fecha',
        'total',
        'ticket',
        'validada',
        'validada_por',
        'validada_en',
    ];

    protected $casts = [
        'validada' => 'boolean',
        'validada_en' => 'datetime',
    ];

    public function producto()
    {
        return $this->belongsTo(Producto::class, 'producto_id');
    }

    public function cliente()
    {
        return $this->belongsTo(Usuario::class, 'cliente_id');
    }

    public function vendedor()
    {
        return $this->belongsTo(Usuario::class, 'vendedor_id');
    }

    public function validador()
    {
        return $this->belongsTo(Usuario::class, 'validada_por');
    }
}
