<?php

namespace Model;

use Config\Database;

class Produto
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function listar(?int $categoriaId = null, ?string $busca = null): array
    {
        $sql = 'SELECT p.*, c.nome AS categoria FROM produtos p INNER JOIN categorias c ON c.id = p.categoria_id';
        $where = [];
        $params = [];

        if ($categoriaId !== null) {
            $where[] = 'p.categoria_id = ?';
            $params[] = $categoriaId;
        }

        if ($busca !== null && $busca !== '') {
            $where[] = 'p.nome LIKE ?';
            $params[] = '%' . $busca . '%';
        }

        if ($where) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $sql .= ' ORDER BY p.id';
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function buscar(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, c.nome AS categoria FROM produtos p INNER JOIN categorias c ON c.id = p.categoria_id WHERE p.id = ?'
        );
        $stmt->execute([$id]);
        $produto = $stmt->fetch();
        return $produto ?: null;
    }

    public function criar(array $dados, int $usuarioId): int
    {
        $sql = 'INSERT INTO produtos (nome, descricao, categoria_id, preco, quantidade_estoque, usuario_id) VALUES (?, ?, ?, ?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            $dados['nome'],
            $dados['descricao'] ?? null,
            $dados['categoria_id'],
            $dados['preco'],
            $dados['quantidade_estoque'] ?? 0,
            $usuarioId
        ]);
        return (int) $this->db->lastInsertId();
    }

    public function atualizar(int $id, array $dados): bool
    {
        $sql = 'UPDATE produtos SET nome = ?, descricao = ?, categoria_id = ?, preco = ?, quantidade_estoque = ? WHERE id = ?';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $dados['nome'],
            $dados['descricao'] ?? null,
            $dados['categoria_id'],
            $dados['preco'],
            $dados['quantidade_estoque'] ?? 0,
            $id
        ]);
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM produtos WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
