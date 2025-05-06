<?php include('menu.php'); ?>
<?php include('head.php'); ?>
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
    input[type="password"],
    input[type="email"],
    input[type="submit"],
    input[type="button"], {
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
        background:rgb(0, 0, 0);
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
    <div class="form-container">
        <h2>Cadastro</h2>
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
            die("<p class='error-message'>Erro na conexão com o banco de dados: " . $conn->connect_error . "</p>");
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
                echo "<p class='error-message'>Todos os campos são obrigatórios.</p>";
            } elseif ($senha !== $confirmar_senha) {
                echo "<p class='error-message'>As senhas não coincidem.</p>";
            } else {
                // Hash da senha
                $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

                // Prepara a consulta SQL
                $stmt = $conn->prepare("INSERT INTO Usuarios (nome, email, usuario, senha_hash) VALUES (?, ?, ?, ?)");
                $stmt->bind_param("ssss", $nome, $email, $usuario, $senha_hash);

                // Executa a consulta
                if ($stmt->execute()) {
                    echo "<p class='success-message'>Cadastro realizado com sucesso!</p>";
                } else {
                    echo "<p class='error-message'>Erro ao cadastrar: " . $stmt->error . "</p>";
                }

                // Fecha o statement
                $stmt->close();
            }
        }

        // Fecha a conexão
        $conn->close();
        ?>
        <form method="POST" action="">
            <label for="nome">Nome:</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail:</label>
            <input type="email" id="email" name="email" required>

            <label for="usuario">Usuário:</label>
            <input type="text" id="usuario" name="usuario" required>

            <label for="senha">Senha:</label>
            <input type="password" id="senha" name="senha" required>

            <label for="confirmar_senha">Confirmar Senha:</label>
            <input type="password" id="confirmar_senha" name="confirmar_senha" required>

            <button type="submit">Cadastrar</button>
        </form>
    </div>
</body>
</html>
<?php include("rodape.php"); ?>