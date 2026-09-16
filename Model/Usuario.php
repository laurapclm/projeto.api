<?php

namespace Model;

use Config\Database;

class Usuario
{
    private $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function cadastrar(string $nome, string $email, string $senha): bool
    {
        $sql = 'INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);
    }

    public function buscarPorEmail(string $email): ?array
    {
        $stmt = $this->db->prepare('SELECT * FROM usuarios WHERE email = ?');
        $stmt->execute([$email]);
        $usuario = $stmt->fetch();
        return $usuario ?: null;
    }

    public function buscarPorId(int $id): ?array
    {
        $stmt = $this->db->prepare('SELECT id, nome, email FROM usuarios WHERE id = ?');
        $stmt->execute([$id]);
        $usuario = $stmt->fetch();
        return $usuario ?: null;
    }
}
