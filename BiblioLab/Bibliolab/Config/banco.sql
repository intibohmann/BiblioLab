create database biblioteca;
use biblioteca;

CREATE TABLE Usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    usuario VARCHAR(50) UNIQUE,
    senha_hash VARCHAR(255),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    tipo ENUM('aluno', 'admin') DEFAULT 'aluno'
);

CREATE TABLE Categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    descricao TEXT
);

CREATE TABLE Materiais (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(200),
    descricao TEXT,
    tipo ENUM('video', 'texto'),
    url TEXT,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
);

CREATE TABLE ProgressoEstudo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    material_id INT,
    percentual_concluido DECIMAL(5,2),
    ultima_visualizacao DATETIME,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (material_id) REFERENCES Materiais(id)
);

CREATE TABLE Favoritos (
    usuario_id INT,
    data_adicionado DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

CREATE TABLE Biblioteca (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(200),
    descricao TEXT,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
);

ALTER TABLE Materiais
ADD COLUMN biblioteca_id INT,
ADD FOREIGN KEY (biblioteca_id) REFERENCES Biblioteca(id);

CREATE TABLE contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

ALTER TABLE Usuarios
ADD COLUMN foto_perfil VARCHAR(255) DEFAULT NULL;

ALTER TABLE materiais 
DROP FOREIGN KEY materiais_ibfk_2;

ALTER TABLE materiais 
ADD CONSTRAINT materiais_ibfk_2
FOREIGN KEY (biblioteca_id) REFERENCES biblioteca(id)
ON DELETE CASCADE;

CREATE TABLE ChatBiblioteca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    biblioteca_id INT NOT NULL,
    usuario_id INT NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (biblioteca_id) REFERENCES Biblioteca(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE
);

ALTER TABLE Favoritos ADD biblioteca_id INT;
ALTER TABLE Favoritos ADD FOREIGN KEY (biblioteca_id) REFERENCES Biblioteca(id);
ALTER TABLE Favoritos ADD COLUMN material_id INT AFTER usuario_id;
ALTER TABLE Favoritos
ADD CONSTRAINT fk_favoritos_material
FOREIGN KEY (material_id) REFERENCES Materiais(id)
ON DELETE CASCADE;



CREATE DATABASE biblioteca;
USE biblioteca;

-- =======================
-- TABELA: USUARIOS
-- =======================
CREATE TABLE Usuarios (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    email VARCHAR(100) UNIQUE,
    usuario VARCHAR(50) UNIQUE,
    senha_hash VARCHAR(255),
    data_cadastro DATETIME DEFAULT CURRENT_TIMESTAMP,
    tipo ENUM('aluno', 'admin') DEFAULT 'aluno',
    foto_perfil VARCHAR(255) DEFAULT NULL
);

-- =======================
-- TABELA: CATEGORIAS
-- =======================
CREATE TABLE Categorias (
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100),
    descricao TEXT
);

-- =======================
-- TABELA: BIBLIOTECA
-- =======================
CREATE TABLE Biblioteca (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(200),
    descricao TEXT,
    categoria_id INT,
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id)
);

-- =======================
-- TABELA: MATERIAIS
-- =======================
CREATE TABLE Materiais (
    id INT PRIMARY KEY AUTO_INCREMENT,
    titulo VARCHAR(200),
    descricao TEXT,
    tipo ENUM('video', 'texto'),
    url TEXT,
    categoria_id INT,
    biblioteca_id INT,
    FOREIGN KEY (categoria_id) REFERENCES Categorias(id),
    FOREIGN KEY (biblioteca_id) REFERENCES Biblioteca(id) ON DELETE CASCADE
);

-- =======================
-- TABELA: PROGRESSO ESTUDO
-- =======================
CREATE TABLE ProgressoEstudo (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    material_id INT,
    percentual_concluido DECIMAL(5,2),
    ultima_visualizacao DATETIME,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (material_id) REFERENCES Materiais(id)
);

-- =======================
-- TABELA: FAVORITOS (corrigida)
-- =======================
CREATE TABLE Favoritos (
    usuario_id INT,
    material_id INT,
    biblioteca_id INT,
    data_adicionado DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, material_id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (material_id) REFERENCES Materiais(id) ON DELETE CASCADE,
    FOREIGN KEY (biblioteca_id) REFERENCES Biblioteca(id) ON DELETE CASCADE
);

-- =======================
-- TABELA: CONTATOS
-- =======================
CREATE TABLE Contatos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- =======================
-- TABELA: CHAT BIBLIOTECA
-- =======================
CREATE TABLE ChatBiblioteca (
    id INT AUTO_INCREMENT PRIMARY KEY,
    biblioteca_id INT NOT NULL,
    usuario_id INT NOT NULL,
    mensagem TEXT NOT NULL,
    data_envio TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (biblioteca_id) REFERENCES Biblioteca(id) ON DELETE CASCADE,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id) ON DELETE CASCADE
);
