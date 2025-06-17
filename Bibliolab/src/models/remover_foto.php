<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['user_id'];
$foto = $_POST['foto_atual'] ?? null;

$caminhoFoto = __DIR__ . "/uploads/" . $foto;

if ($foto && file_exists($caminhoFoto)) {
    unlink($caminhoFoto); // Apaga o arquivo
}

// Atualiza no banco para remover a referência
$conn = new mysqli("localhost", "root", "", "biblioteca");
if ($conn->connect_error) {
    die("Erro ao conectar: " . $conn->connect_error);
}

$stmt = $conn->prepare("UPDATE Usuarios SET foto_perfil = NULL WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();

$stmt->close();
$conn->close();

header("Location: perfil.php");
exit();
?>