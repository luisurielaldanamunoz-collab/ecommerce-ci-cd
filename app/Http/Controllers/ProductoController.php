<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();

        if ($usuario->esGerente()) {
            $productos = Producto::with(['usuario', 'categorias'])
                ->where('usuario_id', $usuario->id)
                ->get();
        } else {
            $productos = Producto::with(['usuario', 'categorias'])->get();
        }

        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $this->authorize('create', Producto::class);

        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(StoreProductoRequest $request)
    {
        $this->authorize('create', Producto::class);

        $fotos = [];

        if ($request->hasFile('fotos')) {
            foreach ($request->file('fotos') as $foto) {
                $fotos[] = $foto->store('productos', 'public');
            }
        }

        $producto = Producto::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'existencia' => $request->existencia,
            'fotos' => $fotos,
            'usuario_id' => Auth::id(),
        ]);

        $producto->categorias()->attach($request->categorias);

        Log::channel('productos')->info('Producto creado', [
            'producto_id' => $producto->id,
            'usuario_id' => Auth::id(),
        ]);

        return redirect()->route('productos.index');
    }

    public function edit(Producto $producto)
    {
        $this->authorize('update', $producto);

        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $this->authorize('update', $producto);

        $fotos = $producto->fotos ?? [];

        if ($request->hasFile('fotos')) {
            foreach ($fotos as $fotoAnterior) {
                Storage::disk('public')->delete($fotoAnterior);
            }

            $fotos = [];

            foreach ($request->file('fotos') as $foto) {
                $fotos[] = $foto->store('productos', 'public');
            }
        }

        $producto->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'existencia' => $request->existencia,
            'fotos' => $fotos,
        ]);

        $producto->categorias()->sync($request->categorias);

        Log::channel('productos')->info('Producto editado', [
            'producto_id' => $producto->id,
            'usuario_id' => Auth::id(),
        ]);

        return redirect()->route('productos.index');
    }

    public function destroy(Producto $producto)
    {
        $this->authorize('delete', $producto);

        foreach (($producto->fotos ?? []) as $foto) {
            Storage::disk('public')->delete($foto);
        }

        Log::channel('productos')->info('Producto eliminado', [
            'producto_id' => $producto->id,
            'usuario_id' => Auth::id(),
        ]);

        $producto->delete();

        return redirect()->route('productos.index');
    }
}
