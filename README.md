# Meu Saldo Certo

Meu Saldo Certo é uma aplicação financeira desenvolvida em Laravel para controle de receitas, despesas e saldo. O projeto foi construído com foco em clareza visual, organização de código e apresentação profissional, simulando a experiência de um produto real para portfólio.

## Demo

Em breve.

![Laravel](https://img.shields.io/badge/Laravel-12%2B-red)
![PHP](https://img.shields.io/badge/PHP-8.2%2B-blue)
![Tailwind](https://img.shields.io/badge/Tailwind%20CSS-3%2B-38BDF8)
![Status](https://img.shields.io/badge/status-MVP%20Avançado-green)
![License](https://img.shields.io/badge/license-MIT-lightgrey)

## Visão Geral

O sistema permite registrar, consultar e analisar movimentações financeiras por usuário autenticado. A interface foi desenhada para priorizar leitura rápida de dados, previsibilidade de uso e uma apresentação consistente para recrutadores e portfólio.

## Objetivo do Projeto

Este projeto foi desenvolvido com foco em simular um sistema financeiro real, aplicando boas práticas de desenvolvimento com Laravel, organização de código e atenção à experiência do usuário. O objetivo principal é demonstrar capacidade de construir uma aplicação completa, desde a modelagem de dados até a interface final.

## Diferenciais do Projeto

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
- Form Requests: centralizam regras de validação e mantêm os controllers enxutos.
- Policies: controlam autorização por usuário.
- Models: concentram relacionamentos e parte das regras de domínio.
- Views com Blade: entregam a camada de apresentação com Tailwind CSS.

Essa estrutura facilita manutenção, evolução e leitura do código em cenários reais de produto.

## Stack Utilizada

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
git clone <url-do-repositorio>
cd SaldoPro

composer install
npm install

cp .env.example .env
php artisan key:generate
php artisan migrate --seed
```

O seeder cria um usuário de teste e dados iniciais para facilitar a validação local do sistema.

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

## Screenshots

A pasta `Screenshots` foi incluída no projeto para documentar visualmente as principais telas e reforçar a apresentação do sistema.

### Login

Tela de autenticação de usuário.

![Login](../Screenshots/Login.PNG)

### Dashboard

Resumo financeiro com gráfico e filtro por período.

![Dashboard](../Screenshots/Dashboard.PNG)

### Transações

Lista de movimentações com ações de cadastro, edição e exclusão.

![Transações](../Screenshots/TeladeTransações.PNG)

### Nova Transação

Formulário para registrar uma nova movimentação financeira.

![Nova Transação](../Screenshots/NovaTransação.PNG)

## Banco de Dados

Entidades principais:

- `users`
- `categories`
- `transactions`

Relacionamentos:

- User 1:N Transactions
- User 1:N Categories
- Category 1:N Transactions

## Melhorias Futuras

- Exportação de relatório em PDF.
- Sistema de insights financeiros.
- Filtros mais avançados por categoria e faixa de valor.
- Deploy em ambiente de produção.
- Painel com métricas adicionais e comparativos mensais.

## Autor

Natan Da Luz

- E-mail: <natandaluz01@gmail.com>

- LinkedIn: <https://www.linkedin.com/in/natandaluzdesenvolvedor/>

## Licença

Projeto licenciado sob a licença MIT.
