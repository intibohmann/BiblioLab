<?php
require_once __DIR__ . '/../Class/Database.class.php';


$mensagem = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $mensagemTexto = trim($_POST["mensagem"]);

    if (!empty($nome) && !empty($email) && !empty($mensagemTexto)) {
        $sql = "INSERT INTO contatos (nome, email, mensagem) VALUES (:nome, :email, :mensagem)";
        $params = [
            ':nome' => $nome,
            ':email' => $email,
            ':mensagem' => $mensagemTexto
        ];
        $resultado = Database::executar($sql, $params);

        if ($resultado) {
            $mensagem = "Mensagem enviada com sucesso!";
        } else {
            $mensagem = "Erro ao enviar a mensagem. Tente novamente.";
        }
    } else {
        $mensagem = "Por favor, preencha todos os campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Contato</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            padding: 40px;
        }
        .form-container {
            background: white;
            padding: 20px 30px;
            max-width: 500px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0,0,0,0.2);
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        button {
            background: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            margin-top: 10px;
            cursor: pointer;
        }
        .mensagem {
            margin-top: 15px;
            font-weight: bold;
            color: green;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Fale Conosco</h2>
    <?php if (!empty($mensagem)): ?>
        <div class="mensagem"><?php echo $mensagem; ?></div>
    <?php endif; ?>
    <form method="post">
        <label>Nome:</label>
        <input type="text" name="nome" required>

        <label>E-mail:</label>
        <input type="email" name="email" required>

        <label>Mensagem:</label>
        <textarea name="mensagem" rows="5" required></textarea>

        <button type="submit">Enviar</button>
    </form>
</div>

</body>
</html>
