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
    tipo ENUM('ebook', 'video', 'artigo'),
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
    material_id INT,
    data_adicionado DATETIME DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, material_id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (material_id) REFERENCES Materiais(id)
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
