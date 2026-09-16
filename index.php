<?php

require_once __DIR__ . '/autoload.php';

use Controller\UsuarioController;
use Controller\CategoriaController;
use Controller\ProdutoController;
use Helper\Response;

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(204);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$parts = array_values(array_filter(explode('/', trim($path, '/'))));

if (($parts[0] ?? '') !== 'api') {
    Response::json(['mensagem' => 'API Doceria funcionando.']);
}

$recurso = $parts[1] ?? '';
$id = isset($parts[2]) ? (int) $parts[2] : null;
$acao = $parts[2] ?? null;

try {
    if ($recurso === 'usuarios') {
        $controller = new UsuarioController();

        if ($acao === 'registrar' && $method === 'POST') $controller->registrar();
        if ($acao === 'login' && $method === 'POST') $controller->login();
        if ($acao === 'logout' && $method === 'POST') $controller->logout();
    }

    if ($recurso === 'categorias') {
        $controller = new CategoriaController();
        if ($method === 'GET' && $id === null) $controller->listar();
        if ($method === 'GET' && $id !== null) $controller->buscar($id);
        if ($method === 'POST' && $id === null) $controller->criar();
        if (($method === 'PUT' || $method === 'PATCH') && $id !== null) $controller->atualizar($id);
        if ($method === 'DELETE' && $id !== null) $controller->excluir($id);
    }

    if ($recurso === 'produtos') {
        $controller = new ProdutoController();
        $usuarioController = new UsuarioController();
        $usuario = $usuarioController->usuarioDoToken();

        if ($method === 'GET' && $id === null) $controller->listar();
        if ($method === 'GET' && $id !== null) $controller->buscar($id);

        if (($method === 'POST' || $method === 'PUT' || $method === 'PATCH' || $method === 'DELETE') && !$usuario) {
            Response::json(['erro' => 'É necessário fazer login.'], 401);
        }

        if ($method === 'POST' && $id === null) $controller->criar($usuario['id']);
        if (($method === 'PUT' || $method === 'PATCH') && $id !== null) $controller->atualizar($id);
        if ($method === 'DELETE' && $id !== null) $controller->excluir($id);
    }

    Response::json(['erro' => 'Rota não encontrada.'], 404);
} catch (Throwable $e) {
    Response::json(['erro' => 'Erro interno na API.'], 500);
}
