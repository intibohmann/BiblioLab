<?php 
include('head.php'); 
include("menuB.php");

session_start();

//EU NÃO ENTENDO NEM O CÓDIGO QUE EU FIZ NESSA DESGRAÇA COMO PODE!
if (!isset($_SESSION['username'])) {
    $_SESSION['username'] = 'User' . rand(1000, 9999); 
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $message = $_POST['message'];
    $username = $_SESSION['username'];
    $timestamp = date('Y-m-d , H:i:s');


    file_put_contents('chat.txt', "$timestamp - $username: $message\n", FILE_APPEND);
}


$messages = file_get_contents('chat.txt');
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat de Mensagens</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }


        .container {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
            box-sizing: border-box;
        }

  
        .chat-container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 900px;
            display: flex;
            flex-direction: column;
            height: 80vh;
        }


        .messages {
            flex-grow: 1;
            overflow-y: auto;
            padding: 20px;
            max-height: 80%;
            border-bottom: 1px solid #ddd;
        }

        .message {
            padding: 10px;
            border-radius: 8px;
            background-color: #e2e2e2;
            margin-bottom: 10px;
            max-width: 80%;
            word-wrap: break-word;
        }

        .message span {
            font-weight: bold;
        }


        .input-container {
            display: flex;
            padding: 10px;
            border-top: 1px solid #ddd;
            background-color: #f9f9f9;
        }

        .input-container input {
            flex-grow: 1;
            padding: 10px;
            border-radius: 20px;
            font-size: 16px;
            border: 1px solid #ccc;
            outline: none;
        }

        .input-container button {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            margin-left: 10px;
        }

        .input-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="container">
        <div class="chat-container">
            <div class="messages" id="messages">
                <?php

                $messageArray = explode("\n", $messages);
                foreach ($messageArray as $messageLine) {
                    if (!empty($messageLine)) {
                        echo "<div class='message'>" . htmlspecialchars($messageLine) . "</div>";
                    }
                }
                ?>
            </div>

            <div class="input-container">
                <form action="chat.php" method="POST">
                    <input type="text" name="message" id="messageInput" placeholder="Digite sua mensagem..." required />
                    <button type="submit">Enviar</button>
                </form>
            </div>
        </div>
    </div>

    <?php include("rodape.php"); ?>
</body>
</html>
