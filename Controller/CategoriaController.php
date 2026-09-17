<?php

namespace Controller;

use Model\Categoria;
use Helper\Response;
use OpenApi\Attributes as OA;

#[OA\Tag(name: "Categorias")]
class CategoriaController
{
    private $model;

    public function __construct()
    {
        $this->model = new Categoria();
    }

    #[OA\Get(
        path: "/api/categorias",
        tags: ["Categorias"],
        summary: "Listar categorias",
        responses: [
            new OA\Response(
                response: 200,
                description: "Lista de categorias"
            )
        ]
    )]
    public function listar(): void
    {
        Response::json($this->model->listar());
    }

    #[OA\Get(
        path: "/api/categorias/{id}",
        tags: ["Categorias"],
        summary: "Buscar categoria",
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
                description: "Categoria encontrada"
            ),
            new OA\Response(
                response: 404,
                description: "Categoria não encontrada"
            )
        ]
    )]
    public function buscar(int $id): void
    {
        $categoria = $this->model->buscar($id);

        if (!$categoria) {
            Response::json(['erro' => 'Categoria não encontrada.'], 404);
        }

        Response::json($categoria);
    }

    #[OA\Post(
        path: "/api/categorias",
        tags: ["Categorias"],
        summary: "Criar categoria",
        responses: [
            new OA\Response(
                response: 201,
                description: "Categoria criada"
            ),
            new OA\Response(
                response: 400,
                description: "Nome não informado"
            )
        ]
    )]
    public function criar(): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];

        if (empty($dados['nome'])) {
            Response::json(['erro' => 'Informe o nome.'], 400);
        }

        $id = $this->model->criar($dados['nome']);

        Response::json([
            'mensagem' => 'Categoria criada.',
            'id' => $id
        ], 201);
    }

    #[OA\Put(
        path: "/api/categorias/{id}",
        tags: ["Categorias"],
        summary: "Atualizar categoria",
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
                description: "Categoria atualizada"
            ),
            new OA\Response(
                response: 404,
                description: "Categoria não encontrada"
            )
        ]
    )]
    public function atualizar(int $id): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];

        if (empty($dados['nome'])) {
            Response::json(['erro' => 'Informe o nome.'], 400);
        }

        if (!$this->model->buscar($id)) {
            Response::json(['erro' => 'Categoria não encontrada.'], 404);
        }

        $this->model->atualizar($id, $dados['nome']);

        Response::json(['mensagem' => 'Categoria atualizada.']);
    }

    #[OA\Delete(
        path: "/api/categorias/{id}",
        tags: ["Categorias"],
        summary: "Excluir categoria",
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
                description: "Categoria excluída"
            ),
            new OA\Response(
                response: 404,
                description: "Categoria não encontrada"
            )
        ]
    )]
    public function excluir(int $id): void
    {
        if (!$this->model->buscar($id)) {
            Response::json(['erro' => 'Categoria não encontrada.'], 404);
        }

        $this->model->excluir($id);

        Response::json(['mensagem' => 'Categoria excluída.']);
    }
}