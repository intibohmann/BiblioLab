<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../views/auth/login.php");
    exit;
}

require_once(__DIR__ . '/../core/Database.class.php');

$id = $_GET['id'] ?? null;

if ($id && is_numeric($id)) {
    $sql = "UPDATE Usuarios SET tipo = 'admin' WHERE id = :id";
    Database::executar($sql, [':id' => $id]);
}

header("Location: ../views/profile/admin.php");
exit;
?>