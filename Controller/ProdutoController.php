<?php

namespace Controller;

use Model\Produto;
use Helper\Response;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Produtos")]
class ProdutoController
{
    private $model;

    public function __construct()
    {
        $this->model = new Produto();
    }

    #[OA\Get(
        path: "/api/produtos",
        tags: ["Produtos"],
        summary: "Listar produtos",
        parameters: [
            new OA\Parameter(
                name: "categoria",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "integer")
            ),
            new OA\Parameter(
                name: "busca",
                in: "query",
                required: false,
                schema: new OA\Schema(type: "string")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de produtos"
            )
        ]
    )]
    public function listar(): void
    {
        $categoria = isset($_GET['categoria']) ? (int) $_GET['categoria'] : null;
        $busca = $_GET['busca'] ?? null;

        Response::json($this->model->listar($categoria, $busca));
    }

    #[OA\Get(
        path: "/api/produtos/{id}",
        tags: ["Produtos"],
        summary: "Buscar produto",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Produto encontrado"
            ),
            new OA\Response(
                response: 404,
                description: "Produto não encontrado"
            )
        ]
    )]
    public function buscar(int $id): void
    {
        $produto = $this->model->buscar($id);

        if (!$produto) {
            Response::json(['erro' => 'Produto não encontrado.'], 404);
        }

        Response::json($produto);
    }

    #[OA\Post(
        path: "/api/produtos",
        tags: ["Produtos"],
        summary: "Criar produto",
        responses: [
            new OA\Response(
                response: 201,
                description: "Produto criado"
            ),
            new OA\Response(
                response: 400,
                description: "Dados inválidos"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function criar(int $usuarioId): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];

        $this->validar($dados);

        $id = $this->model->criar($dados, $usuarioId);

        Response::json([
            'mensagem' => 'Produto criado.',
            'id' => $id
        ], 201);
    }

    #[OA\Put(
        path: "/api/produtos/{id}",
        tags: ["Produtos"],
        summary: "Atualizar produto",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Produto atualizado"
            ),
            new OA\Response(
                response: 404,
                description: "Produto não encontrado"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function atualizar(int $id): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];

        $this->validar($dados);

        if (!$this->model->buscar($id)) {
            Response::json(['erro' => 'Produto não encontrado.'], 404);
        }

        $this->model->atualizar($id, $dados);

        Response::json(['mensagem' => 'Produto atualizado.']);
    }

    #[OA\Delete(
        path: "/api/produtos/{id}",
        tags: ["Produtos"],
        summary: "Excluir produto",
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(
                response: 200,
                description: "Produto excluído"
            ),
            new OA\Response(
                response: 404,
                description: "Produto não encontrado"
            ),
            new OA\Response(
                response: 401,
                description: "Não autenticado"
            )
        ]
    )]
    public function excluir(int $id): void
    {
        if (!$this->model->buscar($id)) {
            Response::json(['erro' => 'Produto não encontrado.'], 404);
        }

        $this->model->excluir($id);

        Response::json(['mensagem' => 'Produto excluído.']);
    }

    private function validar(array $dados): void
    {
        if (
            empty($dados['nome']) ||
            !isset($dados['categoria_id']) ||
            !isset($dados['preco'])
        ) {
            Response::json([
                'erro' => 'Informe nome, categoria_id e preco.'
            ], 400);
        }

        if (!is_numeric($dados['preco']) || $dados['preco'] < 0) {
            Response::json([
                'erro' => 'Preço inválido.'
            ], 400);
        }

        if (
            isset($dados['quantidade_estoque']) &&
            $dados['quantidade_estoque'] < 0
        ) {
            Response::json([
                'erro' => 'Quantidade de estoque inválida.'
            ], 400);
        }
    }
}