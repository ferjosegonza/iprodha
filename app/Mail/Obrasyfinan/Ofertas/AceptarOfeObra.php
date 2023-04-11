<?php

namespace App\Mail\Obrasyfinan\Ofertas;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AceptarOfeObra extends Mailable
{
    use Queueable, SerializesModels;

    public $name;
    public $oferta;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($name, $oferta)
    {
        $this->name = $name;
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
                    ->view('Obrasyfinan.Ofertas.mail.aceptar');
    }
}
