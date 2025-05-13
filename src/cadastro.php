<?php 
include('menu.php'); 
include('head.php'); 

// Processar formulário
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=biblioteca', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $usuario = new Usuario(
            $_POST['nome'],
            $_POST['email'],
            $_POST['senha']
        );

        if ($_POST['senha'] !== $_POST['confirmar_senha']) {
            throw new Exception("As senhas não coincidem.");
        }

        if ($usuario->salvar($pdo)) {
            $success = "Cadastro realizado com sucesso!";
        } else {
            throw new Exception("Erro ao cadastrar usuário.");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}
?>

<body>
    <div class="form-container">
        <h2>Cadastro</h2>
        
        <?php if(isset($error)): ?>
            <div class="error-message"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>
        
        <?php if(isset($success)): ?>
            <div class="success-message"><?= htmlspecialchars($success) ?></div>
        <?php else: ?>
            <form method="POST" action="">
                <label for="nome">Nome:</label>
                <input type="text" id="nome" name="nome" required 
                       value="<?= htmlspecialchars($_POST['nome'] ?? '') ?>">
                
                <label for="email">E-mail:</label>
                <input type="email" id="email" name="email" required 
                       value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                
                <label for="senha">Senha:</label>
                <input type="password" id="senha" name="senha" required>
                
                <label for="confirmar_senha">Confirmar Senha:</label>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
                
                <button type="submit">Cadastrar</button>
            </form>
        <?php endif; ?>
    </div>
</body>

<style>
    body {
        background: linear-gradient(120deg, #f0f4f8 0%, #c9e7fa 100%);
        min-height: 100vh;
        margin: 0;
        font-family: 'Segoe UI', Arial, sans-serif;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-container {
        background: #fff;
        padding: 2.5rem 2rem;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(60, 120, 180, 0.15);
        max-width: 400px;
        width: 100%;
        margin: 2rem;
        animation: fadeInUp 0.8s cubic-bezier(.39,.575,.565,1.000);
    }

    @keyframes fadeInUp {
        0% {
            opacity: 0;
            transform: translateY(40px);
        }
        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    h2 {
        text-align: center;
        margin-bottom: 1.5rem;
        color: #2a5d9f;
        letter-spacing: 1px;
        font-weight: 600;
    }

    form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    label {
        font-size: 1rem;
        color: #2a5d9f;
        margin-bottom: 0.2rem;
        font-weight: 500;
    }

    input[type="text"],
    input[type="email"],
    input[type="password"] {
        padding: 0.7rem 1rem;
        border: 1px solid #b3c6e0;
        border-radius: 8px;
        font-size: 1rem;
        transition: border-color 0.2s;
        background: #f7fbff;
    }

    input:focus {
        border-color: #2a5d9f;
        outline: none;
        background: #eaf4ff;
    }

    button[type="submit"] {
        padding: 0.8rem;
        background: linear-gradient(90deg, #2a5d9f 60%, #4bb3fd 100%);
        color: #fff;
        border: none;
        border-radius: 8px;
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        margin-top: 0.5rem;
        box-shadow: 0 2px 8px rgba(60, 120, 180, 0.08);
        transition: background 0.2s, transform 0.1s;
        animation: pulseBtn 1.2s infinite alternate;
    }

    @keyframes pulseBtn {
        0% { transform: scale(1);}
        100% { transform: scale(1.04);}
    }

    button[type="submit"]:hover {
        background: linear-gradient(90deg, #4bb3fd 0%, #2a5d9f 100%);
        transform: scale(1.05);
    }

    .error-message, .success-message {
        margin-bottom: 15px;
        padding: 12px;
        border-radius: 7px;
        font-size: 1rem;
        text-align: center;
        animation: fadeIn 0.7s;
    }

    .error-message {
        color: #ff3333;
        background: #ffeeee;
        border: 1px solid #ffb3b3;
    }

    .success-message {
        color: #009900;
        background: #eeffee;
        border: 1px solid #b3ffb3;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @media (max-width: 500px) {
        .form-container {
            padding: 1.2rem 0.7rem;
            max-width: 98vw;
        }
        h2 {
            font-size: 1.3rem;
        }
        label, input, button {
            font-size: 1rem;
        }
    }
</style>

<?php include("rodape.php"); ?>