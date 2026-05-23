<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\Usuario;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $this->authorize('viewDashboard', Usuario::class);
        $this->authorize('viewStatistics', Usuario::class);

        $categorias = Categoria::with(['productos', 'ventas.cliente'])->get();
        $productoMasVendido = Producto::withCount('ventas')->orderByDesc('ventas_count')->first();

        return view('dashboard', [
            'totalUsuarios' => Usuario::count(),
            'totalVendedores' => Usuario::where('rol', 'gerente')->count(),
            'totalCompradores' => Usuario::where('rol', 'cliente')->count(),
            'productosPorCategoria' => $categorias,
            'productoMasVendido' => $productoMasVendido,
            'compradorFrecuentePorCategoria' => $this->compradorFrecuentePorCategoria($categorias),
        ]);
    }

    private function compradorFrecuentePorCategoria(Collection $categorias): Collection
    {
        return $categorias->mapWithKeys(function (Categoria $categoria) {
            $agrupadas = $categoria->ventas->groupBy('cliente_id');

            if ($agrupadas->isEmpty()) {
                return [
                    $categoria->id => [
                        'categoria' => $categoria,
                        'comprador' => null,
                        'total' => 0,
                    ],
                ];
            }

            $top = $agrupadas->sortByDesc(fn(Collection $ventas) => $ventas->count())->first();

            return [
                $categoria->id => [
                    'categoria' => $categoria,
                    'comprador' => $top->first()->cliente,
                    'total' => $top->count(),
                ],
            ];
        });
    }
}
