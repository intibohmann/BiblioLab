<?php
include_once ("Database.class.php");
class Usuario
{
    private $id;
    private $nome;
    private $email;
    private $senha_hash;
    private $data_cadastro;

    public function __construct($nome, $email, $senha)
    {
        $this->nome = $nome;
        $this->email = $email;
        $this->senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $this->data_cadastro = date('Y-m-d H:i:s');
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getSenhaHash() { return $this->senha_hash; }
    public function getDataCadastro() { return $this->data_cadastro; }

    // Setters
    public function setNome($nome) { $this->nome = $nome; }
    public function setEmail($email) { $this->email = $email; }
    public function setSenha($senha) { $this->senha_hash = password_hash($senha, PASSWORD_DEFAULT); }

    // Inserir usuário no banco de dados
    public function inserir($pdo)
    {
        $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha_hash, data_cadastro) VALUES (?, ?, ?, ?)");
        $result = $stmt->execute([$this->nome, $this->email, $this->senha_hash, $this->data_cadastro]);
        if ($result) {
            $this->id = $pdo->lastInsertId();
        }
        return $result;
    }

    // Alterar usuário no banco de dados
    public function alterar($pdo)
    {
        if (!$this->id) return false;
        $stmt = $pdo->prepare("UPDATE usuarios SET nome = ?, email = ?, senha_hash = ? WHERE id = ?");
        return $stmt->execute([$this->nome, $this->email, $this->senha_hash, $this->id]);
    }

    // Excluir usuário do banco de dados
    public function excluir($pdo)
    {
        if (!$this->id) return false;
        $stmt = $pdo->prepare("DELETE FROM usuarios WHERE id = ?");
        return $stmt->execute([$this->id]);
    }
}