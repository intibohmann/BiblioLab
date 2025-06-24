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
            die("<div class='login-error'>Falha na conexão com o banco de dados.</div>");
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
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['usuario'] = $user['usuario'];
                header("Location: index.php");
                exit;
            } else {
                echo "<div class='login-error'>Usuário ou senha inválidos.</div>";
            }
        } else {
            echo "<div class='login-error'>Usuário ou senha inválidos.</div>";
        }

        $stmt->close();
        $conn->close();
    }
?>