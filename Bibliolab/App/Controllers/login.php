<?php
session_start();

// Verifica se o usuário já está logado via sessão ou cookie
if (isset($_SESSION['usuario_id'])) {
    redirecionar($_SESSION['tipo']);
}

if (isset($_COOKIE['usuario_id'])) {
    $_SESSION['usuario_id'] = $_COOKIE['usuario_id'];
    $_SESSION['usuario'] = $_COOKIE['usuario'];
    $_SESSION['tipo'] = $_COOKIE['tipo'];
    redirecionar($_COOKIE['tipo']);
}

function redirecionar($tipo) {
    if ($tipo === 'admin') {
        header("Location: /BiblioLab/Bibliolab/Public/admin.php");
    } else {
        header("Location: /BiblioLab/Bibliolab/Public/index.php");
    }
    exit;
}

$erro = null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $lembrar = isset($_POST['lembrar']);

    $dsn = "mysql:host=localhost;dbname=biblioteca;charset=utf8";
    $dbUsername = "root";
    $dbPassword = "";

    try {
        $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        die("<div class='login-error'>Erro ao conectar ao banco.</div>");
    }

    $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($senha, $user['senha_hash'])) {
        $_SESSION['usuario_id'] = $user['id'];
        $_SESSION['usuario'] = $user['usuario'];
        $_SESSION['tipo'] = $user['tipo'];

        if ($lembrar) {
            setcookie("usuario_id", $user['id'], time() + 86400 * 7, "/"); // 7 dias
            setcookie("usuario", $user['usuario'], time() + 86400 * 7, "/");
            setcookie("tipo", $user['tipo'], time() + 86400 * 7, "/");
        }

        redirecionar($user['tipo']);
    } else {
        $erro = "Usuário ou senha inválidos.";
    }
}
?>