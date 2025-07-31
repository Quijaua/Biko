<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageOtpLogin extends Mailable
{
    use Queueable, SerializesModels;

    public $email;
    public $user;
    public $url;

    public function __construct($email, $url, $user)
    {
        $this->email = $email;
        $this->url = $url;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('Solicitação de acesso')
            ->markdown('mensagens._mensagem_otp', [
                'email' => $this->email,
                'url' => $this->url,
                'user' => $this->user,
            ]);
    }
}
