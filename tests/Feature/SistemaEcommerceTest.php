<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\CodigoVerificacion;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SistemaEcommerceTest extends TestCase
{
    use RefreshDatabase;

    public function test_pagina_principal_responde_correctamente(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Mi Sistema Laravel');
    }

    public function test_pagina_login_responde_correctamente_en_ruta_entrar(): void
    {
        $response = $this->get('/entrar');

        $response->assertStatus(200);
        $response->assertSee('Iniciar sesión');
    }

    public function test_dashboard_requiere_autenticacion(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/entrar');
    }

    public function test_login_incorrecto_muestra_error_y_no_autentica(): void
    {
        $response = $this->from('/entrar')->post('/entrar', [
            'correo' => 'correo@incorrecto.com',
            'clave' => 'incorrecto',
        ]);

        $response->assertRedirect('/entrar');
        $response->assertSessionHasErrors('correo');
        $this->assertGuest();
    }

    public function test_login_correcto_genera_codigo_2fa_y_redirige_a_verificacion(): void
    {
        Mail::fake();

        $usuario = Usuario::factory()->create([
            'correo' => 'admin@demo.com',
            'clave' => Hash::make('123'),
            'rol' => 'administrador',
        ]);

        $response = $this->post('/entrar', [
            'correo' => 'admin@demo.com',
            'clave' => '123',
        ]);

        $response->assertRedirect('/2fa');
        $response->assertSessionHas('2fa_usuario_id', $usuario->id);
        $this->assertGuest();
        $this->assertDatabaseHas('codigos_verificacion', [
            'usuario_id' => $usuario->id,
        ]);
    }

    public function test_codigo_2fa_valido_autentica_usuario_y_permite_dashboard(): void
    {
        $usuario = Usuario::factory()->create([
            'clave' => Hash::make('123'),
            'rol' => 'administrador',
        ]);

        CodigoVerificacion::create([
            'usuario_id' => $usuario->id,
            'codigo' => '123456',
            'expiracion' => now()->addMinutes(5),
        ]);

        $response = $this->withSession(['2fa_usuario_id' => $usuario->id])
            ->post('/2fa', ['codigo' => '123456']);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($usuario);
        $this->assertDatabaseMissing('codigos_verificacion', [
            'usuario_id' => $usuario->id,
            'codigo' => '123456',
        ]);
    }

    public function test_usuario_autenticado_administrador_puede_acceder_dashboard(): void
    {
        $admin = Usuario::factory()->create(['rol' => 'administrador']);

        $response = $this->actingAs($admin)->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Dashboard');
    }

    public function test_registro_de_producto_se_almacena_en_base_de_datos(): void
    {
        $admin = Usuario::factory()->create(['rol' => 'administrador']);
        $categoria = Categoria::create([
            'nombre' => 'Accesorios',
            'descripcion' => 'Productos tecnológicos de prueba',
        ]);

        $response = $this->actingAs($admin)->post('/productos', [
            'nombre' => 'Teclado mecánico',
            'descripcion' => 'Teclado de prueba para validar almacenamiento.',
            'precio' => 500,
            'existencia' => 15,
            'categorias' => [$categoria->id],
        ]);

        $response->assertRedirect('/productos');
        $this->assertDatabaseHas('productos', [
            'nombre' => 'Teclado mecánico',
            'precio' => 500,
            'existencia' => 15,
            'usuario_id' => $admin->id,
        ]);
        $this->assertDatabaseHas('categoria_producto', [
            'categoria_id' => $categoria->id,
        ]);
    }

    public function test_producto_no_se_guarda_si_faltan_datos_obligatorios(): void
    {
        $admin = Usuario::factory()->create(['rol' => 'administrador']);

        $response = $this->actingAs($admin)->from('/productos/create')->post('/productos', [
            'nombre' => '',
            'descripcion' => '',
            'precio' => '',
            'existencia' => '',
            'categorias' => [],
        ]);

        $response->assertRedirect('/productos/create');
        $response->assertSessionHasErrors(['nombre', 'descripcion', 'precio', 'existencia', 'categorias']);
        $this->assertDatabaseCount('productos', 0);
    }

    public function test_cliente_no_puede_registrar_productos(): void
    {
        $cliente = Usuario::factory()->create(['rol' => 'cliente']);
        $categoria = Categoria::create(['nombre' => 'Accesorios']);

        $response = $this->actingAs($cliente)->post('/productos', [
            'nombre' => 'Mouse gamer',
            'descripcion' => 'Producto que no debe registrarse por falta de permisos.',
            'precio' => 300,
            'existencia' => 5,
            'categorias' => [$categoria->id],
        ]);

        $response->assertForbidden();
        $this->assertDatabaseMissing('productos', [
            'nombre' => 'Mouse gamer',
        ]);
    }
}
