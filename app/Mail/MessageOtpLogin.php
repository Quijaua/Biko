<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageOtpLogin extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $titulo = 'Solicitação de acesso';
        $this->subject($titulo);
        $otp_hash = User::where('email', request()->email)->first()->otp_hash;

        $this->markdown('mensagens._mensagem_otp', [
            'email' => request()->email,
            'token' => $otp_hash,
        ]);

        return true;
    }

}
