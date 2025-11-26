<?php
session_start();

// Se já estiver logado, redireciona direto
if (isset($_SESSION['usuario_id'])) {
    header("Location: /BiblioLab/Bibliolab/App/views/profile/admin.php");
    exit;
}

// Pega erro via GET para mostrar na view, se existir
$erro = $_GET['erro'] ?? null;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e0e7ff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            animation: fadeIn 1s ease;
            max-width: 400px;
            margin: auto;
            padding: 2rem 2.5rem;
            border-radius: 1rem;
            box-shadow: 0 0.5rem 1rem rgba(0,0,0,0.1);
            background: #fff;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px);}
            to { opacity: 1; transform: translateY(0);}
        }
        .login-error {
            animation: shake 0.4s;
            color: #fff;
            background: #dc3545;
            padding: 0.75rem;
            border-radius: 0.5rem;
            margin-top: 1rem;
            text-align: center;
        }
        @keyframes shake {
            0% { transform: translateX(0);}
            20% { transform: translateX(-8px);}
            40% { transform: translateX(8px);}
            60% { transform: translateX(-8px);}
            80% { transform: translateX(8px);}
            100% { transform: translateX(0);}
        }
    </style>
</head>
<body>
<div class="login-card shadow">
    <form action="/BiblioLab/Bibliolab/App/controllers/login.php" method="POST">
        <h2 class="mb-4 text-center">Login</h2>
        <div class="mb-3">
            <label for="usuario" class="form-label">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required autocomplete="username" class="form-control">
        </div>
        <div class="mb-3">
            <label for="senha" class="form-label">Senha:</label>
            <input type="password" id="senha" name="senha" required autocomplete="current-password" class="form-control">
        </div>
        <div class="form-check mb-3">
            <label class="form-check-label" for="cadastro-link">
                Não tem login?
                <a href="/BiblioLab/Bibliolab/App/views/auth/Cad_usuario.php" id="cadastro-link">Cadastre-se</a>
            </label>
        </div>
        <button type="submit" class="btn btn-primary w-100">Entrar</button>
        <?php if ($erro): ?>
            <div class="login-error"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>
    </form>
</div>
<!-- Bootstrap JS (opcional) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
