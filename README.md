## Meu Saldo Certo Projeto Financeiro

Meu Saldo Certo, é uma aplicação financeira desenvolvida em Laravel para controle de receitas, despesas e saldo. O projeto foi construído com foco em clareza visual, organização de código e apresentação profissional, simulando a experiência de um produto real para portfólio.

![Laravel](https://img.shields.io/badge/Laravel-12%2B-red)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)
![Tailwind](https://img.shields.io/badge/Tailwind%20CSS-3%2B-38BDF8)

## Visão Geral do Projeto

O sistema vai permitir que você registre, consulte e analise movimentações financeiras por usuário autenticado. A interface foi desenhada para priorizar leitura rápida de dados, previsibilidade de uso e uma apresentação consistente para recrutadores e portfólio.

## Objetivo do Projeto

Este projeto foi desenvolvido com foco em criar um sistema financeiro Real para o dia a dia, aplicando boas práticas de desenvolvimento com Laravel, organização de código e atenção à experiência do usuário. O objetivo principal é demonstrar capacidade de construir uma aplicação completa, desde a modelagem de dados até a interface final com deploy

## Diferencial do Projeto

- Dashboard com agregação dinâmica de dados financeiros.
- Filtro por período com atualização clara da interface.
- Implementação de multi-tenant simples com isolamento por usuário.
- Uso de Form Requests e Policies para validação e autorização.
- Interface pensada como produto real, com UX limpa e responsiva.
- Estrutura organizada seguindo boas práticas do Laravel.

## Principais Funcionalidades

- Sistema completo de autenticação com login, registro e recuperação de senha.
- Dashboard financeiro com totais consolidados e gráfico analítico.
- Filtro por período para acompanhar o comportamento das finanças.
- Cadastro, edição, listagem e exclusão de transações.
- Classificação das movimentações em receitas e despesas.
- Associação de categorias por usuário autenticado.
- Validação de dados e autorização por políticas.
- Seed inicial para facilitar a execução e validação do sistema em ambiente local.

## Regras de Negócio

- Toda transação deve estar vinculada a uma categoria.
- Categorias pertencem ao usuário autenticado.
- Uma transação deve ser do tipo receita ou despesa.
- O tipo da categoria precisa ser compatível com o tipo da transação.
- Cada usuário visualiza apenas os próprios dados.

## Arquitetura

O projeto segue o padrão MVC do Laravel com separação clara de responsabilidades:

- Controllers: orquestram o fluxo entre validação, modelos e views.
- Form Requests: Centralizam regras de validação e mantêm os controllers enxutos.
- Policies: Controlam autorização por usuário.
- Models: Concentram relacionamentos e parte das regras de domínio.
- Views com Blade: Entregam a camada de apresentação com Tailwind CSS.

Essa estrutura facilita manutenção, evolução e leitura do código em cenários reais de produto.

## Stack Utilizada no projeto

- Laravel 12
- PHP 8.2+
- Blade
- TailwindCSS
- Alpine.js
- Chart.js
- Vite
- SQLite
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
bootstrap/
config/
database/
  migrations/
  seeders/
public/
resources/
  css/
  js/
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
git clone https://github.com/NatanLuz/meu-saldo-certo.git)

cd SaldoPro

composer install

npm install

cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

O seeder vai criar um usuário de teste e dados iniciais para facilitar a validação local do sistema.

### Rodando o projeto 

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

## Pasta Screenshots

A pasta `screenshots` foi incluída no projeto para documentar visualmente as principais telas e reforçar a apresentação do sistema. Os arquivos foram padronizados para nomes sem acentos e em minúsculas visando compatibilidade entre sistemas de arquivos.

## Screenshots do Projeto

### Login

Tela de autenticação de usuário para entrar na aplicação

![Login](./screenshots/login.png)

### Dashboard

Resumo financeiro com gráfico e filtro por período.

![Dashboard](./screenshots/dashboard.png)

### Transações

Lista de movimentações com ações de cadastro, edição e exclusão.

![Transações](./screenshots/tela-transacoes.png)

### Nova Transação

Formulário para registrar uma nova movimentação financeira.

![Nova Transação](./screenshots/nova-transacao.png)

## Banco de Dados

Entidades principais:

- `users`
- `categories`
- `transactions`

Relacionamentos:

- User 1:N Transactions
- User 1:N Categories
- Category 1:N Transactions

## Autor

Natan Da Luz

- E-mail: <natandaluz01@gmail.com>
- LinkedIn: <https://www.linkedin.com/in/natandaluzdesenvolvedor/>

## Licença

Projeto é licenciado sob a licença MIT.
