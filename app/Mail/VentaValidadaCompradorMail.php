<?php

namespace App\Mail;

use App\Models\Venta;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VentaValidadaCompradorMail extends Mailable
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
            ->subject('Tu compra fue validada')
            ->view('emails.venta_validada_comprador');
    }
}
