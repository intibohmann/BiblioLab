<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: /BiblioLab/Bibliolab/App/views/auth/login.php");
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
   
    <!-- Bootstrap 5 CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4"></div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3">Painel do Administrador</h1>
        <div>
            Logado como: <strong><?= htmlspecialchars($_SESSION['usuario']) ?></strong>
        </div>
    </div>

    <h2 class="h5 mb-3">Usuários Cadastrados</h2>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Usuário</th>
                    <th>Email</th>
                    <th>Tipo</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($usuarios as $u): ?>
                <tr>
                    <td><?= $u['id'] ?></td>
                    <td><?= htmlspecialchars($u['nome']) ?></td>
                    <td><?= htmlspecialchars($u['usuario']) ?></td>
                    <td><?= htmlspecialchars($u['email']) ?></td>
                    <td>
                        <span class="badge <?= $u['tipo'] === 'admin' ? 'bg-primary' : 'bg-secondary' ?>">
                            <?= $u['tipo'] ?>
                        </span>
                    </td>
                    <td>
                        <?php if ($u['tipo'] === 'aluno'): ?>
                            <a class="btn btn-success btn-sm" href="../../Controllers/promover.php?id=<?= $u['id'] ?>">Promover a Admin</a>
                        <?php else: ?>
                            <span class="text-muted">—</span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <h3 class="h6 mt-5 mb-3">Relatórios Rápidos:</h3>
    <div class="d-flex gap-2 flex-wrap">
        <a class="btn btn-info" href="progresso.php">Ver Progresso de Estudo</a>
        <a class="btn btn-warning" href="favoritos.php">Ver Favoritos</a>
        <a class="btn btn-secondary" href="avaliacoes.php">Ver Feedbacks/Avaliações</a>
        <a class="btn btn-primary" href="../../../Public/index.php">Voltar ao inicio</a>
    </div>
</div>

<!-- Bootstrap JS (optional, for some components) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

