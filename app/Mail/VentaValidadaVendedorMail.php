<?php

namespace App\Mail;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VentaValidadaVendedorMail extends Mailable
{
    use Queueable, SerializesModels;

    public Venta $venta;

    public function __construct(Venta $venta)
    {
        $this->venta = $venta;
    }

    public function build(): self
    {
        return $this
            ->subject('Venta validada: producto vendido')
            ->view('emails.venta_validada_vendedor');
    }
}
