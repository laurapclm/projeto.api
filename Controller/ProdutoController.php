<?php

namespace Controller;

use Model\Produto;
use Helper\Response;

/** @OA\Tag(name="Produtos") */
class ProdutoController
{
    private $model;

    public function __construct()
    {
        $this->model = new Produto();
    }

    /** @OA\Get(path="/api/produtos", tags={"Produtos"}, summary="Listar produtos", @OA\Parameter(name="categoria", in="query", required=false, @OA\Schema(type="integer")), @OA\Parameter(name="busca", in="query", required=false, @OA\Schema(type="string")), @OA\Response(response=200, description="Lista de produtos")) */
    public function listar(): void
    {
        $categoria = isset($_GET['categoria']) ? (int) $_GET['categoria'] : null;
        $busca = $_GET['busca'] ?? null;
        Response::json($this->model->listar($categoria, $busca));
    }

    /** @OA\Get(path="/api/produtos/{id}", tags={"Produtos"}, summary="Buscar produto", @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")), @OA\Response(response=200, description="Produto encontrado"), @OA\Response(response=404, description="Não encontrado")) */
    public function buscar(int $id): void
    {
        $produto = $this->model->buscar($id);
        if (!$produto) Response::json(['erro' => 'Produto não encontrado.'], 404);
        Response::json($produto);
    }

    public function criar(int $usuarioId): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];
        $this->validar($dados);
        $id = $this->model->criar($dados, $usuarioId);
        Response::json(['mensagem' => 'Produto criado.', 'id' => $id], 201);
    }

    public function atualizar(int $id): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];
        $this->validar($dados);
        if (!$this->model->buscar($id)) Response::json(['erro' => 'Produto não encontrado.'], 404);
        $this->model->atualizar($id, $dados);
        Response::json(['mensagem' => 'Produto atualizado.']);
    }

    public function excluir(int $id): void
    {
        if (!$this->model->buscar($id)) Response::json(['erro' => 'Produto não encontrado.'], 404);
        $this->model->excluir($id);
        Response::json(['mensagem' => 'Produto excluído.']);
    }

    private function validar(array $dados): void
    {
        if (empty($dados['nome']) || !isset($dados['categoria_id']) || !isset($dados['preco'])) {
            Response::json(['erro' => 'Informe nome, categoria_id e preco.'], 400);
        }

        if (!is_numeric($dados['preco']) || $dados['preco'] < 0) {
            Response::json(['erro' => 'Preço inválido.'], 400);
        }

        if (isset($dados['quantidade_estoque']) && $dados['quantidade_estoque'] < 0) {
            Response::json(['erro' => 'Quantidade de estoque inválida.'], 400);
        }
    }
}
