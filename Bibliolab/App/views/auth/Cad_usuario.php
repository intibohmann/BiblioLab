<?php
include '../layouts/head.php';
?>
<body class="bg-gradient" style="background: linear-gradient(135deg, #6a11cb, #2575fc); min-height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="w-100" style="max-width: 400px;">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Cadastro</h2>
                    <?php if (!empty($mensagem)) echo $mensagem; ?>
                    <form method="POST" action="./../../App/controllers/cadastro_perfil.php">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome:</label>
                            <input type="text" id="nome" name="nome" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail:</label>
                            <input type="email" id="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="usuario" class="form-label">Usuário:</label>
                            <input type="text" id="usuario" name="usuario" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha:</label>
                            <input type="password" id="senha_hash" name="senha_hash" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirmar_senha" class="form-label">Confirmar Senha:</label>
                            <input type="password" id="confirmar_senha" name="confirmar_senha" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Cadastrar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>

