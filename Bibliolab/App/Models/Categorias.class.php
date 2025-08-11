<?php
require_once(__DIR__ . '/../Core/Database.class.php');
require_once('Biblioteca.class.php');

class Categoria extends Biblioteca {
    public function __construct($id = null, $nome = "", $descricao = "", $categoria_id = null) {
        // Aqui usamos o construtor da classe Biblioteca com título = nome
        parent::__construct($id, $nome, $descricao, $categoria_id);
    }

    public function __toString() {
        return "Id: " . $this->getId() .
               " - Nome: " . $this->getTitulo() .
               " - Descrição: " . $this->getDescricao();
    }

    public function inserir() {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "INSERT INTO Categorias (nome, descricao) VALUES (:nome, :descricao)";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':nome', $this->getTitulo());
        $comando->bindValue(':descricao', $this->getDescricao());
        return $comando->execute();
    }

    public static function listar($tipo = 0, $info = '') {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "SELECT * FROM Categorias";

        if ($tipo > 0) {
            switch ($tipo) {
                case 1: $sql .= " WHERE id = :info ORDER BY id"; break;
                case 2: $sql .= " WHERE nome LIKE :info ORDER BY nome"; $info = '%' . $info . '%'; break;
                case 3: $sql .= " WHERE descricao LIKE :info ORDER BY descricao"; $info = '%' . $info . '%'; break;
            }
        }

        $comando = $conexao->prepare($sql);
        if ($tipo > 0) {
            $comando->bindValue(':info', $info);
        }

        $comando->execute();
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterar() {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "UPDATE Categorias SET nome = :nome, descricao = :descricao WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':nome', $this->getTitulo());
        $comando->bindValue(':descricao', $this->getDescricao());
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function excluir() {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "DELETE FROM Categorias WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }
}
?>
