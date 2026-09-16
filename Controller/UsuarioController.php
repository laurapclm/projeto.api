<?php

namespace Controller;

use Model\Usuario;
use Helper\Response;

/**
 * @OA\Info(title="API Doceria", version="1.0.0", description="API REST simples para uma doceria")
 * @OA\Server(url="http://doceria-api.test")
 */
class UsuarioController
{
    private $model;

    public function __construct()
    {
        $this->model = new Usuario();
    }

    /** @OA\Post(path="/api/usuarios/registrar", tags={"Usuários"}, summary="Cadastrar usuário", @OA\RequestBody(required=true, @OA\JsonContent(required={"nome","email","senha"}, @OA\Property(property="nome", type="string"), @OA\Property(property="email", type="string"), @OA\Property(property="senha", type="string"))), @OA\Response(response=201, description="Usuário cadastrado")) */
    public function registrar(): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];

        if (empty($dados['nome']) || empty($dados['email']) || empty($dados['senha'])) {
            Response::json(['erro' => 'Preencha nome, email e senha.'], 400);
        }

        if (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)) {
            Response::json(['erro' => 'Email inválido.'], 400);
        }

        if ($this->model->buscarPorEmail($dados['email'])) {
            Response::json(['erro' => 'Email já cadastrado.'], 409);
        }

        $this->model->cadastrar($dados['nome'], $dados['email'], $dados['senha']);
        Response::json(['mensagem' => 'Usuário cadastrado com sucesso.'], 201);
    }

    /** @OA\Post(path="/api/usuarios/login", tags={"Usuários"}, summary="Fazer login", @OA\RequestBody(required=true, @OA\JsonContent(required={"email","senha"}, @OA\Property(property="email", type="string"), @OA\Property(property="senha", type="string"))), @OA\Response(response=200, description="Login realizado")) */
    public function login(): void
    {
        $dados = json_decode(file_get_contents('php://input'), true) ?? [];
        $usuario = $this->model->buscarPorEmail($dados['email'] ?? '');

        if (!$usuario || !password_verify($dados['senha'] ?? '', $usuario['senha'])) {
            Response::json(['erro' => 'Email ou senha incorretos.'], 401);
        }

        $token = base64_encode($usuario['id'] . ':' . $usuario['email']);

        Response::json([
            'mensagem' => 'Login realizado com sucesso.',
            'token' => $token,
            'usuario' => [
                'id' => $usuario['id'],
                'nome' => $usuario['nome'],
                'email' => $usuario['email']
            ]
        ]);
    }

    /** @OA\Post(path="/api/usuarios/logout", tags={"Usuários"}, summary="Sair da conta", @OA\Response(response=200, description="Logout realizado")) */
    public function logout(): void
    {
        Response::json(['mensagem' => 'Logout realizado.']);
    }

    public function usuarioDoToken(): ?array
    {
        $header = $_SERVER['HTTP_AUTHORIZATION'] ?? '';
        if (!preg_match('/Bearer\s+(.*)$/i', $header, $matches)) {
            return null;
        }

        $decoded = base64_decode(trim($matches[1]), true);
        if (!$decoded || !str_contains($decoded, ':')) {
            return null;
        }

        [$id] = explode(':', $decoded, 2);
        return $this->model->buscarPorId((int) $id);
    }
}
