<?php 
include('head.php'); 
include("menuB.php");

session_start();

// Configuração simplificada do chat
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'Visitante' . rand(100, 999); 
}

// Processar mensagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['message'])) {
    $message = htmlspecialchars(trim($_POST['message']));
    $username = htmlspecialchars($_SESSION['username']);
    $timestamp = date('Y-m-d H:i:s');
    
    // Formatar mensagem para arquivo
    $formattedMessage = "$timestamp - $username: $message\n";
    
    // Limitar arquivo a 100KB (para projeto escolar)
    $maxSize = 100 * 1024; // 100KB
    if (@filesize('chat.txt') < $maxSize) {
        file_put_contents('chat.txt', $formattedMessage, FILE_APPEND);
    } else {
        // Se ficar muito grande, mantém apenas as últimas 100 linhas
        $lines = file('chat.txt');
        $lines = array_slice($lines, -100);
        file_put_contents('chat.txt', implode("", $lines) . $formattedMessage);
    }
}

// Ler mensagens
$messages = @file_get_contents('chat.txt') ?: "Chat iniciado.\n";
?>

<div class="container">
    <div class="chat-container">
        <div class="messages" id="messages">
            <?php
            $messageLines = array_reverse(explode("\n", trim($messages)));
            foreach ($messageLines as $line) {
                if (!empty($line)) {
                    echo "<div class='message'>" . htmlspecialchars($line) . "</div>";
                }
            }
            ?>
        </div>

        <div class="input-container">
            <form action="chat.php" method="POST" id="chatForm">
                <input type="text" name="message" id="messageInput" 
                       placeholder="Digite sua mensagem..." required />
                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>
</div>

<script>
// Rolagem automática para a mensagem mais recente
document.getElementById('messages').scrollTop = 
    document.getElementById('messages').scrollHeight;

// Foco automático no campo de mensagem
document.getElementById('messageInput').focus();

// Enviar mensagem com Enter
document.getElementById('chatForm').onsubmit = function(e) {
    if (document.getElementById('messageInput').value.trim() === '') {
        e.preventDefault();
    }
};
</script>

<?php include("rodape.php"); ?>