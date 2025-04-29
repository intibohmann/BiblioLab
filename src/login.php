<?php
session_start(); // Inicia a sessão
include('head.php');
?>
<body>
<?php include('menu.php'); ?>

<h2>Login</h2>
<form action="login.php" method="POST">
    <label for="usuario">Usuário:</label>
    <input type="text" class="input is-small" id="usuario" name="usuario" required><br><br>

    <label for="senha_hash">Senha:</label>
    <input type="password" id="senha_hash" name="senha_hash" required><br><br>

    <input type="submit" value="Entrar">
</form>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $usuario = $_POST['usuario'];
    $senha_hash = $_POST['senha_hash'];

    // Conexão com o banco de dados
    $servername = "localhost";
    $dbUsername = "root";
    $dbPassword = "";
    $dbName = "biblioteca";

    $conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Falha na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consulta para verificar o usuário
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE usuario = ? AND senha_hash = ?");
    $stmt->bind_param("ss", $usuario, $senha_hash);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Login bem-sucedido
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id']; // Armazena o ID do usuário na sessão
        $_SESSION['usuario'] = $user['usuario']; // Armazena o nome de usuário na sessão
        header("Location: index.php");
        exit;
    } else {
        echo "<p style='color:red;'>Usuário ou senha inválidos.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

<?php include("rodape.php"); ?>
</body>
</html>
