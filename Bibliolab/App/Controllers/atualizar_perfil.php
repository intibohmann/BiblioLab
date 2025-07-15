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

    $id = $_SESSION['usuario_id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $nova_senha = $_POST['nova_senha'];

    $query = "UPDATE Usuarios SET nome = ?, email = ?";
    $params = [$nome, $email];

    if (!empty($nova_senha)) {
        $senha_hash = password_hash($nova_senha, PASSWORD_DEFAULT);
        $query .= ", senha = ?";
        $params[] = $senha_hash;
    }

    // Foto de perfil
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $nomeFoto = uniqid() . '_' . basename($_FILES['foto']['name']);
        $destino = "../../../Public/assets/img/{$nomeFoto}";
        move_uploaded_file($_FILES['foto']['tmp_name'], $destino);
        $query .= ", foto_perfil = ?";
        $params[] = $nomeFoto;
    }

    $query .= " WHERE id = ?";
    $params[] = $id;

    $stmt = $pdo->prepare($query);
    $stmt->execute($params);

    header("Location: /BiblioLab/Bibliolab/App/views/profile/index.php");
    exit;

} catch (PDOException $e) {
    die("Erro: " . $e->getMessage());
}
