<?php
session_start();
require_once __DIR__ . '/../../Config/config.inc.php';
require_once __DIR__ . '/../Controllers/ChatBibliotecaController.php';

if (!isset($_SESSION['usuario_id'])) {
    echo "<div class='alert alert-danger'>Você precisa estar logado.</div>";
    exit;
}

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>Biblioteca não especificada.</div>";
    exit;
}

$pdo = new PDO(DSN, DB_USER, DB_PASSWORD);
$controller = new ChatBibliotecaController($pdo);

$biblioteca_id = (int) $_GET['id'];
$usuario_id = $_SESSION['usuario_id'];

// Se for POST, salvar mensagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mensagem'])) {
    $controller->enviarMensagem($biblioteca_id, $usuario_id, $_POST['mensagem']);
    exit; // usado pelo AJAX
}

// Buscar mensagens
$mensagens = $controller->exibirChat($biblioteca_id);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Chat da Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="/BiblioLab/Bibliolab/Public/js/chat.js"></script>
    <style>
        .chat-box {
            border: 1px solid #ccc;
            border-radius: 8px;
            height: 400px;
            overflow-y: auto;
            padding: 10px;
            background: #f8f9fa;
        }
        .msg { margin-bottom: 10px; }
        .msg strong { color: #007bff; }
    </style>
</head>
<body class="container mt-4">
    <h3>Chat da Biblioteca</h3>
    <div class="chat-box" id="chatBox">
        <?php foreach ($mensagens as $msg): ?>
            <div class="msg">
                <strong><?= htmlspecialchars($msg['nome']) ?>:</strong>
                <?= htmlspecialchars($msg['mensagem']) ?>
                <small class="text-muted">(<?= $msg['data_envio'] ?>)</small>
            </div>
        <?php endforeach; ?>
    </div>

    <form id="formChat" class="mt-3 d-flex">
        <input type="text" name="mensagem" id="mensagem" class="form-control me-2" placeholder="Digite sua mensagem..." required>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>

    <script>
        const bibliotecaId = <?= $biblioteca_id ?>;
        iniciarChat(bibliotecaId);
    </script>
</body>
</html>
