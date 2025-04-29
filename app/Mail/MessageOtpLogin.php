<?php

namespace App\Mail;

//use App\MensagensAluno;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MessageOtpLogin extends Mailable
{
    use Queueable, SerializesModels;

    //private $aluno;

    //private $mensagem;

    /**
     * Create a new message instance.
     *
     * @param MensagensAluno $mensagensAluno
     * @return void
     */
    /*public function __construct(MensagensAluno $mensagensAluno)
    {
        $this->aluno = $mensagensAluno->aluno;
        $this->mensagem = $mensagensAluno->mensagem;
    }*/

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $titulo = 'Solicitação de acesso';
        $this->subject($titulo);

        return $this->markdown('mensagens._mensagem_otp', [
            'email' => request()->email,
            'token' => request()->token,
        ]);
    }

}
