<?php

namespace Config;

use PDO;
use PDOException;

class Database
{
    public static function connect(): PDO
    {
        try {
            $pdo = new PDO(
                'mysql:host=127.0.0.1;dbname=doceria_api;charset=utf8mb4',
                'root',
                ''
            );

            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            return $pdo;
        } catch (PDOException $e) {
            http_response_code(500);
            die(json_encode(['erro' => 'Não foi possível conectar ao banco de dados.']));
        }
    }
}
