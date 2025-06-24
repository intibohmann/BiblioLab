<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "biblioteca";
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

$nome = $_POST['nome'];
$email = $_POST['email'];
$novaSenha = $_POST['nova_senha'];
$user_id = $_SESSION['user_id'];
$fotoNome = null;

// Upload de imagem
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $extensao = strtolower(pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION));
    $permitidos = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($extensao, $permitidos)) {
        $fotoNome = uniqid() . '.' . $extensao;
        $caminhoDestino = __DIR__ . "/uploads/" . $fotoNome;

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoDestino)) {
            // Sucesso no upload
        } else {
            die("Erro ao mover o arquivo enviado.");
        }
    } else {
        die("Tipo de imagem não permitido. Use jpg, jpeg, png ou gif.");
    }
}


// Atualizar dados
if (!empty($novaSenha)) {
    $senha_hash = password_hash($novaSenha, PASSWORD_DEFAULT);
    $sql = "UPDATE Usuarios SET nome=?, email=?, senha_hash=?" . ($fotoNome ? ", foto_perfil=?" : "") . " WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($fotoNome) {
        $stmt->bind_param("ssssi", $nome, $email, $senha_hash, $fotoNome, $user_id);
    } else {
        $stmt->bind_param("sssi", $nome, $email, $senha_hash, $user_id);
    }
} else {
    $sql = "UPDATE Usuarios SET nome=?, email=?" . ($fotoNome ? ", foto_perfil=?" : "") . " WHERE id=?";
    $stmt = $conn->prepare($sql);
    if ($fotoNome) {
        $stmt->bind_param("sssi", $nome, $email, $fotoNome, $user_id);
    } else {
        $stmt->bind_param("ssi", $nome, $email, $user_id);
    }
}

$stmt->execute();
$stmt->close();
$conn->close();

header("Location: perfil.php");
exit;
?>