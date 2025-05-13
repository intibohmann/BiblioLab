<?php
require_once("Database.class.php");

class Favoritos {
    private $usuario_id;
    private $material_id;
    private $data_adicionado;

    public function __construct($usuario_id = null, $material_id = null, $data_adicionado = null) {
        $this->usuario_id = Usuarios::$id;
        $this->material_id = Materiais::$id;
        $this->data_adicionado = $data_adicionado;
    }

    // Setters
    public function setUsuarioId($usuario_id) {
        if ($usuario_id < 0) throw new Exception("Usuário inválido");
        $this->usuario_id = $usuario_id;
    }
    public function setMaterialId($material_id) {
        if ($material_id < 0) throw new Exception("Material inválido");
        $this->material_id = $material_id;
    }
    public function setDataAdicionado($data_adicionado) {
        $this->data_adicionado = $data_adicionado;
    }

    // Getters
    public function getUsuarioId() { return $this->usuario_id; }
    public function getMaterialId() { return $this->material_id; }
    public function getDataAdicionado() { return $this->data_adicionado; }

    // Adicionar favorito
    public function inserir() {
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "INSERT INTO Favoritos (usuario_id, material_id) VALUES (:usuario_id, :material_id)";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario_id', $this->getUsuarioId());
        $comando->bindValue(':material_id', $this->getMaterialId());
        return $comando->execute();
    }

    // Remover favorito
    public function excluir() {
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "DELETE FROM Favoritos WHERE usuario_id = :usuario_id AND material_id = :material_id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario_id', $this->getUsuarioId());
        $comando->bindValue(':material_id', $this->getMaterialId());
        return $comando->execute();
    }

    // Listar favoritos de um usuário
    public static function listarPorUsuario($usuario_id) {
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "SELECT * FROM Favoritos WHERE usuario_id = :usuario_id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario_id', $usuario_id);
        $comando->execute();
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    // Verificar se um material está nos favoritos de um usuário
    public static function existe($usuario_id, $material_id) {
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "SELECT COUNT(*) FROM Favoritos WHERE usuario_id = :usuario_id AND material_id = :material_id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario_id', $usuario_id);
        $comando->bindValue(':material_id', $material_id);
        $comando->execute();
        return $comando->fetchColumn() > 0;
    }
}
?>
