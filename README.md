# Biko

O **Biko** é um sistema de gestão de cursinhos populares, desenvolvido para atender às demandas da [Uneafro Brasil](http://uneafrobrasil.org/). Inicialmente criado em Drupal 7, foi portado para Laravel para oferecer maior flexibilidade e escalabilidade.

Biko é uma aplicação web que centraliza e simplifica processos acadêmicos e administrativos, promovendo eficiência e acessibilidade para todos os envolvidos.

---

## Sumário

1. [Instruções de Instalação](#instruções-de-instalação)
2. [Instruções de Utilização](#instruções-de-utilização)
3. [Credenciais para Teste](#credenciais-para-teste)
4. [Funcionalidades](#funcionalidades-da-aplicação)
5. [Cargos da Aplicação](#cargos-da-aplicação)

---

## Instruções de Instalação

### Requisitos

- PHP >= 8.0
- Composer
- Banco de dados (MySQL, PostgreSQL, etc.)
- Node.js e npm

### Passos para Instalação

1. **Clone o repositório**:

   ```bash
   git clone https://github.com/Quijaua/Biko.git
   cd Biko
   ```

2. **Instale as dependências do PHP**:

   ```bash
   composer install
   ```

3. **Instale as dependências do Node.js**:

   ```bash
   npm install
   ```

4. **Configure o arquivo `.env`**:

   - Copie o arquivo de exemplo:
     ```bash
     cp .env.example .env
     ```
   - Edite o arquivo `.env` com as credenciais do banco de dados e outras configurações.

5. **Gere a chave da aplicação**:

   ```bash
   php artisan key:generate
   ```

6. **Execute as migrações**:

   ```bash
   php artisan migrate
   ```

7. **Inicie o servidor**:

   ```bash
   php artisan serve
   ```

8. **Acesse a aplicação**:
   - Abra o navegador e vá para: [http://localhost:8000](http://localhost:8000)

---

## Instruções de Utilização

### Acessando a Aplicação

1. Após iniciar o servidor, abra o navegador e acesse: [http://localhost:8000](http://localhost:8000).
2. Faça login com suas credenciais fornecidas pelo administrador.

---

## Credenciais para Teste

Após a instalação, utilize as credenciais abaixo para acessar o sistema e explorar suas funcionalidades:

- **Administrador**

  - Email: `admin@biko.edu`
  - Senha: `admin@biko.edu`

- **Aluno A**

  - Email: `alunoa@biko.edu`
  - Senha: `alunoa@biko.edu`

- **Aluno B**

  - Email: `alunob@biko.edu`
  - Senha: `alunob@biko.edu`

- **Coordenador A**

  - Email: `coordenadora@biko.edu`
  - Senha: `coordenadora@biko.edu`

- **Coordenador B**
  - Email: `coordenadorb@biko.edu`
  - Senha: `coordenadorb@biko.edu`

Essas credenciais são geradas automaticamente pelas seeders durante o processo de migração do banco de dados.

---

## Funcionalidades da Aplicação

- **Gerenciamento de Estudantes**  
  Permite cadastrar, editar e gerenciar informações dos estudantes, incluindo frequência.

- **Gerenciamento de Professores**  
  Permite cadastrar, editar e gerenciar informações dos professores, incluindo disciplinas atribuídas e horários de aula.

- **Gerenciamento de Coordenadores**  
  Permite cadastrar, editar e gerenciar informações dos coordenadores, responsáveis por supervisionar núcleos e disciplinas.

- **Funcionalidade de Apoio Emocional**  
  Estudantes podem solicitar apoio psicológico diretamente pelo sistema. Inclui funcionalidades para registro de prontuários e gerenciamento de agendas dos psicólogos.

- **Gerenciamento de Profissionais Psicólogos**  
  Permite cadastrar, editar e gerenciar informações dos psicólogos, incluindo supervisão de atendimentos e relatórios.

- **Adição de Núcleos de Cursinhos Físicos**  
  Permite adicionar e gerenciar núcleos físicos, organizando disciplinas, professores e turmas de forma centralizada.

- **Adição de Núcleos Virtuais**  
  Permite criar núcleos virtuais onde os alunos podem assistir aulas online. Inclui a funcionalidade para os alunos marcarem se assistiram ou não as aulas, possibilitando o gerenciamento de visualização.

- **Gerenciamento de Aulas por Matérias**  
  Permite organizar e gerenciar aulas com base nas matérias, facilitando o planejamento e acompanhamento.

- **Acompanhamento de Métricas por Dashboard**  
  Inclui dashboards para visualização de métricas e relatórios, como desempenho dos alunos, frequência e outros dados relevantes.

- **Funcionalidade EAD**  
  Permite agendar e gerenciar eventos de ensino a distância, incluindo aulas e atividades online.

- **Login sem Senha**  
  Permite que os usuários acessem o sistema utilizando métodos alternativos, como links mágicos enviados por email, garantindo praticidade e segurança.

- **Acessibilidade e Inclusão**  
  O sistema foi projetado com foco em acessibilidade e inclusão e sempre está evoluindo cada vez mais nesse quisito. Inclui suporte a contraste adequado para pessoas com baixa visão e campos de cadastro específicos para pessoas de diversas etnias, territórios, comunidades e para pessoas com deficiência (PCD), promovendo maior representatividade e equidade.

- **Muito Mais**  
  A aplicação oferece diversas outras funcionalidades para atender às necessidades acadêmicas e administrativas, como geração de relatórios, envio de mensagens e integração com sistemas externos.

---

## Cargos da Aplicação

### 1. Administrador

- Responsável por gerenciar toda a aplicação.
- Permissões: Gerenciar usuários, configurar o sistema, acessar relatórios completos.

### 2. Coordenador

- Gerencia disciplinas, professores e alunos de um núcleo específico.
- Permissões: Criar e editar disciplinas, atribuir professores, visualizar relatórios do núcleo.

### 3. Professor

- Responsável por ministrar aulas, adicionar materiais e gerenciar frequência dos alunos.
- Permissões: Registrar frequência, enviar materiais didáticos, visualizar estudantes, coordenadores, núcleos, núcleos virtuais e criar eventos.

### 4. Aluno

- Usuário final que acessa conteúdos e informações relacionadas às suas disciplinas.
- Permissões: Visualizar materiais, frequência, enviar mensagens e pedir auxilio emocional.

### 5. Psicólogo

- Oferece suporte psicológico aos alunos.
- Permissões: Registrar atendimentos, acessar histórico de suporte, gerenciar prontuários.

### 6. Psicólogo Supervisor

- Supervisiona os atendimentos psicológicos realizados pelos psicólogos.
- Permissões: Revisar atendimentos, acessar relatórios detalhados, gerenciar prontuários.
