<?php
session_start();
if (!isset($_SESSION['usuario_id']) || $_SESSION['tipo'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

require_once(__DIR__ . '/../../core/Database.class.php');
require_once(__DIR__ . '/../../models/ProgressoEstudo.class.php');

// Parâmetros do filtro (vêm da URL via GET)
$usuario_id = isset($_GET['usuario_id']) ? $_GET['usuario_id'] : '';
$material_id = isset($_GET['material_id']) ? $_GET['material_id'] : '';

// Filtro dinâmico
$filtros = [];
$tipo = 0;
$info = '';
if (!empty($usuario_id)) {
    $tipo = 2;
    $info = $usuario_id;
} elseif (!empty($material_id)) {
    $tipo = 3;
    $info = $material_id;
}

$dados = ProgressoEstudo::listar($tipo, $info);

// Buscar nomes para os selects
$conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
$usuarios = $conexao->query("SELECT id, nome FROM Usuarios WHERE tipo = 'aluno' ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
$materiais = $conexao->query("SELECT id, titulo FROM Materiais ORDER BY titulo")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Progresso dos Alunos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container py-4">
    <h1 class="h3 mb-4">Progresso de Estudo dos Alunos</h1>

    <a href="admin.php" class="btn btn-secondary mb-3">← Voltar ao Painel</a>

    <!-- Filtros -->
    <form method="get" class="row g-3 mb-4">
        <div class="col-md-5">
            <label class="form-label">Filtrar por Aluno:</label>
            <select name="usuario_id" class="form-select" onchange="this.form.submit()">
                <option value="">Todos os Alunos</option>
                <?php foreach ($usuarios as $u): ?>
                    <option value="<?= $u['id'] ?>" <?= $usuario_id == $u['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($u['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-5">
            <label class="form-label">Filtrar por Material:</label>
            <select name="material_id" class="form-select" onchange="this.form.submit()">
                <option value="">Todos os Materiais</option>
                <?php foreach ($materiais as $m): ?>
                    <option value="<?= $m['id'] ?>" <?= $material_id == $m['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($m['titulo']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-2 d-flex align-items-end">
            <a href="progresso.php" class="btn btn-outline-secondary w-100">Limpar Filtros</a>
        </div>
    </form>

    <!-- Tabela -->
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Aluno</th>
                    <th>Material</th>
                    <th>Progresso</th>
                    <th>Última Visualização</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($dados): ?>
                    <?php foreach ($dados as $d): ?>
                        <tr>
                            <td><?= $d['id'] ?></td>
                            <td><?= htmlspecialchars($d['nome_usuario']) ?></td>
                            <td><?= htmlspecialchars($d['titulo_material']) ?></td>
                            <td>
                                <div class="progress" style="height: 20px;">
                                    <div class="progress-bar" role="progressbar"
                                         style="width: <?= $d['percentual_concluido'] ?>%;"
                                         aria-valuenow="<?= $d['percentual_concluido'] ?>" aria-valuemin="0" aria-valuemax="100">
                                        <?= $d['percentual_concluido'] ?>%
                                    </div>
                                </div>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($d['ultima_visualizacao'])) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="5" class="text-center">Nenhum progresso encontrado.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

