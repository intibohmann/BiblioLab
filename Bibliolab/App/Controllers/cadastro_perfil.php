<?php
include __DIR__ . '../views/layouts/head.php';

// Conexão com o banco de dados usando PDO
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'biblioteca';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $senha_hash = $_POST['senha_hash'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if ($senha_hash !== $confirmar_senha) {
        $mensagem = '<div class="alert alert-danger">As senhas não coincidem.</div>';
    } else {
        // Verifica se o usuário já existe
        $sql = "SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['usuario' => $usuario, 'email' => $email]);

        if ($stmt->rowCount() > 0) {
            $mensagem = '<div class="alert alert-warning">Usuário ou e-mail já cadastrado.</div>';
        } else {
            $senha_hash_db = password_hash($senha_hash, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nome, email, usuario, senha_hash) VALUES (:nome, :email, :usuario, :senha_hash)";
            $stmt = $conn->prepare($sql);
            if ($stmt->execute([
                'nome' => $nome,
                'email' => $email,
                'usuario' => $usuario,
                'senha_hash' => $senha_hash_db
            ])) {
                $mensagem = '<div class="alert alert-success">Cadastro realizado com sucesso!</div>';
            } else {
                $mensagem = '<div class="alert alert-danger">Erro ao cadastrar.</div>';
            }
        }
    }
}
?>