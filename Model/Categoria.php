<?php

namespace Model;

use Config\Database;

class Categoria
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function listar(): array
    {
        return $this->db->query('SELECT * FROM categorias ORDER BY id')->fetchAll();
    }

    public function buscar(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM categorias WHERE id = ?');
        $stmt->execute([$id]);
        $categoria = $stmt->fetch();
        return $categoria ?: null;
    }

    public function criar(string $nome): int
    {
        $stmt = $this->db->prepare('INSERT INTO categorias (nome) VALUES (?)');
        $stmt->execute([$nome]);
        return (int) $this->db->lastInsertId();
    }

    public function atualizar(int $id, string $nome): bool
    {
        $stmt = $this->db->prepare('UPDATE categorias SET nome = ? WHERE id = ?');
        return $stmt->execute([$nome, $id]);
    }

    public function excluir(int $id): bool
    {
        $stmt = $this->db->prepare('DELETE FROM categorias WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
