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
    private $foto_perfil;

    public function __construct($id = null, $nome = "", $email = "", $usuario = "", $senha_hash = "", $tipo = "aluno", $foto_perfil = null, $data_cadastro = null) {
        $this->id = $id;
        $this->nome = $nome;
        $this->email = $email;
        $this->usuario = $usuario;
        $this->senha_hash = $senha_hash;
        $this->tipo = $tipo;
        $this->foto_perfil = $foto_perfil;
        $this->data_cadastro = $data_cadastro;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getNome() { return $this->nome; }
    public function getEmail() { return $this->email; }
    public function getUsuario() { return $this->usuario; }
    public function getSenhaHash() { return $this->senha_hash; }
    public function getTipo() { return $this->tipo; }
    public function getFotoPerfil() { return $this->foto_perfil; }
    public function getDataCadastro() { return $this->data_cadastro; }

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

    public function setFotoPerfil($foto) {
        $this->foto_perfil = $foto;
    }

    // Métodos de persistência
    public function inserir(): bool {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $sql = "INSERT INTO Usuarios (nome, email, usuario, senha_hash, tipo, foto_perfil) 
                VALUES (:nome, :email, :usuario, :senha_hash, :tipo, :foto_perfil)";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':usuario', $this->usuario);
        $stmt->bindValue(':senha_hash', $this->senha_hash);
        $stmt->bindValue(':tipo', $this->tipo);
        $stmt->bindValue(':foto_perfil', $this->foto_perfil);
        return $stmt->execute();
    }

    public static function listar($tipo = 0, $info = ''): array {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $sql = "SELECT * FROM Usuarios";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1: $sql .= " WHERE id = :info"; break;
                case 2: $sql .= " WHERE nome LIKE :info"; $info = "%$info%"; break;
                case 3: $sql .= " WHERE email LIKE :info"; $info = "%$info%"; break;
                case 4: $sql .= " WHERE usuario LIKE :info"; $info = "%$info%"; break;
                case 5: $sql .= " WHERE tipo = :info"; break;
            }
        }
        $stmt = $conexao->prepare($sql);
        if ($tipo > 0) $stmt->bindValue(':info', $info);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterar(): bool {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $sql = "UPDATE Usuarios SET 
                    nome = :nome,
                    email = :email,
                    usuario = :usuario,
                    senha_hash = :senha_hash,
                    tipo = :tipo,
                    foto_perfil = :foto_perfil
                WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':nome', $this->nome);
        $stmt->bindValue(':email', $this->email);
        $stmt->bindValue(':usuario', $this->usuario);
        $stmt->bindValue(':senha_hash', $this->senha_hash);
        $stmt->bindValue(':tipo', $this->tipo);
        $stmt->bindValue(':foto_perfil', $this->foto_perfil);
        $stmt->bindValue(':id', $this->id);
        return $stmt->execute();
    }

    public function excluir(): bool {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
        $sql = "DELETE FROM Usuarios WHERE id = :id";
        $stmt = $conexao->prepare($sql);
        $stmt->bindValue(':id', $this->id);
        return $stmt->execute();
    }

    public function __toString(): string {
        return "Id: $this->id - Nome: $this->nome - Email: $this->email - Usuário: $this->usuario - Tipo: $this->tipo - Foto: $this->foto_perfil - Data Cadastro: $this->data_cadastro";
    }
}
?>
