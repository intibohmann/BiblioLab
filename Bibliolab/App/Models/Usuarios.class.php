<?php
require_once(__DIR__ . '/../Core/Database.class.php');



class Usuario {
    private $id;
    private $nome;
    private $email;
    private $usuario;
    private $senha_hash;
    private $data_cadastro;
    private $tipo;

    public function __construct($id = null, $nome = "", $email = "", $usuario = "", $senha_hash = "", $data_cadastro = "", $tipo = "aluno") {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->usuario = $usuario;
        $this->senha_hash = $senha_hash;
        $this->data_cadastro = $data_cadastro;
        $this->tipo = $tipo;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getUsuario() { return $this->usuario; }
    public function getSenhaHash() { return $this->senha_hash; }
    public function getDataCadastro() { return $this->data_cadastro; }
    public function getTipo() { return $this->tipo; }

    // Setters
    public function setNome($nome) {
        if (empty($nome)) throw new Exception("Nome não pode ser vazio.");
        $this->nome = $nome;
    }
    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) throw new Exception("Email inválido.");
        $this->email = $email;
    }
    public function setUsuario($usuario) {
        if (empty($usuario)) throw new Exception("Usuário não pode ser vazio.");
        $this->usuario = $usuario;
    }
    public function setSenhaHash($senha_hash) {
        if (empty($senha_hash)) throw new Exception("Senha não pode ser vazia.");
        $this->senha_hash = $senha_hash;
    }
    public function setTipo($tipo) {
        if (!in_array($tipo, ['aluno', 'admin'])) throw new Exception("Tipo inválido.");
        $this->tipo = $tipo;
    }

    // Métodos de persistência
    public function inserir(): bool {
        $conexao = new PDO(DSN, username: DB_USER, password: DB_PASSWORD);
        $sql = "INSERT INTO Usuarios (nome, email, usuario, senha_hash, tipo) VALUES (:nome, :email, :usuario, :senha_hash, :tipo)";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':nome', $this->getNome());
        $comando->bindValue(':email', $this->getEmail());
        $comando->bindValue(':usuario', $this->getUsuario());
        $comando->bindValue(':senha_hash', $this->getSenhaHash());
        $comando->bindValue(':tipo', $this->getTipo());
        return $comando->execute();
    }

    public static function listar($tipo = 0, $info = ''): array {
        $conexao = new PDO(DSN,  username: DB_USER, password: DB_PASSWORD);
        $sql = "SELECT * FROM Usuarios";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1: $sql .= " WHERE id = :info"; break;
                case 2: $sql .= " WHERE nome LIKE :info"; $info = '%' . $info . '%'; break;
                case 3: $sql .= " WHERE email LIKE :info"; $info = '%' . $info . '%'; break;
                case 4: $sql .= " WHERE usuario LIKE :info"; $info = '%' . $info . '%'; break;
                case 5: $sql .= " WHERE tipo = :info"; break;
            }
        }
        $comando = $conexao->prepare($sql);
        if ($tipo > 0) $comando->bindValue(':info', $info);
        $comando->execute();
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterar(): bool {
        $conexao = new PDO(DSN,  username: DB_USER, password: DB_PASSWORD);
        $sql = "UPDATE Usuarios SET nome = :nome, email = :email, usuario = :usuario, senha_hash = :senha_hash, tipo = :tipo WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':nome', $this->getNome());
        $comando->bindValue(':email', $this->getEmail());
        $comando->bindValue(':usuario', $this->getUsuario());
        $comando->bindValue(':senha_hash', $this->getSenhaHash());
        $comando->bindValue(':tipo', $this->getTipo());
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function excluir(): bool {
        $conexao = new PDO(DSN,  username: DB_USER, password: DB_PASSWORD);
        $sql = "DELETE FROM Usuarios WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function __toString(): string {
        return "Id: $this->id - Nome: $this->nome - Email: $this->email - Usuário: $this->usuario - Tipo: $this->tipo - Data Cadastro: $this->data_cadastro";
    }
}
?>
