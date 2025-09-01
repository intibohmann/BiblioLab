<?php
session_start();
require_once(__DIR__ . '/../../Config/config.inc.php');

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
    exit;
}

$id     = $_POST['id'] ?? null;
$nome   = trim($_POST['nome'] ?? '');
$email  = trim($_POST['email'] ?? '');
$senha  = $_POST['senha'] ?? '';
$foto   = $_FILES['foto'] ?? null;  



if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id'] != $id) {
    echo json_encode(["sucesso" => false, "mensagem" => "Acesso não autorizado."]);
    exit;
}

if (empty($nome) || empty($email)) {
    echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos obrigatórios."]);
    exit;
}

try {
    $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $campos = ["nome = :nome", "email = :email"];
    $params = [":nome" => $nome, ":email" => $email, ":id" => $id];

    if (!empty($senha)) {
        $campos[] = "senha_hash = :senha";
        $params[":senha"] = password_hash($senha, PASSWORD_DEFAULT);
    }

    if (!empty($foto['name'])) {
        $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($extensao, $permitidas)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Formato de imagem inválido."]);
            exit;
        }

        $nomeArquivo = uniqid('perfil_', true) . "." . $extensao;
        $caminhoDestino = __DIR__ . '/../../Public/assets/img/' . $nomeArquivo;

        if (move_uploaded_file($foto['tmp_name'], $caminhoDestino)) {
            $campos[] = "foto_perfil = :foto";  
            $params[":foto"] = $nomeArquivo;

            // Atualiza sessão para refletir a nova foto
            $_SESSION['usuario']['foto_perfil'] = $nomeArquivo;  
        } else {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao enviar a foto."]);
            exit;
        }
    }

    $sql = "UPDATE Usuarios SET " . implode(', ', $campos) . " WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    // Atualiza dados da sessão
    $_SESSION['usuario']['nome'] = $nome;    
    $_SESSION['usuario']['email'] = $email;  
    if (!empty($senha)) {
        $_SESSION['usuario']['senha_hash'] = $params[":senha"];
    }

    echo json_encode(["sucesso" => true, "mensagem" => "Perfil atualizado com sucesso!"]);
} catch (Exception $e) {
    echo json_encode(["sucesso" => false, "mensagem" => "Erro: " . $e->getMessage()]);
}
?>