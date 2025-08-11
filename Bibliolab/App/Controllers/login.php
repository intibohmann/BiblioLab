<?php
session_start();

function redirecionar($tipo) {
    if ($tipo === 'admin') {
        header("Location: /BiblioLab/Bibliolab/App/views/profile/admin.php");
    } else {
        header("Location: /BiblioLab/Bibliolab/Public/index.php");
    }
    exit;
}

// Se já está logado, redireciona
if (isset($_SESSION['usuario_id'])) {
    redirecionar($_SESSION['tipo']);
}

// Só processa login se método for POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $lembrar = isset($_POST['lembrar']);

    $dsn = "mysql:host=localhost;dbname=biblioteca;charset=utf8";
    $dbUsername = "root";
    $dbPassword = "";

    try {
        $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    } catch (PDOException $e) {
        // Em vez de morrer aqui, podemos redirecionar com erro
        header("Location: /BiblioLab/Bibliolab/App/views/login.php?erro=" . urlencode("Erro ao conectar ao banco."));
        exit;
    }

    $stmt = $pdo->prepare("SELECT * FROM Usuarios WHERE usuario = ?");
    $stmt->execute([$usuario]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

   if ($user && password_verify($senha, $user['senha_hash'])) {
    $_SESSION['usuario_id'] = $user['id'];
    $_SESSION['usuario'] = $user['usuario'];
    $_SESSION['tipo'] = $user['tipo'];

    redirecionar($_SESSION['tipo']); // Redirecionamento

    } else {
        // Login inválido: redireciona para login com erro
        header("Location: /BiblioLab/Bibliolab/App/views/auth/login.php?erro=" . urlencode("Usuário ou senha inválidos."));
        exit;
    }
} else {
    // Se acessar controller via GET, redireciona para formulário
    header("Location: /BiblioLab/Bibliolab/App/views/auth/login.php ");
    exit;
}
