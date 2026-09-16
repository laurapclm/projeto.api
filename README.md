# API Doceria

Projeto de uma API REST simples para uma doceria, feito em PHP 8.3 e MySQL.

## Tecnologias

- PHP 8.3
- MySQL
- Laravel Herd
- VS Code
- Git e GitHub
- Insomnia
- Swagger / Swagger-PHP

## Como executar

1. Coloque a pasta do projeto no local usado pelo Laravel Herd.
2. Crie o banco executando o arquivo `banco.sql` no MySQL Workbench.
3. No terminal da pasta do projeto, execute:

```bash
composer install
```

4. Gere a documentação:

```bash
composer docs
```

5. Use o endereço do projeto no Herd para testar as rotas no Insomnia.

## Rotas principais

### Usuários

- `POST /api/usuarios/registrar`
- `POST /api/usuarios/login`
- `POST /api/usuarios/logout`

### Categorias

- `GET /api/categorias`
- `GET /api/categorias/{id}`
- `POST /api/categorias`
- `PUT /api/categorias/{id}`
- `DELETE /api/categorias/{id}`

### Produtos

- `GET /api/produtos`
- `GET /api/produtos/{id}`
- `GET /api/produtos?categoria=1`
- `GET /api/produtos?busca=bolo`
- `POST /api/produtos`
- `PUT /api/produtos/{id}`
- `PATCH /api/produtos/{id}`
- `DELETE /api/produtos/{id}`

As alterações de produtos precisam de um token de login.
