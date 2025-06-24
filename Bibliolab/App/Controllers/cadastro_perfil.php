<?php
include('menu.php');
include('head.php');

// Conexão com o banco de dados (ajuste os dados conforme necessário)
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'biblioteca';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $senha_hash = $_POST['senha_hash'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($senha_hash !== $confirmar_senha) {
        $mensagem = '<div class="alert alert-danger">As senhas não coincidem.</div>';
    } else {
        // Verifica se o usuário já existe
        $sql = "SELECT id FROM usuarios WHERE usuario = '$usuario' OR email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $mensagem = '<div class="alert alert-warning">Usuário ou e-mail já cadastrado.</div>';
        } else {
            $senha_hash = password_hash($senha_hash, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nome, email, usuario, senha_hash) VALUES ('$nome', '$email', '$usuario', '$senha_hash')";
            if ($conn->query($sql) === TRUE) {
                $mensagem = '<div class="alert alert-success">Cadastro realizado com sucesso!</div>';
            } else {
                $mensagem = '<div class="alert alert-danger">Erro ao cadastrar: ' . $conn->error . '</div>';
            }
        }
    }
}
?>