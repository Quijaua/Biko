@component('mail::message')
Olá, {{ $user->name }}!

Recebemos sua solicitação de acesso sem senha ao Sistema Exemplo.

Para entrar, basta clicar no botão abaixo:

@component('mail::button', ['url' => $url])
Entrar sem senha
@endcomponent

Este link mágico é válido por 10 minutos e pode ser usado apenas uma vez.

Se você não solicitou este acesso, pode ignorar este e-mail com segurança.

Obrigada,
UNEafro Brasil
@endcomponent