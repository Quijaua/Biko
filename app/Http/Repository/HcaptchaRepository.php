<?php

namespace App\Http\Repository;

use GuzzleHttp\Client;
use Throwable;

class HcaptchaRepository
{
    /**
     * Confere no hCaptcha se o desafio foi resolvido.
     *
     * Em local/develop sempre aceita. Resposta vazia, erro de rede ou
     * resposta inesperada contam como desafio NÃO resolvido (antes, um erro
     * de rede virava erro 500).
     */
    public function validate($challenge, ?string $ip = null): bool
    {
        if (in_array(config('app.env'), ['develop', 'local'], true)) {
            return true;
        }

        if (! is_string($challenge) || $challenge === '') {
            return false;
        }

        try {
            $client = new Client([
                'base_uri' => 'https://hcaptcha.com',
                'timeout' => 10,
            ]);

            $response = $client->request('POST', '/siteverify', [
                'form_params' => array_filter([
                    'secret' => config('services.hcaptcha.secret'),
                    'response' => $challenge,
                    'remoteip' => $ip,
                ]),
            ]);

            $body = json_decode((string) $response->getBody());

            return (bool) ($body->success ?? false);
        } catch (Throwable $e) {
            report($e);

            return false;
        }
    }
}
