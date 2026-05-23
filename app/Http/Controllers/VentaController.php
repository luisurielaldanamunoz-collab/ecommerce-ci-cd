<?php

namespace App\Http\Controllers;

use App\Mail\VentaValidadaCompradorMail;
use App\Mail\VentaValidadaVendedorMail;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Models\Producto;
use App\Models\Usuario;
use App\Models\Venta;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Throwable;

class VentaController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Venta::class);

        /** @var Usuario $usuario */
        $usuario = Auth::user();
        $ventasQuery = Venta::with(['producto', 'cliente', 'vendedor', 'validador']);

        if ($usuario->esCliente()) {
            $ventasQuery->where('cliente_id', $usuario->id);
        }

        $ventas = $ventasQuery->latest()->get();

        return view('ventas.index', compact('ventas'));
    }

    public function create()
    {
        $this->authorize('create', Venta::class);

        $productos = Producto::all();
        $clientes = Usuario::where('rol', 'cliente')->get();

        return view('ventas.create', compact('productos', 'clientes'));
    }

    public function store(StoreVentaRequest $request)
    {
        $this->authorize('create', Venta::class);

        $ticketPath = null;

        if ($request->hasFile('ticket')) {
            $ticketPath = $request->file('ticket')->store('tickets', 'local');
        }

        $venta = Venta::create([
            'producto_id' => $request->producto_id,
            'cliente_id' => $request->cliente_id,
            'vendedor_id' => Auth::id(),
            'fecha' => now()->toDateString(),
            'total' => $request->total,
            'ticket' => $ticketPath,
        ]);

        Log::channel('ventas')->info('Venta creada', [
            'venta_id' => $venta->id,
            'cliente_id' => $venta->cliente_id,
            'vendedor_id' => $venta->vendedor_id,
        ]);

        return redirect()->route('ventas.index');
    }

    public function edit(Venta $venta)
    {
        $this->authorize('update', $venta);

        $productos = Producto::all();
        $clientes = Usuario::where('rol', 'cliente')->get();

        return view('ventas.edit', compact('venta', 'productos', 'clientes'));
    }

    public function update(UpdateVentaRequest $request, Venta $venta)
    {
        $this->authorize('update', $venta);

        $ticketPath = $venta->ticket;

        if ($request->hasFile('ticket')) {
            if ($ticketPath) {
                Storage::disk('local')->delete($ticketPath);
            }
            $ticketPath = $request->file('ticket')->store('tickets', 'local');
        }

        $venta->update([
            'producto_id' => $request->producto_id,
            'cliente_id'  => $request->cliente_id,
            'total'       => $request->total,
            'ticket'      => $ticketPath,
        ]);

        return redirect()->route('ventas.index');
    }

    public function destroy(Venta $venta)
    {
        $this->authorize('delete', $venta);

        if ($venta->ticket) {
            Storage::disk('local')->delete($venta->ticket);
        }

        $venta->delete();

        return redirect()->route('ventas.index');
    }

    public function validateVenta(Venta $venta)
    {
        $this->authorize('validate', $venta);

        $venta->update([
            'validada' => true,
            'validada_por' => Auth::id(),
            'validada_en' => now(),
        ]);

        Log::channel('ventas')->info('Venta validada', [
            'venta_id' => $venta->id,
            'validada_por' => Auth::id(),
        ]);

        $venta->loadMissing(['producto', 'cliente', 'vendedor']);

        try {
            if (! empty($venta->vendedor?->correo)) {
                Mail::to($venta->vendedor->correo)->send(new VentaValidadaVendedorMail($venta));
            }

            if (! empty($venta->cliente?->correo)) {
                Mail::to($venta->cliente->correo)->send(new VentaValidadaCompradorMail($venta));
            }
        } catch (Throwable $e) {
            Log::channel('ventas')->error('Error al enviar correos de venta validada', [
                'venta_id' => $venta->id,
                'error' => $e->getMessage(),
            ]);
        }

        return redirect()->route('ventas.index');
    }

    public function ticket(Venta $venta)
    {
        $this->authorize('viewTicket', $venta);

        if ($venta->ticket && Storage::disk('local')->exists($venta->ticket)) {
            $path = Storage::disk('local')->path($venta->ticket);
            $mimeType = mime_content_type($path) ?: 'image/jpeg';

            return response()->file($path, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => 'inline; filename="ticket_' . $venta->id . '.jpg"',
            ]);
        }

        // Generar ticket dinámicamente si no existe archivo
        return $this->generateTicketImage($venta);
    }

    /**
     * Genera una imagen de ticket dinámicamente
     */
    private function generateTicketImage(Venta $venta)
    {
        // Crear imagen
        $width = 400;
        $height = 600;
        $image = imagecreatetruecolor($width, $height);

        // Colores
        $white = imagecolorallocate($image, 255, 255, 255);
        $black = imagecolorallocate($image, 0, 0, 0);
        $gray = imagecolorallocate($image, 200, 200, 200);
        $blue = imagecolorallocate($image, 52, 152, 219);

        // Fondo blanco
        imagefilledrectangle($image, 0, 0, $width, $height, $white);

        // Línea superior azul
        imagefilledrectangle($image, 0, 0, $width, 80, $blue);

        // Texto "TICKET"
        imagestring($image, 5, 150, 30, 'TICKET', $white);
        imagestring($image, 1, 160, 50, '#' . $venta->id, $white);

        // Borde
        imagerectangle($image, 0, 0, $width - 1, $height - 1, $black);

        // Información
        $y = 100;
        $lineHeight = 25;

        imagestring($image, 3, 20, $y, 'INFORMACION DE VENTA', $black);
        $y += 35;

        imagestring($image, 2, 20, $y, 'Producto:', $black);
        imagestring($image, 1, 150, $y, substr($venta->producto->nombre ?? 'N/A', 0, 30), $gray);
        $y += $lineHeight;

        imagestring($image, 2, 20, $y, 'Cliente:', $black);
        imagestring($image, 1, 150, $y, $venta->cliente->nombre ?? 'N/A', $gray);
        $y += $lineHeight;

        imagestring($image, 2, 20, $y, 'Vendedor:', $black);
        imagestring($image, 1, 150, $y, $venta->vendedor->nombre ?? 'N/A', $gray);
        $y += $lineHeight;

        imagestring($image, 2, 20, $y, 'Fecha:', $black);
        imagestring($image, 1, 150, $y, $venta->fecha, $gray);
        $y += $lineHeight;

        imagestring($image, 2, 20, $y, 'Total:', $black);
        imagestring($image, 1, 150, $y, '$' . number_format($venta->total, 2), $blue);
        $y += $lineHeight * 2;

        // Línea divisoria
        imagerectangle($image, 20, $y, $width - 20, $y + 2, $gray);

        $y += 30;
        imagestring($image, 1, 50, $y, 'Gracias por su compra', $black);
        imagestring($image, 1, 80, $y + 20, 'TIENDA', $blue);

        // Enviar como PNG
        header('Content-Type: image/png');
        header('Content-Disposition: inline; filename="ticket_' . $venta->id . '.png"');

        imagepng($image);
        imagedestroy($image);

        exit();
    }
}
