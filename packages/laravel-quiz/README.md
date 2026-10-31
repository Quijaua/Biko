# harishdurga/laravel-quiz (cópia local do Biko)

Cópia do pacote [harishdurga/laravel-quiz](https://github.com/harishdurga/laravel-quiz)
**v2.0.0** (agosto/2024), licença MIT (ver `LICENSE.md`).

## Por que está aqui

A versão publicada exige `illuminate/support ^11.0` e não recebe
atualização desde 08/2024, o que impedia o upgrade do Biko para os
Laravel 12 e 13. O código foi copiado sem alterações. A única mudança
está no `composer.json`:

- restrição ampliada para `illuminate/support ^11.0|^12.0|^13.0`;
- versão fixada em `2.0.1` para o Composer;
- removidos `require-dev`, testes e arquivos de CI do pacote original.

O `composer.json` da raiz do Biko carrega este diretório via
repositório do tipo `path`. Namespace, migrations, seeders e
configuração (`config/laravel-quiz.php`) continuam iguais, então nenhum
código do Biko precisou mudar.

## Se o pacote original voltar a ser mantido

Remova o bloco `repositories` do `composer.json` da raiz, ajuste a
restrição de `harishdurga/laravel-quiz` para a nova versão e apague esta
pasta.
