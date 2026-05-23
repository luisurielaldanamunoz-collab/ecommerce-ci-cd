<?php

namespace Database\Seeders;

use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Categoria;
use Illuminate\Database\Seeder;

class ProductoSeeder extends Seeder
{
    public function run(): void
    {
        $vendedores = Usuario::where('rol', 'gerente')->get();
        $categoriasIds = Categoria::pluck('id');

        if ($vendedores->isEmpty() || $categoriasIds->isEmpty()) {
            return;
        }

        $nombresBase = [
            'Laptop',
            'Mouse',
            'Teclado',
            'Monitor',
            'Bocina',
            'Silla',
            'Escritorio',
            'Lampara',
            'Audifonos',
            'Webcam',
        ];

        foreach ($vendedores as $vendedor) {
            $cantidadProductos = fake()->numberBetween(3, 6);

            for ($i = 1; $i <= $cantidadProductos; $i++) {
                $nombreBase = fake()->randomElement($nombresBase);

                $producto = Producto::create([
                    'nombre' => $nombreBase . ' ' . fake()->bothify('##??'),
                    'descripcion' => fake()->sentence(12),
                    'precio' => fake()->randomFloat(2, 150, 30000),
                    'existencia' => fake()->numberBetween(1, 60),
                    'usuario_id' => $vendedor->id,
                ]);

                $totalCategorias = fake()->numberBetween(1, min(3, $categoriasIds->count()));
                $producto->categorias()->attach($categoriasIds->random($totalCategorias)->all());
            }
        }
    }
}
