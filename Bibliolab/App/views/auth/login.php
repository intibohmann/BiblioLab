<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <style>
        body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
        color: #222;
    }

    form {
        background: rgba(255, 255, 255, 0.95);
        padding: 32px 28px 24px 28px;
        border-radius: 18px;
        box-shadow: 0 8px 32px rgba(40, 40, 80, 0.18);
        animation: fadeIn 1s ease-in-out;
        width: 340px;
        text-align: center;
        position: relative;
    }

    form::before {
        content: "";
        position: absolute;
        top: -18px;
        left: 50%;
        transform: translateX(-50%);
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #2575fc 60%, #6a11cb 100%);
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(40, 40, 80, 0.10);
        z-index: 1;
    }

    form h2 {
        margin-top: 30px;
        margin-bottom: 24px;
        font-size: 1.5rem;
        color: #2575fc;
        font-weight: 700;
        letter-spacing: 1px;
    }

    label {
        display: block;
        margin-bottom: 7px;
        font-weight: 600;
        color: #444;
        text-align: left;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 12px 10px;
        margin-bottom: 18px;
        border: 1px solid #e0e0e0;
        border-radius: 7px;
        box-sizing: border-box;
        font-size: 1rem;
        background: #f7f9fa;
        transition: border 0.2s;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        border: 1.5px solid #2575fc;
        outline: none;
        background: #fff;
    }

    input[type="submit"] {
        background: linear-gradient(90deg, #2575fc 60%, #6a11cb 100%);
        color: #fff;
        border: none;
        padding: 12px 0;
        border-radius: 7px;
        cursor: pointer;
        width: 100%;
        font-size: 1.1rem;
        font-weight: 600;
        letter-spacing: 0.5px;
        box-shadow: 0 2px 8px rgba(40, 40, 80, 0.08);
        transition: background 0.3s, transform 0.2s;
    }

    input[type="submit"]:hover {
        background: linear-gradient(90deg, #6a11cb 60%, #2575fc 100%);
        transform: translateY(-2px) scale(1.02);
    }

    .login-error {
        color: #e53935;
        margin-top: 12px;
        font-size: 1rem;
        font-weight: 500;
        text-align: center;
        background: #fff3f3;
        border-radius: 5px;
        padding: 8px 0;
        border: 1px solid #ffdada;
    }

    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    </style>
</head>
<body>
<form action="/BiblioLab/Bibliolab/App/controllers/login.php?action=login" method="POST">
    <h2>Login</h2>
    <label for="usuario">Usuário:</label>
    <input type="text" id="usuario" name="usuario" required autocomplete="username">

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required autocomplete="current-password">

    <label>
        <input type="checkbox" name="lembrar"> Lembrar-me
    </label><br><br>

    <input type="submit" value="Entrar">

    <?php if (isset($erro) && $erro): ?>
        <div class="login-error"><?= $erro ?></div>
    <?php endif; ?>
</form>
</body>
</html>
