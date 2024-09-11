<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;



class ResponseNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $notificacao;

    /**
     * Create a new message instance.
     *
     * @param $monitoramento
     * @param $resposta
     */
    public function __construct($notificacao)
    {
        $this->notificacao = $notificacao;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.sendEmailRespostaCriada')
            ->subject('Nova Resposta Criada')
            ->with('notificacao', $this->notificacao);
    }
}
