# Meu Saldo Certo 

<p align="center">
  Sistema Financeiro para gerenciamento de receitas, despesas, categorias e saldo por usuário autenticado, simples prático e rápido !
</p>

<p align="center">
  <img alt="Laravel 12" src="https://img.shields.io/badge/Laravel-12-FF2D20?style=for-the-badge&logo=laravel&logoColor=white">
  <img alt="PHP 8.2+" src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?style=for-the-badge&logo=php&logoColor=white">
  <img alt="Tailwind CSS" src="https://img.shields.io/badge/Tailwind_CSS-3-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white">
  <img alt="SQLite" src="https://img.shields.io/badge/SQLite-Database-003B57?style=for-the-badge&logo=sqlite&logoColor=white">
  <img alt="Railway" src="https://img.shields.io/badge/Deploy-Railway-0B0D0E?style=for-the-badge&logo=railway&logoColor=white">
</p>

<p align="center">
  <a href="https://meu-saldo-certo-production.up.railway.app">
    <img alt="Aplicação online" src="https://img.shields.io/badge/Acessar_aplicação-Online-16A34A?style=for-the-badge&logo=railway&logoColor=white">
  </a>

---

## Sobre o projeto

O **Meu Saldo Certo** é uma Aplicação Web desenvolvida em Laravel para organizar a vida financeira pessoal. O sistema permite registrar movimentações, acompanhar receitas e despesas, consultar o saldo consolidado e analisar os dados por meio de filtros e gráficos.

O projeto nasceu de uma necessidade real. Durante um período de reorganização financeira familiar, tornou-se necessário acompanhar entradas, saídas e saldo de forma simples e prática. Em vez de utilizar uma solução pronta, optei por desenvolver uma aplicação própria e transformar esse desafio em uma oportunidade de aprofundar meus conhecimentos em Laravel.

Os principais objetivos foram:

- Resolver um problema real com software.

- Construir um sistema funcional e utilizável.

## Problema que resolve

O controle financeiro pode se tornar confuso quando receitas e despesas ficam distribuídas entre anotações, planilhas e diferentes aplicativos. O Meu Saldo Certo centraliza essas informações em uma interface única, permitindo:

- Visualizar rapidamente a situação financeira.

- Registrar e classificar movimentações.

- Consultar o histórico por período.

- Identificar receitas, despesas e saldo consolidado.

- Manter os dados separados por usuário autenticado.

## Funcionalidades

- Cadastro de usuários.
- Login, logout e recuperação de senha.
- Dashboard financeiro.
- Registro de receitas e despesas.
- Organização das movimentações por categorias.
- Saldo consolidado.
- Gráfico financeiro.
- Filtros por período.
- Cadastro, listagem, edição e exclusão de transações.
- Perfil do usuário.
- Interface responsiva.
- Tema claro e Dark Mode com preferência persistida no navegador.
- Isolamento de dados por usuário.

## Objetivo do Projeto 🎯

O objetivo deste projeto é demonstrar a construção de uma aplicação financeira completa com Laravel, desde a modelagem do domínio até a entrega final em produção. A proposta é evidenciar domínio de boas práticas, organização de arquitetura, responsividade, clareza de interface e preparo para deploy.

Além da parte funcional, o projeto foi desenhado como peça de portfólio para recrutadores, com foco em apresentação profissional, narrativa de produto e consistência visual.

## Diferenciais 🚀

- Dashboard com consolidação dinâmica de dados financeiros.
- Gráfico analítico para leitura rápida da evolução financeira.
- Filtro por período para análise das movimentações.
- CRUD completo de transações com fluxo organizado.
- Categorias vinculadas a cada usuário autenticado.
- Implementação de multi-tenant simples com isolamento por usuário.
- Validação centralizada com Form Requests.
- Policies para impedir acesso indevido a transações de outros usuários.
- Consultas financeiras iniciadas a partir do usuário autenticado.
- Escape automático de conteúdo nas views Blade.
- `APP_DEBUG=false` na configuração de produção.
- Cookies de sessão seguros no ambiente de produção.

## Testes e qualidade

O projeto possui testes de autenticação, perfil, dashboard, validações, transações e autorização entre usuários,tudo completo e conferido.

Resultados verificados:

| Verificação | Resultado |
| --- | --- |
| `php artisan test` | 34 testes aprovados |
| Assertions | 104 aprovadas |
| `composer audit --locked` | 0 vulnerabilidades |
| `npm audit --omit=dev` | 0 vulnerabilidades |
| `npm run build` | Build concluído com sucesso |

Para executar as verificações:

```bash
php artisan test
composer audit --locked
npm audit --omit=dev
npm run build
```

## Instalação local

### Pré-requisitos

- PHP 8.2 ou superior.

- Composer.

- Node.js e npm.

- Extensão PDO SQLite habilitada no PHP.

### 1. Clone o repositório

```bash
git clone https://github.com/NatanLuz/meu-saldo-certo.git
cd meu-saldo-certo
```

### 2. Instale as dependências

```bash
composer install
npm install
```

### 3. Configure o ambiente

Linux ou macOS:

```bash
cp .env.example .env
```

Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

Gere a chave da aplicação:

```bash
php artisan key:generate
```

Para executar localmente com SQLite, ajuste as seguintes variáveis no `.env`:

```env
APP_ENV=local
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000

DB_CONNECTION=sqlite

SESSION_DRIVER=file
SESSION_SECURE_COOKIE=false
CACHE_STORE=file
QUEUE_CONNECTION=sync
LOG_LEVEL=debug
```

Remova ou comente as variáveis de conexão MySQL do arquivo local.

### 4. Prepare o banco de dados

Linux ou macOS:

```bash
touch database/database.sqlite
```

Windows PowerShell:

```powershell
New-Item database/database.sqlite -ItemType File -Force
```

Execute as migrations:

```bash
php artisan migrate
```

O cadastro de usuário pode ser realizado pela própria aplicação. O seeder disponível adiciona categorias iniciais aos usuários que já existirem:

```bash
php artisan db:seed
```

### 5. Execute a aplicação

Em um terminal:

```bash
php artisan serve
```

Em outro terminal:

```bash
npm run dev
```

Acesse:

```text
http://127.0.0.1:8000
```

## Deploy

A aplicação está hospedada no **Railway** e disponível publicamente:

### [Acessar Meu Saldo Certo](https://meu-saldo-certo-production.up.railway.app)

No ambiente de produção, dados sensíveis e configurações de infraestrutura são fornecidos por variáveis de ambiente. A configuração utiliza modo de produção, debug desabilitado e cookies seguros.

## Screenshots

## Login

![Tela de login](./screenshots/login.png)

## Dashboard

![Dashboard financeiro](./screenshots/dashboard.png)

## Nova transação

![Formulário de nova transação](./screenshots/nova-transacao.png)

## Aprendizados

O desenvolvimento do projeto proporcionou experiência prática em:

- Estruturação de uma aplicação Laravel completa.
- Modelagem de usuários, categorias e transações.
- Autenticação e gerenciamento de sessão.
- Validação com Form Requests.
- Autorização e prevenção de IDOR com Policies.
- Isolamento de dados por usuário.
- Construção de dashboards e gráficos financeiros.
- Testes de integração e regras de autorização.
- Criação de interfaces responsivas com tema claro e escuro.
- Configuração de ambiente local e deploy em produção.
- Auditoria de dependências.

## Autor

**Natan Da Luz**

- [LinkedIn](https://www.linkedin.com/in/natandaluzdesenvolvedor/)

- [E-mail](mailto:natandaluz01@gmail.com)

## Licença

Este projeto está licenciado sob a licença MIT.
