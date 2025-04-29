<?php include('head.php'); ?>
<body>
<?php include('menu.php'); ?>
<?php
// Configuração do banco de dados
$host = 'localhost';
$dbname = 'biblioteca';
$user = 'root';
$password = '';

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Processa o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Validação de dados
    if (empty($nome) || empty($email) || empty($usuario) || empty($senha) || empty($confirmar_senha)) {
        echo "<p>Todos os campos são obrigatórios.</p>";
    } elseif ($senha !== $confirmar_senha) {
        echo "<p>As senhas não coincidem.</p>";
    } else {
        // Hash da senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

        // Prepara a consulta SQL
        $stmt = $conn->prepare("INSERT INTO Usuarios (nome, email, usuario, senha_hash) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $nome, $email, $usuario, $senha_hash);

        // Executa a consulta
        if ($stmt->execute()) {
            echo "<p>Cadastro realizado com sucesso!</p>";
        } else {
            echo "<p>Erro ao cadastrar: " . $stmt->error . "</p>";
        }

        // Fecha o statement
        $stmt->close();
    }
}

// Fecha a conexão
$conn->close();
?>
    <form method="POST" action="">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="usuario">Usuário:</label><br>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>

        <label for="confirmar_senha">Confirmar Senha:</label><br>
        <input type="password" id="confirmar_senha" name="confirmar_senha" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>

<?php include("rodape.php"); ?>
</body>