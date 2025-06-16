<?php
include('menu.php');
include('head.php');

// Conexão com o banco de dados (ajuste os dados conforme necessário)
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'biblioteca';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Erro de conexão: " . $conn->connect_error);
}

$mensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $conn->real_escape_string($_POST['nome']);
    $email = $conn->real_escape_string($_POST['email']);
    $usuario = $conn->real_escape_string($_POST['usuario']);
    $senha_hash = $_POST['senha_hash'];
    $confirmar_senha = $_POST['confirmar_senha'];

    if ($senha_hash !== $confirmar_senha) {
        $mensagem = '<div class="alert alert-danger">As senhas não coincidem.</div>';
    } else {
        // Verifica se o usuário já existe
        $sql = "SELECT id FROM usuarios WHERE usuario = '$usuario' OR email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $mensagem = '<div class="alert alert-warning">Usuário ou e-mail já cadastrado.</div>';
        } else {
            $senha_hash = password_hash($senha_hash, PASSWORD_DEFAULT);
            $sql = "INSERT INTO usuarios (nome, email, usuario, senha_hash) VALUES ('$nome', '$email', '$usuario', '$senha_hash')";
            if ($conn->query($sql) === TRUE) {
                $mensagem = '<div class="alert alert-success">Cadastro realizado com sucesso!</div>';
            } else {
                $mensagem = '<div class="alert alert-danger">Erro ao cadastrar: ' . $conn->error . '</div>';
            }
        }
    }
}
?>
<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<body class="bg-gradient" style="background: linear-gradient(135deg, #6a11cb, #2575fc); min-height: 100vh;">
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 100vh;">
        <div class="w-100" style="max-width: 400px;">
            <div class="card shadow-lg">
                <div class="card-body">
                    <h2 class="card-title text-center mb-4">Cadastro</h2>
                    <?php if (!empty($mensagem)) echo $mensagem; ?>
                    <form method="POST" action="">
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

