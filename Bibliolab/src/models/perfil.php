<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

$servername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "biblioteca";
$conn = new mysqli($servername, $dbUsername, $dbPassword, $dbName);

$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT nome, email, usuario, foto_perfil FROM Usuarios WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$usuario = $result->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f3f3f3;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
        }

        .foto-perfil {
            text-align: center;
            margin-bottom: 20px;
        }

        .foto-perfil img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ccc;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-top: 10px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="file"] {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-top: 5px;
        }

        input[type="submit"] {
            margin-top: 20px;
            padding: 12px;
            background: #2575fc;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background: #1a5edb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Meu Perfil</h2>
        <div class="foto-perfil">
            <img src="<?= $usuario['foto_perfil'] ? 'uploads/' . $usuario['foto_perfil'] : 'uploads/default.png' ?>" alt="Foto de Perfil">
        </div>

        <form action="atualizar_perfil.php" method="POST" enctype="multipart/form-data">
            <label>Nome:</label>
            <input type="text" name="nome" value="<?= htmlspecialchars($usuario['nome']) ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($usuario['email']) ?>" required>

            <label>Nova senha (deixe em branco para não mudar):</label>
            <input type="password" name="nova_senha">

            <label>Foto de perfil:</label>
            <input type="file" name="foto">
            <?php if ($usuario['foto_perfil']): ?>
    <div style="margin-top: 12px;">
        <form action="remover_foto.php" method="POST">
            <input type="hidden" name="foto_atual" value="<?= $usuario['foto_perfil'] ?>">
            <button type="submit" style="background-color: #e53935; color: white; padding: 8px 12px; border: none; border-radius: 6px; cursor: pointer;">
                Remover Foto
            </button>
        </form>
    </div>
<?php endif; ?>
            <input type="submit" value="Atualizar Perfil">
        </form>
    </div>
</body>
</html>
