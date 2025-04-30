@component('mail::message')

Ola, recebemos sua solicitação de acesso.

Siga o link abaixo para validar a sua solicitação:

@component('mail::button', ['url' => route('otp-verify', ['email' => $email, 'token' => $token])])
Validar Acesso
@endcomponent

@endcomponent