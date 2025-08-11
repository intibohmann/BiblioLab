<?php
session_start();
require_once(__DIR__ . '/../../core/Database.class.php');

$id = $_POST['id'];
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = !empty($_POST['senha']) ? password_hash($_POST['senha'], PASSWORD_DEFAULT) : null;

// Foto de perfil
$fotoNome = $_FILES['foto']['name'] ?? '';
$fotoTmp = $_FILES['foto']['tmp_name'] ?? '';
$destino = '';

if (!empty($fotoNome)) {
    $ext = pathinfo($fotoNome, PATHINFO_EXTENSION);
    $fotoFinal = 'perfil_' . $id . '.' . $ext;
    $destino = __DIR__ . '/../../Public/assets/img/' . $fotoFinal;
    move_uploaded_file($fotoTmp, $destino);
} else {
    $fotoFinal = $_SESSION['usuario']['foto']; // mantém a foto anterior
}

// Atualiza banco
$db = Database::conectar();
$sql = "UPDATE Usuarios SET nome = ?, email = ?, " . ($senha ? "senha = ?, " : "") . "foto = ? WHERE id = ?";
$stmt = $db->prepare($sql);

$params = [$nome, $email];
if ($senha) $params[] = $senha;
$params[] = $fotoFinal;
$params[] = $id;

if ($stmt->execute($params)) {
    $_SESSION['usuario']['nome'] = $nome;
    $_SESSION['usuario']['email'] = $email;
    $_SESSION['usuario']['foto'] = $fotoFinal;
    echo json_encode(['status' => 'ok', 'mensagem' => 'Perfil atualizado com sucesso!']);
} else {
    echo json_encode(['status' => 'erro', 'mensagem' => 'Erro ao atualizar perfil.']);
}
?>