CREATE DATABASE IF NOT EXISTS doceria_api
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE doceria_api;

DROP TABLE IF EXISTS produtos;
DROP TABLE IF EXISTS categorias;
DROP TABLE IF EXISTS usuarios;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(120) NOT NULL,
    descricao VARCHAR(255) NULL,
    categoria_id INT NOT NULL,
    preco DECIMAL(10,2) NOT NULL,
    quantidade_estoque INT NOT NULL DEFAULT 0,
    usuario_id INT NOT NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_produto_categoria FOREIGN KEY (categoria_id) REFERENCES categorias(id),
    CONSTRAINT fk_produto_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

INSERT INTO categorias (nome) VALUES
('Bolos'),
('Doces'),
('Tortas'),
('Brigadeiros');

INSERT INTO usuarios (nome, email, senha) VALUES
('Administrador', 'admin@doceria.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC1rX2hN7L9VxM2hYq');

INSERT INTO produtos (nome, descricao, categoria_id, preco, quantidade_estoque, usuario_id) VALUES
('Bolo de Chocolate', 'Bolo de chocolate com cobertura.', 1, 45.00, 10, 1),
('Brigadeiro', 'Brigadeiro tradicional.', 4, 3.50, 30, 1),
('Torta de Morango', 'Torta com creme e morangos.', 3, 55.00, 8, 1),
('Beijinho', 'Doce de coco.', 2, 3.50, 25, 1),
('Bolo de Cenoura', 'Bolo de cenoura com cobertura de chocolate.', 1, 40.00, 7, 1);
