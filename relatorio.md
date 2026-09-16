# Relatório - API Doceria

## 1. Introdução

O trabalho consiste no desenvolvimento de uma API REST para uma doceria. A ideia foi criar uma API simples para cadastrar usuários, categorias e produtos.

## 2. Objetivo

O objetivo é praticar PHP no back-end, banco de dados, requisições HTTP, Git/GitHub, Insomnia e documentação com Swagger.

## 3. Tecnologias utilizadas

Foram utilizados PHP 8.3, MySQL, Laravel Herd, VS Code, Git, GitHub, Insomnia e Swagger-PHP.

## 4. Banco de dados

O banco utilizado foi o `doceria_api`.

As tabelas são:

- `usuarios`
- `categorias`
- `produtos`

A tabela `produtos` possui ligação com `usuarios` e `categorias` por meio de chaves estrangeiras.

## 5. API

A API possui rotas para cadastro e login de usuários, além de operações de cadastro, consulta, alteração e exclusão de categorias e produtos.

Também foi colocado filtro de produtos por categoria e por nome.

## 6. Testes

As requisições podem ser feitas pelo Insomnia. Foram separadas requisições para usuários, categorias e produtos.

## 7. Swagger

Foi utilizado o Swagger-PHP para gerar o arquivo `openapi.json` com a documentação das rotas da API.

## 8. Git e GitHub

O projeto pode ser versionado com Git e enviado para um repositório no GitHub para a entrega.

## 9. Dificuldades

As principais dificuldades foram entender as rotas da API, conectar o PHP ao MySQL e testar as requisições pelo Insomnia.

## 10. Conclusão

O projeto ajudou a entender melhor como funciona uma API REST usando PHP, banco de dados e ferramentas de teste e documentação.
