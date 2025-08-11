<?php
require_once '../../Config/config.inc.php';
require_once '../../App/Models/Biblioteca.class.php';
require_once '../../App/Models/Material.class.php';

session_start();

if (!isset($_GET['id'])) {
    echo "ID da biblioteca não fornecido.";
    exit;
}

$id = (int) $_GET['id'];

try {
    $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buscar dados da biblioteca
    $sqlBib = "SELECT b.id, b.titulo, b.descricao, c.nome AS categoria
               FROM Biblioteca b
               LEFT JOIN Categorias c ON b.categoria_id = c.id
               WHERE b.id = :id";
    $stmtBib = $conexao->prepare($sqlBib);
    $stmtBib->execute(['id' => $id]);
    $biblioteca = $stmtBib->fetch(PDO::FETCH_ASSOC);

    if (!$biblioteca) {
        echo "Biblioteca não encontrada.";
        exit;
    }

    // Buscar materiais vinculados à biblioteca (ajuste o nome da tabela e coluna)
    $sqlMat = "SELECT id, titulo, descricao FROM Materiais WHERE biblioteca_id = :id ORDER BY id DESC";
    $stmtMat = $conexao->prepare($sqlMat);
    $stmtMat->execute(['id' => $id]);
    $materiais = $stmtMat->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao consultar o banco de dados: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($biblioteca['titulo']) ?> - Biblioteca</title>
    <link rel="stylesheet" href="../../Public/css/idx.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
</head>
<body class="bg-light">

<div class="container mt-4">
    <a href="../../Public/index.php" class="btn btn-secondary mb-3"><i class="bi bi-arrow-left"></i> Voltar</a>

    <h1><?= htmlspecialchars($biblioteca['titulo']) ?></h1>
    <p><em><?= htmlspecialchars($biblioteca['categoria'] ?? 'Sem categoria') ?></em></p>
    <p><?= nl2br(htmlspecialchars($biblioteca['descricao'])) ?></p>

    <hr>

    <h3>Materiais</h3>

    <?php if (count($materiais) > 0): ?>
        <ul class="list-group">
            <?php foreach ($materiais as $material): ?>
                <li class="list-group-item">
                    <strong><?= htmlspecialchars($material['titulo']) ?></strong><br>
                    <small class="text-muted"><?= htmlspecialchars($material['descricao']) ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p>Não há materiais cadastrados para esta biblioteca.</p>
    <?php endif; ?>
</div>

</body>
</html>
