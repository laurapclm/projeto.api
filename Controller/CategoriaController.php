<?php

namespace Controller;

use Model\Categoria;
use Helper\Response;

/** @OA\Tag(name="Categorias") */
class CategoriaController
{
    private $model;

    public function __construct()
    {
        $this->model = new Categoria();
    }

    /** @OA\Get(path="/api/categorias", tags={"Categorias"}, summary="Listar categorias", @OA\Response(response=200, description="Lista de categorias")) */
    public function listar(): void
    {
        Response::json($this->model->listar());
    }

    /** @OA\Get(path="/api/categorias/{id}", tags={"Categorias"}, summary="Buscar categoria", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Categoria encontrada"), @OA\Response(response=404, description="Não encontrada")) */
    public function buscar(int $id): void
    {
        $categoria = $this->model->buscar($id);
        if (!$categoria) Response::json(['erro' => 'Categoria não encontrada.'], 404);
        Response::json($categoria);
    }

    public function criar(): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];
        if (empty($dados['nome'])) Response::json(['erro' => 'Informe o nome.'], 400);
        $id = $this->model->criar($dados['nome']);
        Response::json(['mensagem' => 'Categoria criada.', 'id' => $id], 201);
    }

    public function atualizar(int $id): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];
        if (empty($dados['nome'])) Response::json(['erro' => 'Informe o nome.'], 400);
        if (!$this->model->buscar($id)) Response::json(['erro' => 'Categoria não encontrada.'], 404);
        $this->model->atualizar($id, $dados['nome']);
        Response::json(['mensagem' => 'Categoria atualizada.']);
    }

    public function excluir(int $id): void
    {
        if (!$this->model->buscar($id)) Response::json(['erro' => 'Categoria não encontrada.'], 404);
        $this->model->excluir($id);
        Response::json(['mensagem' => 'Categoria excluída.']);
    }
}
