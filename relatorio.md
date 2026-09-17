# Relatório - API da Doceria

## 1. Introdução

O projeto consiste em uma API REST para uma doceria. A API foi feita em PHP e utiliza MySQL para guardar os dados.

A ideia foi criar uma API que pudesse trabalhar com usuários, categorias e produtos, fazendo operações de cadastro, consulta, alteração e exclusão.

## 2. Objetivo

O objetivo do projeto foi colocar em prática os conteúdos de PHP, banco de dados e API REST.

Também foram utilizados conceitos de login, autenticação por token, requisições HTTP e organização do código.

## 3. Tecnologias utilizadas

- PHP 8.3
- MySQL
- Laravel Herd
- Visual Studio Code
- Composer
- Swagger-PHP
- Insomnia
- Git
- GitHub

## 4. Como o projeto foi organizado

O projeto foi separado em algumas pastas para facilitar a organização.

A pasta `Controller` possui os arquivos responsáveis pelas ações da API.

A pasta `Model` possui os arquivos que fazem as operações no banco de dados.

A pasta `Helper` possui funções auxiliares.

A pasta `Config` possui a configuração da conexão com o banco.

Também existem arquivos como `index.php`, `banco.sql`, `insomnia.json` e `gerar-docs.php`.

## 5. Requisitos funcionais

### RF01 - Cadastro de usuário

Permitir o cadastro de usuários através da API.

### RF02 - Login

Permitir que o usuário faça login usando e-mail e senha.

### RF03 - Autenticação

Gerar um token depois que o login for realizado para permitir o acesso às rotas protegidas.

### RF04 - Categorias

Permitir listar, consultar, cadastrar, atualizar e excluir categorias.

### RF05 - Produtos

Permitir listar, consultar, cadastrar, atualizar e excluir produtos.

### RF06 - Busca de produtos

Permitir buscar produtos pelo nome.

### RF07 - Filtro de produtos

Permitir filtrar os produtos por categoria.

### RF08 - Estoque

Guardar a quantidade de cada produto disponível no estoque.

### RF09 - Validação

Verificar se os dados enviados nas requisições estão corretos.

### RF10 - Acesso protegido

Exigir login para criar, alterar ou excluir produtos.

## 6. Requisitos não funcionais

### RNF01

O projeto utiliza PHP 8.3.

### RNF02

O banco de dados utilizado é o MySQL.

### RNF03

As respostas da API são enviadas em formato JSON.

### RNF04

O projeto possui uma organização dividida em Controllers, Models, Helpers e Config.

### RNF05

O projeto utiliza Git e GitHub para guardar e controlar as versões do código.

### RNF06

A API utiliza os métodos HTTP para realizar suas operações.

## 7. Rotas da API

### Usuários

```text
POST /api/usuarios/registrar
POST /api/usuarios/login
POST /api/usuarios/logout
```

### Categorias

```text
GET /api/categorias
GET /api/categorias/{id}
POST /api/categorias
PUT /api/categorias/{id}
DELETE /api/categorias/{id}
```

### Produtos

```text
GET /api/produtos
GET /api/produtos/{id}
GET /api/produtos?categoria=1
GET /api/produtos?busca=bolo
POST /api/produtos
PUT /api/produtos/{id}
PATCH /api/produtos/{id}
DELETE /api/produtos/{id}
```

## 8. Autenticação

O usuário primeiro precisa fazer login.

Quando o login dá certo, a API retorna um token.

Esse token é utilizado nas operações protegidas através do cabeçalho:

```text
Authorization: Bearer SEU_TOKEN
```

Sem o token, não é possível realizar as operações protegidas de produtos.

## 9. Banco de dados

O banco utilizado no projeto é o MySQL.

O nome do banco é:

```text
doceria_db
```

O arquivo `banco.sql` possui a estrutura do banco e os dados usados durante os testes.

## 10. Testes

Os testes foram realizados principalmente utilizando o Insomnia.

Foram testadas as rotas de usuários, categorias e produtos.

Também foram feitos testes de login, utilização do token, cadastro, alteração, exclusão, busca e filtro de produtos.

Foi testado também o acesso às operações protegidas sem fazer login.

## 11. Swagger

Foi utilizado o Swagger-PHP para gerar a documentação da API.

O arquivo `gerar-docs.php` é usado para gerar o arquivo `openapi.json`.

O comando utilizado é:

```bash
php gerar-docs.php
```

## 12. Git e GitHub

O Git foi utilizado durante o desenvolvimento para salvar as alterações do projeto.

O GitHub foi utilizado para armazenar o código e manter o projeto versionado.

## 13. Conclusão

O projeto ajudou a colocar em prática os conteúdos de PHP, MySQL e API REST.

Foi possível criar as principais funções de uma API para uma doceria, além de trabalhar com login, autenticação, banco de dados e testes de requisições.
