# Meu Saldo Certo

Aplicacao web de controle financeiro pessoal, desenvolvida com Laravel 12 e foco em experiencia de uso, organizacao de codigo e qualidade tecnica para portfolio profissional.

![Laravel](https://img.shields.io/badge/Laravel-12%2B-red)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)
![Status](https://img.shields.io/badge/status-MVP%20Avancado-green)
![Tests](https://img.shields.io/badge/tests-feature%20tests-brightgreen)
![License](https://img.shields.io/badge/license-MIT-lightgrey)

> Projeto orientado a produto real: autenticacao completa, isolamento por usuario, dashboard analitico e fluxo de transacoes com foco em manutencao e evolucao.

## Visao Geral

Meu Saldo Certo e uma solucao para acompanhamento de receitas e despesas, com interface responsiva em portugues (pt-BR), autenticacao segura e painel financeiro com indicadores principais.

O projeto foi estruturado para demonstrar boas praticas de desenvolvimento Laravel, incluindo:

- arquitetura MVC bem definida
- validacao com Form Requests
- autorizacao por ownership com Policies
- testes automatizados para fluxos criticos
- frontend com Blade, Tailwind CSS e Alpine.js

## Funcionalidades

### Autenticacao

- login, registro e logout com Laravel Breeze
- recuperacao de senha por e-mail (SMTP/Mailtrap)
- layout split-screen com branding e formulario
- feedback visual de erro no login (banner + campos destacados)
- estado de loading no botao de login com Alpine.js

### Dashboard

- total de receitas
- total de despesas
- saldo consolidado
- grafico mensal (receitas x despesas) com Chart.js
- filtro por periodo: ultimos 7 dias, ultimos 30 dias, mes atual e todos

### Transações

- CRUD completo (criar, listar, editar e excluir)
- transacoes vinculadas ao usuario autenticado
- filtros integrados para analise no dashboard

### Categorias

- categorias vinculadas por usuario
- suporte ao fluxo de categorias no cadastro e edicao de transacoes

## Stack Tecnologica

- Laravel 12
- PHP 8.2+
- Blade
- Tailwind CSS
- Alpine.js
- Vite
- Chart.js
- SQLite (ambiente local)
- Laravel Breeze
- PHPUnit (Feature Tests)

## Arquitetura do Projeto

O projeto segue MVC com separacao de responsabilidades:

- Models: regras de dominio e relacionamentos
- Controllers: orquestracao dos casos de uso
- Form Requests: validacao de entrada
- Policies: autorizacao por ownership
- Views Blade: camada de apresentacao
- Migrations e Seeders: evolucao e estado inicial do banco

Estrutura principal:

```text
app/
  Http/
    Controllers/
    Requests/
  Models/
  Policies/
  Support/
database/
  migrations/
  seeders/
resources/
  views/
routes/
  web.php
  auth.php
tests/
  Feature/
```

## Modelo de Dados

Entidades principais:

- `users`: usuarios autenticados
- `categories`: categorias por usuario
- `transactions`: lancamentos financeiros por usuario e categoria

Relacionamentos:

- User 1:N Transactions
- User 1:N Categories
- Category 1:N Transactions

## Seguranca e Qualidade

- isolamento por usuario em recursos financeiros
- autorizacao com `TransactionPolicy`
- validacao centralizada com Form Requests
- protecao CSRF nativa do Laravel
- testes de feature cobrindo fluxos criticos

Exemplos de cenarios cobertos:

- criacao de transacao valida
- bloqueio de valor menor ou igual a zero
- bloqueio de alteracao/exclusao por usuario nao dono
- fluxo de recuperacao de senha
- aplicacao de filtros por periodo

## Setup Local (passo a passo)

Pre-requisitos:

- PHP 8.2+
- Composer
- Node.js e npm
- SQLite

Instalacao:

```bash
git clone <url-do-repositorio>
cd SaldoPro

composer install
npm install

cp .env.example .env
php artisan key:generate

# Configure banco e SMTP no .env
php artisan migrate --seed
```

Configuracao de e-mail (Mailtrap):

```dotenv
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=seu_usuario_mailtrap
MAIL_PASSWORD=sua_senha_mailtrap
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="no-reply@meusaldocerto.com"
MAIL_FROM_NAME="Meu Saldo Certo"
```

## Execucao do projeto

Em desenvolvimento, rode em dois terminais:

```bash
# Terminal 1
php artisan serve --host=127.0.0.1 --port=8000

# Terminal 2
npm run dev
```

Acesse:

- <http://127.0.0.1:8000>

## Testes

Executar todos os testes:

```bash
php artisan test
```

Executar somente testes de transacoes:

```bash
php artisan test --filter="TransactionTest"
```

Executar somente testes de autenticacao/reset:

```bash
php artisan test --filter="PasswordResetTest"
```

## Screenshots

As capturas abaixo documentam o fluxo principal da aplicacao:

### Login

![Login](Login.PNG)

### Criar Conta

![Criar Conta](CriarConta.PNG)

### Erro de Login

![Erro de Login](ErroLogin.PNG)

### Dashboard

![Dashboard](Dashboard.PNG)

### Nova Transacao

![Nova Transacao](NovaTransação.PNG)

### Lista de Transacoes

![Transacoes](Transações.PNG)

### Editar Transacao

![Editar Transacao](EditarTransação.PNG)

## Roadmap

Proximas evolucoes recomendadas:

- tema escuro (dark mode)
- filtros avancados por categoria, faixa de valor e periodo personalizado
- exportacao de dados (CSV/PDF)
- dashboard com mais indicadores financeiros
- pipeline CI para testes automatizados

## Autor

Natan Da Luz

- E-mail: <mailto:natandaluz01@gmail.com>
- LinkedIn: <https://www.linkedin.com/in/natandaluzdesenvolvedor/>

## Licenca

Este projeto esta licenciado sob a licenca MIT.
