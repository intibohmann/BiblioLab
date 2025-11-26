<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../../login.php");
    exit;
}

$dsn = "mysql:host=localhost;dbname=biblioteca;charset=utf8mb4";
$dbUsername = "root";
$dbPassword = "";

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $user_id = $_SESSION['usuario_id'];

    // Busca o nome do arquivo atual
    $stmt = $pdo->prepare("SELECT foto_perfil FROM Usuarios WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && !empty($user['foto_perfil'])) {
        $caminho = "../../../Public/assets/img/" . $user['foto_perfil'];
        if (file_exists($caminho)) {
            unlink($caminho);
        }

        $stmt = $pdo->prepare("UPDATE Usuarios SET foto_perfil = NULL WHERE id = ?");
        $stmt->execute([$user_id]);
    }

    header("Location: ../../perfil.php");
    exit;

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
