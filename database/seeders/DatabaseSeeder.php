<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Usuario::firstOrCreate(
            ['correo' => 'admin@tuxtla.tecnm.mx'],
            [
                'nombre' => 'Admin',
                'apellidos' => 'Sistema',
                'clave' => Hash::make('123'),
                'rol' => 'administrador',
            ]
        );

        Usuario::factory()->comprador()->count(70)->create();
        Usuario::factory()->vendedor()->count(30)->create();

        $this->call([
            CategoriaSeeder::class,
            ProductoSeeder::class,
        ]);
    }
}
