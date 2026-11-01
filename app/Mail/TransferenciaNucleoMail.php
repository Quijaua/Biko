<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Avisos do fluxo de transferência de Núcleo (pedido, aprovação e recusa).
 */
class TransferenciaNucleoMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, string>  $linhas
     */
    public function __construct(
        public string $assunto,
        public array $linhas,
        public ?string $mensagem,
        public string $link,
        public string $textoLink,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(config('mail.from.address'), 'Biko'),
            subject: $this->assunto,
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.transferenciaNucleo');
    }
}
