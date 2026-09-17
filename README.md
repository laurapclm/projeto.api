# API da Doceria

Projeto de uma API REST para uma doceria, desenvolvido em PHP como atividade do SENAI.

## Objetivo

O objetivo do projeto é criar uma API para controlar usuários, categorias e produtos de uma doceria.

## Tecnologias utilizadas

- PHP 8.3
- MySQL
- Laravel Herd
- Visual Studio Code
- Composer
- Swagger-PHP
- Insomnia
- Git e GitHub

## Funcionalidades

### Usuários

- Cadastro de usuário
- Login
- Logout
- Autenticação por token

### Categorias

- Listar categorias
- Buscar categoria
- Criar categoria
- Atualizar categoria
- Excluir categoria

### Produtos

- Listar produtos
- Buscar produto
- Criar produto
- Atualizar produto
- Excluir produto
- Buscar por categoria
- Buscar por nome
- Controle de estoque

Para criar, atualizar ou excluir produtos é necessário estar logado.

## Rotas

### Usuários

```text
POST /api/usuarios/registrar
POST /api/usuarios/login
POST /api/usuarios/logout
```

### Categorias

```text
GET    /api/categorias
GET    /api/categorias/{id}
POST   /api/categorias
PUT    /api/categorias/{id}
DELETE /api/categorias/{id}
```

### Produtos

```text
GET    /api/produtos
GET    /api/produtos/{id}
POST   /api/produtos
PUT    /api/produtos/{id}
DELETE /api/produtos/{id}
```

Também podem ser usados filtros:

```text
/api/produtos?categoria=1
/api/produtos?busca=chocolate
```

## Autenticação

Depois de fazer login, a API retorna um token.

Para acessar as rotas protegidas, o token deve ser enviado no cabeçalho:

```text
Authorization: Bearer SEU_TOKEN
```

Se não estiver logado, a API retorna o erro `401`.

## Banco de dados

O projeto utiliza MySQL.

Banco utilizado:

```text
doceria_db
```

O arquivo `banco.sql` possui as tabelas e os dados utilizados no projeto.

## Swagger

Foi utilizado o Swagger-PHP para gerar a documentação da API.

Para gerar a documentação:

```bash
php gerar-docs.php
```

O comando gera o arquivo:

```text
openapi.json
```

## Como executar

1. Clonar o projeto.
2. Abrir a pasta no VS Code.
3. Colocar o projeto no Laravel Herd.
4. Criar o banco `doceria_db` no MySQL.
5. Executar o arquivo `banco.sql`.
6. Instalar as dependências:

```bash
composer install
```

7. Gerar a documentação:

```bash
php gerar-docs.php
```

8. Abrir o projeto pelo Laravel Herd.
9. Fazer os testes das rotas usando o Insomnia.

## Testes realizados

Foram realizados testes nas principais funções da API, como:

- Cadastro de usuário
- Login
- Autenticação por token
- Cadastro de categorias
- Alteração de categorias
- Exclusão de categorias
- Cadastro de produtos
- Alteração de produtos
- Exclusão de produtos
- Busca de produtos
- Filtro de produtos
- Acesso a rota protegida sem autenticação

## GitHub

Repositório do projeto:

https://github.com/laurapclm/projeto.api.git