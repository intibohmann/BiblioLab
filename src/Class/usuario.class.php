<?php
include_once "Database.class.php";

class Usuario {
    private $id;
    private $nome;
    private $email;
    private $senha_hash;
    private $data_cadastro;

    public function __construct($nome, $email, $senha) {
        $this->nome = $this->validarNome($nome);
        $this->email = $this->validarEmail($email);
        $this->senha_hash = $this->gerarHashSenha($senha);
        $this->data_cadastro = date('Y-m-d H:i:s');
    }

    // Métodos de validação simplificados
    private function validarNome($nome) {
        return trim($nome);
    }

    private function validarEmail($email) {
        return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
    }

    private function gerarHashSenha($senha) {
        return password_hash(trim($senha), PASSWORD_DEFAULT);
    }

    // Getters (mantidos os mesmos)
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getSenhaHash() { return $this->senha_hash; }
    public function getDataCadastro() { return $this->data_cadastro; }

    // Setters com validação básica
    public function setNome($nome) { 
        $this->nome = $this->validarNome($nome); 
    }

    public function setEmail($email) { 
        $this->email = $this->validarEmail($email); 
    }

    public function setSenha($senha) { 
        $this->senha_hash = $this->gerarHashSenha($senha); 
    }

    // Métodos CRUD otimizados
    public function salvar($pdo) {
        if(empty($this->id)) {
            return $this->inserir($pdo);
        } else {
            return $this->alterar($pdo);
        }
    }

    private function inserir($pdo) {
        $sql = "INSERT INTO usuarios (nome, email, senha_hash, data_cadastro) 
                VALUES (:nome, :email, :senha_hash, :data_cadastro)";
        $params = [
            ':nome' => $this->nome,
            ':email' => $this->email,
            ':senha_hash' => $this->senha_hash,
            ':data_cadastro' => $this->data_cadastro
        ];
        
        $stmt = Database::executar($sql, $params);
        if($stmt) {
            $this->id = $pdo->lastInsertId();
            return true;
        }
        return false;
    }

    public function alterar($pdo) {
        if(empty($this->id)) return false;
        
        $sql = "UPDATE usuarios SET nome = :nome, email = :email, 
                senha_hash = :senha_hash WHERE id = :id";
        $params = [
            ':nome' => $this->nome,
            ':email' => $this->email,
            ':senha_hash' => $this->senha_hash,
            ':id' => $this->id
        ];
        
        return Database::executar($sql, $params) !== false;
    }

    public function excluir($pdo) {
        if(empty($this->id)) return false;
        
        $sql = "DELETE FROM usuarios WHERE id = :id";
        return Database::executar($sql, [':id' => $this->id]) !== false;
    }
}
?>