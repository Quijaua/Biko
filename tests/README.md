# Testes do Biko

Suíte de regressão criada na Fase 0 do upgrade para o Laravel 13
(veja o plano no projeto). O objetivo é detectar qualquer quebra de
comportamento durante a troca de versão do framework e dos pacotes.

## Preparar o banco de testes (uma vez)

Os testes usam `RefreshDatabase`: **todas as tabelas são apagadas e
recriadas**. Por isso usam um banco separado, `biko_testing`. O
`tests/CreatesApplication.php` aborta a execução se o banco configurado
não terminar em `_testing`.

```sql
CREATE DATABASE biko_testing CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
GRANT ALL PRIVILEGES ON biko_testing.* TO 'biko'@'localhost';
```

Host, usuário e senha vêm do seu `.env`; o nome do banco é definido no
`phpunit.xml`.

## Rodar

```bash
vendor/bin/phpunit                      # tudo
vendor/bin/phpunit --testsuite Feature  # só feature
vendor/bin/phpunit --filter OtpLogin    # um arquivo/teste
```

## Snapshot de rotas

`tests/Feature/Smoke/RouteSnapshotTest.php` compara a tabela de rotas
(método, URI, nome, controller e middlewares) com
`tests/fixtures/routes.json`.

- Na primeira execução o arquivo é gerado e o teste aparece como *skipped*:
  revise e faça commit.
- Se uma mudança de rota for intencional, regenere:
  `UPDATE_SNAPSHOTS=1 vendor/bin/phpunit --filter RouteSnapshot`

## O que está coberto

| Arquivo | Fluxo |
|---|---|
| `AuthenticationTest` | login, senha errada, hCaptcha obrigatório fora de local, registro de acesso do aluno, logout, reset de senha |
| `OtpLoginTest` | envio do link por e-mail, token válido/inválido, redirecionamento do Esperança Garcia |
| `HomeByRoleTest` | `/home` para cada perfil, primeiro login, e-mail não verificado |
| `AccessControlTest` | `restrict.aluno`, `restrict.professor` e `permissions` por perfil, JSON do dashboard |
| `AdminPagesTest` | telas principais do administrador renderizando |
| `PublicPagesTest` | páginas sem login |
| `ExcelExportTest` | exportação real de alunos, professores e coordenadores |
| `ApiCadastroAlunoTest` | `POST /api/cadastro-aluno` com `api_token` |
| `SejaUmProfessorTest` | inscrição de voluntário e e-mail ao coordenador |
| `QuestionarioTest` | criação de questionário (pacote laravel-quiz) |
| `Unit/PhotoProcessingTest` | `FotoPerfilService` (Intervention Image 3) |
| `Fase1/BugFixesTest` | correções da Fase 1: visitante em rotas `permissions`, `api_token` do seeder, hash de senhas em texto puro |
| `Fase1/FrameworkCleanupTest` | factory em classe, config de e-mail `mailers`, providers padrão |

Os dados de teste são criados por `tests/Concerns/CreatesBikoData.php`,
direto pelos models. Para novos testes também dá para usar `User::factory()`.
