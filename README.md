# Meu Saldo Certo

Meu Saldo Certo é uma aplicação financeira em Laravel para controle de receitas, despesas e saldo, com dashboard analítico, filtros por período e CRUD de transações. O foco do projeto é entregar uma interface limpa, responsiva e com aparência de produto real.

![Laravel](https://img.shields.io/badge/Laravel-12%2B-red)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)
![Tailwind](https://img.shields.io/badge/Tailwind%20CSS-3%2B-38BDF8)
![Status](https://img.shields.io/badge/status-MVP%20Avançado-green)
![License](https://img.shields.io/badge/license-MIT-lightgrey)

## Visão Geral

O sistema permite acompanhar movimentações financeiras com autenticação, separação por usuário e visualização clara dos totais. Ele foi estruturado para demonstrar organização de código, boas práticas e uma interface refinada para portfólio.

## Diferenciais do Projeto

- Filtro por período com opção personalizada
- Dashboard com cálculo dinâmico de receitas, despesas e saldo
- Arquitetura organizada com Form Requests, Policies e separação de responsabilidades
- Interface pensada como produto real, com UX simples, clara e responsiva
- Dados isolados por usuário autenticado

## Principais Funcionalidades

- Sistema completo de autenticação (login, registro, recuperação de senha)
- Recuperação de senha por e-mail
- dashboard com totais de receitas, despesas e saldo
- gráfico financeiro com Chart.js
- filtro por período no dashboard
- cadastro, edição, listagem e exclusão de transações
- categorização das transações por usuário
- validação e autorização por usuário autenticado

## Regras de Negócio

- Toda transação deve possuir uma categoria
- Categorias são vinculadas ao usuário autenticado
- Transações podem ser do tipo receita ou despesa
- O tipo da categoria deve ser compatível com a transação
- Os dados são isolados por usuário

## Arquitetura

O projeto segue o padrão MVC do Laravel, com separação clara de responsabilidades:

- Controllers: fluxo da aplicação
- Form Requests: validação de dados
- Policies: autorização por usuário
- Models: regras de negócio e relacionamentos
- Views (Blade): interface com Tailwind CSS

Essa organização facilita manutenção, escalabilidade e legibilidade do código.

## Tecnologias Utilizadas

- Laravel 12
- PHP 8.2+
- Blade
- Tailwind CSS
- Alpine.js
- Chart.js
- Vite
- SQLite em ambiente local
- Laravel Breeze

## Estrutura do Projeto

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
public/
resources/
  views/
routes/
tests/
```

## Como Executar

### Pré-requisitos

- PHP 8.2+
- Composer
- Node.js e npm
- SQLite

### Instalação

```bash
git clone <url-do-repositorio>
cd SaldoPro

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

O seeder cria um usuário de teste e dados iniciais.

### Rodar o projeto

```bash
npm run dev
php artisan serve --host=127.0.0.1 --port=8000
```

Depois acesse:

- <http://127.0.0.1:8000>

## Testes

```bash
php artisan test
```

## Screenshots

As imagens devem ficar na pasta `screenshots` na raiz do projeto.

### Dashboard

Resumo financeiro com gráfico e filtro por período.

![Dashboard](./screenshots/dashboard.png)

### Transações

Lista de movimentações com ações de cadastro, edição e exclusão.

![Transações](./screenshots/transactions.png)

### Nova Transação

Formulário para registrar uma nova movimentação financeira.

![Nova Transação](./screenshots/new-transaction.png)

## Banco de Dados

Entidades principais:

- `users`
- `categories`
- `transactions`

Relacionamentos:

- User 1:N Transactions
- User 1:N Categories
- Category 1:N Transactions

## Melhorias Futuras (Atualizações que irei Desenvolver)

- Exportação de relatório em PDF
- Sistema de insights Financeiros
- Filtros mais avançados por categoria
- Deploy em ambiente de produção

## Autor

Natan Da Luz

- E-mail: <natandaluz01@gmail.com>
- LinkedIn: <https://www.linkedin.com/in/natandaluzdesenvolvedor/>

## Licença

Projeto licenciado sob a licença MIT.
