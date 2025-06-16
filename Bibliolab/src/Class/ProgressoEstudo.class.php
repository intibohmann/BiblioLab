<?php
require_once __DIR__ . '/Database.class.php';


class ProgressoEstudo {
    private $id;
    private $usuario_id;
    private $material_id;
    private $percentual_concluido;
    private $ultima_visualizacao;

    public function __construct($id = null, $usuario_id = null, $material_id = null, $percentual_concluido = 0.00, $ultima_visualizacao = null) {
        $this->id = $id;
        $this->usuario_id = $usuario_id;
        $this->material_id = $material_id;
        $this->percentual_concluido = $percentual_concluido;
        $this->ultima_visualizacao = $ultima_visualizacao;
    }

    // Setters
    public function setId($id) {
        if ($id < 0) throw new Exception("Id inválido");
        $this->id = $id;
    }
    public function setUsuarioId($usuario_id) {
        if ($usuario_id < 0) throw new Exception("Usuário inválido");
        $this->usuario_id = $usuario_id;
    }
    public function setMaterialId($material_id) {
        if ($material_id < 0) throw new Exception("Material inválido");
        $this->material_id = $material_id;
    }
    public function setPercentualConcluido($percentual_concluido) {
        if ($percentual_concluido < 0 || $percentual_concluido > 100) throw new Exception("Percentual inválido");
        $this->percentual_concluido = $percentual_concluido;
    }
    public function setUltimaVisualizacao($ultima_visualizacao) {
        $this->ultima_visualizacao = $ultima_visualizacao;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getUsuarioId() { return $this->usuario_id; }
    public function getMaterialId() { return $this->material_id; }
    public function getPercentualConcluido() { return $this->percentual_concluido; }
    public function getUltimaVisualizacao() { return $this->ultima_visualizacao; }

    public function __toString() {
        return "Id: $this->id - Usuário: $this->usuario_id - Material: $this->material_id - Percentual: $this->percentual_concluido% - Última Visualização: $this->ultima_visualizacao";
    }

    // CRUD
    public function inserir() {
        $conexao = new PDO(DSN,  username: DB_USER, password: DB_PASSWORD);
        $sql = "INSERT INTO ProgressoEstudo (usuario_id, material_id, percentual_concluido, ultima_visualizacao)
                VALUES (:usuario_id, :material_id, :percentual_concluido, :ultima_visualizacao)";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario_id', $this->getUsuarioId());
        $comando->bindValue(':material_id', $this->getMaterialId());
        $comando->bindValue(':percentual_concluido', $this->getPercentualConcluido());
        $comando->bindValue(':ultima_visualizacao', $this->getUltimaVisualizacao());
        return $comando->execute();
    }

    public static function listar($tipo = 0, $info = '') {
        $conexao = new PDO(DSN,  username: DB_USER, password: DB_PASSWORD);
        $sql = "SELECT * FROM ProgressoEstudo";
        if ($tipo > 0) {
            $sql .= match ($tipo) {
                1 => " WHERE id = :info ORDER BY id",
                2 => " WHERE usuario_id = :info ORDER BY usuario_id",
                3 => " WHERE material_id = :info ORDER BY material_id",
                default => "",
            };
        }
        $comando = $conexao->prepare($sql);
        if ($tipo > 0) $comando->bindValue(':info', $info);
        $comando->execute();
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterar() {
        $conexao = new PDO(DSN,  username: DB_USER, password: DB_PASSWORD);
        $sql = "UPDATE ProgressoEstudo SET
                    usuario_id = :usuario_id,
                    material_id = :material_id,
                    percentual_concluido = :percentual_concluido,
                    ultima_visualizacao = :ultima_visualizacao
                WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':usuario_id', $this->getUsuarioId());
        $comando->bindValue(':material_id', $this->getMaterialId());
        $comando->bindValue(':percentual_concluido', $this->getPercentualConcluido());
        $comando->bindValue(':ultima_visualizacao', $this->getUltimaVisualizacao());
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function excluir() {
        $conexao = new PDO(DSN,  username: DB_USER, password: DB_PASSWORD);
        $sql = "DELETE FROM ProgressoEstudo WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }
}
?>