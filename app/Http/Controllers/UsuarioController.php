<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function create()
    {
        $this->authorize('create', Usuario::class);

        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', Usuario::class);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellidos' => 'required|string|max:255',
            'correo' => 'required|email|max:255|unique:usuarios,correo',
            'clave' => 'required|string|min:3|confirmed',
            'rol' => 'required|in:administrador,gerente,cliente',
        ]);

        Usuario::create([
            'nombre' => $validated['nombre'],
            'apellidos' => $validated['apellidos'],
            'correo' => $validated['correo'],
            'clave' => Hash::make($validated['clave']),
            'rol' => $validated['rol'],
        ]);

        return redirect()->route('dashboard')->with('status', 'Usuario creado correctamente.');
    }
}
