<?php
session_start(); // Inicia a sessão
include('head.php');
?>
<style>
    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #6a11cb, #2575fc);
        color: #fff;
    }

    form {
        background: rgba(255, 255, 255, 0.1);
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        animation: fadeIn 1s ease-in-out;
        width: 300px;
        text-align: center;
    }

    label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: none;
        border-radius: 5px;
        box-sizing: border-box;
    }

    input[type="submit"] {
        background: #2575fc;
        color: #fff;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    input[type="submit"]:hover {
        background: #6a11cb;
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
<body>
<?php include("Menu.php"); ?>

<form action="login.php" method="POST">
    <label for="usuario">Usuário:</label>
    <input type="text" class="input is-small" id="usuario" name="usuario" required>

    <label for="senha_hash">Senha:</label>
    <input type="password" id="senha_hash" name="senha_hash" required>

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
    $stmt = $conn->prepare("SELECT * FROM Usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Verifica a senha
        $user = $result->fetch_assoc();
        if (password_verify($senha_hash, $user['senha_hash'])) {
            // Login bem-sucedido
            $_SESSION['user_id'] = $user['id']; // Armazena o ID do usuário na sessão
            $_SESSION['usuario'] = $user['usuario']; // Armazena o nome de usuário na sessão
            header("Location: index.php");
            exit;
        } else {
            echo "<p style='color:red; text-align: center;'>Usuário ou senha inválidos.</p>";
        }
    } else {
        echo "<p style='color:red; text-align: center;'>Usuário ou senha inválidos.</p>";
    }

    $stmt->close();
    $conn->close();
}
?>

</body>
</html>
