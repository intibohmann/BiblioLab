<?php

class Favoritos {
    private $usuario_id;
    private $biblioteca_id;

    public function __construct($usuario_id = null, $biblioteca_id = null) {
        $this->usuario_id = $usuario_id;
        $this->biblioteca_id = $biblioteca_id;
    }

    public function setUsuarioId($usuario_id) {
        if ($usuario_id < 0) throw new Exception("Usuário inválido");
        $this->usuario_id = $usuario_id;
    }

    public function setBibliotecaId($biblioteca_id) {
        if ($biblioteca_id < 0) throw new Exception("Biblioteca inválida");
        $this->biblioteca_id = $biblioteca_id;
    }

    public function getUsuarioId() {
        return $this->usuario_id;
    }

    public function getBibliotecaId() {
        return $this->biblioteca_id;
    }

    public function inserir() {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        if (!self::existe($this->usuario_id, $this->biblioteca_id)) {
            $sql = "INSERT INTO Favoritos (usuario_id, biblioteca_id) VALUES (:usuario_id, :biblioteca_id)";
            $comando = $conexao->prepare($sql);
            $comando->bindValue(':usuario_id', $this->usuario_id);
            $comando->bindValue(':biblioteca_id', $this->biblioteca_id);
            return $comando->execute();
        }
        return false;
    }

    public function excluir() {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "DELETE FROM Favoritos WHERE usuario_id = :usuario_id AND biblioteca_id = :biblioteca_id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario_id', $this->usuario_id);
        $comando->bindValue(':biblioteca_id', $this->biblioteca_id);
        return $comando->execute();
    }

    public static function listarPorUsuario($usuario_id) {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "SELECT * FROM Favoritos WHERE usuario_id = :usuario_id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario_id', $usuario_id);
        $comando->execute();
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public static function existe($usuario_id, $biblioteca_id) {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "SELECT COUNT(*) FROM Favoritos WHERE usuario_id = :usuario_id AND biblioteca_id = :biblioteca_id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario_id', $usuario_id);
        $comando->bindValue(':biblioteca_id', $biblioteca_id);
        $comando->execute();
        return $comando->fetchColumn() > 0;
    }
}
