<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] == 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

require_once(__DIR__ . '/../../core/Database.class.php');

$sql = "SELECT id, nome, usuario, email, tipo FROM Usuarios ORDER BY tipo DESC, nome ASC";
$stmt = Database::executar($sql);
$usuarios = $stmt ? $stmt->fetchAll() : [];
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador</title>
    <style>
        body {
            font-family: sans-serif;
            background-color: #f5f5f5;
            padding: 40px;
        }

        h1 { color: #333; }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
            background: #fff;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #2575fc;
            color: white;
        }

        a.button {
            background: #6a11cb;
            color: white;
            padding: 6px 12px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 0.9rem;
        }

        a.button:hover {
            background: #2575fc;
        }

        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
    </style>
</head>
<body>

<div class="top-bar">
    <h1>Painel do Administrador</h1>
    <div>
        Logado como: <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong> |
        <a href="../auth/logout.php">Sair</a>
    </div>
</div>

<h2>Usuários Cadastrados</h2>

<table>
    <tr>
        <th>ID</th>
        <th>Nome</th>
        <th>Usuário</th>
        <th>Email</th>
        <th>Tipo</th>
        <th>Ações</th>
    </tr>
    <?php foreach ($usuarios as $u): ?>
        <tr>
            <td><?= $u['id'] ?></td>
            <td><?= htmlspecialchars($u['nome']) ?></td>
            <td><?= htmlspecialchars($u['usuario']) ?></td>
            <td><?= htmlspecialchars($u['email']) ?></td>
            <td><?= $u['tipo'] ?></td>
            <td>
                <?php if ($u['tipo'] === 'aluno'): ?>
                    <a class="button" href="../../Controllers/promover.php?id=<?= $u['id'] ?>">Promover a Admin</a>
                <?php else: ?>
                    —
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h3>Relatórios Rápidos:</h3>
<ul>
    <li><a class="button" href="progresso.php">Ver Progresso de Estudo</a></li>
    <li><a class="button" href="favoritos.php">Ver Favoritos</a></li>
    <li><a class="button" href="avaliacoes.php">Ver Feedbacks/Avaliações</a></li>
</ul>

</body>
</html>

