<?php

namespace Database\Seeders;

use App\Models\Categoria;
use Illuminate\Database\Seeder;

class CategoriaSeeder extends Seeder
{
    public function run(): void
    {
        $categorias = [
            [
                'nombre' => 'Computadoras',
                'descripcion' => 'Equipos de cómputo y accesorios'
            ],
            [
                'nombre' => 'Celulares',
                'descripcion' => 'Teléfonos inteligentes y accesorios'
            ],
            [
                'nombre' => 'Hogar',
                'descripcion' => 'Productos para el hogar'
            ],
            [
                'nombre' => 'Oficina',
                'descripcion' => 'Artículos para oficina'
            ],
        ];

        foreach ($categorias as $categoria) {
            Categoria::create($categoria);
        }
    }
}