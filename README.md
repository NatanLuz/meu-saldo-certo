# Meu Saldo Certo

Meu Saldo Certo é uma aplicação financeira em Laravel para controle de receitas, despesas e saldo, com dashboard analítico, filtros por período e CRUD de transações. O foco do projeto é entregar uma interface limpa, responsiva e com aparência de produto real.

![Laravel](https://img.shields.io/badge/Laravel-12%2B-red)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)
![Tailwind](https://img.shields.io/badge/Tailwind%20CSS-3%2B-38BDF8)
![Status](https://img.shields.io/badge/status-MVP%20Avançado-green)
![License](https://img.shields.io/badge/license-MIT-lightgrey)

## Visão Geral

O sistema permite acompanhar movimentações financeiras com autenticação, separação por usuário e visualização clara dos totais. Ele foi estruturado para demonstrar organização de código, boas práticas e uma interface refinada para portfólio.

## Principais Funcionalidades

- autenticação com login, cadastro e logout
- recuperação de senha por e-mail
- dashboard com totais de receitas, despesas e saldo
- gráfico financeiro com Chart.js
- filtro por período no dashboard
- cadastro, edição, listagem e exclusão de transações
- categorização das transações por usuário
- validação e autorização por usuário autenticado

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

### Rodar o projeto

```bash
php artisan serve --host=127.0.0.1 --port=8000
npm run dev
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

![Dashboard](./screenshots/dashboard.png)

### Transações

![Transações](./screenshots/transactions.png)

### Nova Transação

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

## Roadmap

- tema escuro
- filtros avançados por categoria e faixa de valor
- exportação CSV/PDF
- mais indicadores no dashboard

## Autor

Natan Da Luz

- E-mail: <natandaluz01@gmail.com>
- LinkedIn: <https://www.linkedin.com/in/natandaluzdesenvolvedor/>

## Licença

Projeto licenciado sob a licença MIT.
