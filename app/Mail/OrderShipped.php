<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $oferta;
    public $comentario;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $oferta, $comentario)
    {
        $this->name = $name;
        $this->comentario = $comentario;
        $this->oferta = $oferta;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('no-reply@iprodha.misiones.gob.ar', 'IPRODHA')
                    ->subject('Oferta de Obra')
                    ->view('Obrasyfinan.Ofertas.mail.rechazar');
    }
}
