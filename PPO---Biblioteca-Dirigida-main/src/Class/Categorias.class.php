<?php
require_once("Database.class.php");

class Categoria {
    private $id;
    private $nome;
    private $descricao;

    public function __construct($id = null, $nome = "", $descricao = "") {
        $this->id = $id;
        $this->nome = $nome;
        $this->descricao = $descricao;
    }

    public function setId($id) {
        if ($id < 0)
            throw new Exception("Erro, o Id tem que ser maior que 0");
        $this->id = $id;
    }

    public function setNome($nome) {
        if (empty($nome))
            throw new Exception("Erro, o nome deve ser informado!");
        $this->nome = $nome;
    }

    public function setDescricao($descricao) {
        if (empty($descricao))
            throw new Exception("Erro, a descricao deve ser informada!");
        $this->descricao = $descricao;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function __toString() {
        return "Id: $this->id - Nome: $this->nome - Descricao: $this->descricao";
    }

    public function inserir() {
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "INSERT INTO Categorias (nome, descricao) VALUES (:nome, :descricao)";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':nome', $this->getNome());
        $comando->bindValue(':descricao', $this->getDescricao());
        return $comando->execute();
    }

    public static function listar($tipo = 0, $info = '') {
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "SELECT * FROM Categorias";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1: $sql .= " WHERE id = :info ORDER BY id"; break;
                case 2: $sql .= " WHERE nome LIKE :info ORDER BY nome"; $info = '%'.$info.'%'; break;
                case 3: $sql .= " WHERE descricao LIKE :info ORDER BY descricao"; $info = '%'.$info.'%'; break;
            }
        }
        $comando = $conexao->prepare($sql);
        if ($tipo > 0)
            $comando->bindValue(':info', $info);
        $comando->execute();
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterar() {
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "UPDATE Categorias SET nome = :nome, descricao = :descricao WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':nome', $this->getNome());
        $comando->bindValue(':descricao', $this->getDescricao());
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function excluir() {
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "DELETE FROM Categorias WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }
}
?>
