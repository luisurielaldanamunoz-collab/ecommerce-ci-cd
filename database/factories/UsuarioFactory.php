<?php

namespace Database\Factories;

use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class UsuarioFactory extends Factory
{
    protected $model = Usuario::class;

    public function definition(): array
    {
        $nombres = ['Juan', 'Mario', 'Maria', 'Pedro'];
        $apellidos = ['Lopez', 'Sanchez', 'Hernandez', 'Martinez'];

        $nombre = fake()->randomElement($nombres);
        $apellido = fake()->randomElement($apellidos);
        $correoBase = strtolower(substr($nombre, 0, 1) . $apellido);

        return [
            'nombre' => $nombre,
            'apellidos' => $apellido,
            'correo' => fake()->unique()->numerify($correoBase . '###') . '@tuxtla.tecnm.mx',
            'clave' => Hash::make('123'),
            'rol' => fake()->randomElement(['cliente', 'gerente']),
        ];
    }

    public function comprador(): static
    {
        return $this->state(fn(array $attributes) => [
            'rol' => 'cliente',
        ]);
    }

    public function vendedor(): static
    {
        return $this->state(fn(array $attributes) => [
            'rol' => 'gerente',
        ]);
    }
}
