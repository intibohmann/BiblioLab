<?php
require_once '../core/Database.class.php';


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
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: linear-gradient(135deg,rgb(253, 254, 255) 0%,rgb(255, 255, 255) 100%);
            padding: 40px;
            min-height: 100vh;
            margin: 0;
        }
        .form-container {
            background: #fff;
            padding: 30px 40px;
            max-width: 500px;
            margin: 40px auto;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 123, 255, 0.15);
            animation: fadeInUp 0.8s cubic-bezier(.39,.575,.565,1) both;
        }
        .form-container h2 {
            color: #0074D9;
            text-align: center;
            margin-bottom: 24px;
            letter-spacing: 1px;
        }
        label {
            color: #0074D9;
            font-weight: 500;
            margin-top: 12px;
            display: block;
        }
        input, textarea {
            width: 100%;
            padding: 12px;
            margin: 8px 0 18px 0;
            border-radius: 8px;
            border: 1px solid #b3d1f7;
            background: #f8fbff;
            font-size: 1rem;
            transition: border 0.2s;
        }
        input:focus, textarea:focus {
            border: 1.5px solid #0074D9;
            outline: none;
            background: #eaf6ff;
        }
        button {
            background: linear-gradient(90deg, #0074D9 60%, #00BFFF 100%);
            color: white;
            padding: 12px 0;
            width: 100%;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            margin-top: 10px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,123,255,0.08);
            transition: background 0.2s, transform 0.1s;
        }
        button:hover {
            background: linear-gradient(90deg, #005fa3 60%, #0099cc 100%);
            transform: translateY(-2px) scale(1.02);
        }
        .mensagem {
            margin-top: 18px;
            font-weight: bold;
            color: #0074D9;
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include("../views/layouts/Menu.php"); ?>
    <div class="form-container">
        <h2>Fale Conosco</h2>
        <form action="https://formsubmit.co/BiblioLab2025@gmail.com" method="post" class="help-form">
            <input type="hidden" name="_captcha" value="false">
            <input type="hidden" name="_next" value="http://localhost/BiblioLab/Bibliolab/App/views/contato.php">
            <input type="hidden" name="_template" value="box">

            <label for="name">Nome:</label>
            <input type="text" id="name" name="name" required>
           
            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>
           
            <label for="subject">Assunto:</label>
            <input type="text" id="subject" name="subject" required>
           
            <label for="message">Mensagem:</label>
            <textarea id="message" name="message" rows="5" required></textarea>
           
            <button type="submit">Enviar</button>
        </form>
        <?php if (!empty($mensagem)): ?>
            <div class="mensagem"><?php echo htmlspecialchars($mensagem); ?></div>
        <?php endif; ?>
    </div>
</body>
</html>

</body>
</html>
