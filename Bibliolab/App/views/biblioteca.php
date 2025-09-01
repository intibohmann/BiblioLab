<?php
require_once '../../Config/config.inc.php';
require_once __DIR__ . '/../Models/Materiais.class.php';
require_once __DIR__ . '/../Models/Biblioteca.class.php';
session_start();

if (!isset($_GET['id'])) {
    echo "ID da biblioteca não fornecido.";
    exit;
}

$id = (int) $_GET['id'];

try {
    $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

    $sqlMat = "SELECT id, titulo, descricao, tipo, url, categoria_id, biblioteca_id 
               FROM Materiais 
               WHERE biblioteca_id = :id 
               ORDER BY id DESC";
    $stmtMat = $conexao->prepare($sqlMat);
    $stmtMat->execute(['id' => $id]);
    $materiais = $stmtMat->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    echo "Erro ao consultar o banco de dados: " . $e->getMessage();
    exit;
}

function youtubeEmbedUrl($url) {
    if (strpos($url, 'youtube.com/embed/') !== false) {
        return $url;
    }
    if (preg_match('%(?:youtube\.com/watch\?v=|youtu\.be/)([a-zA-Z0-9_-]{11})%', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }
    return $url;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title><?= htmlspecialchars($biblioteca['titulo']) ?> - Biblioteca</title>
    <link rel="stylesheet" href="../../Public/css/idx.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
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
        <div id="carouselMateriais" class="carousel slide" data-bs-ride="carousel" style="max-width: 800px;">
            <div class="carousel-inner">
                <?php foreach ($materiais as $index => $material): ?>
                    <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($material['titulo']) ?></h5>
                                <p class="card-text"><?= nl2br(htmlspecialchars($material['descricao'])) ?></p>

                                <?php
                                $tipo = $material['tipo'];
                                $url = $material['url'];
                                ?>

                                <?php if ($tipo === 'video'): 
                                    $embedUrl = youtubeEmbedUrl($url);
                                ?>
                                    <div class="ratio ratio-16x9">
                                        <iframe src="<?= htmlspecialchars($embedUrl) ?>" title="<?= htmlspecialchars($material['titulo']) ?>" allowfullscreen></iframe>
                                    </div>

                                <?php elseif ($tipo === 'ebook' || $tipo === 'artigo'): ?>
                                    <?php if (filter_var($url, FILTER_VALIDATE_URL)): ?>
                                        <a href="<?= htmlspecialchars($url) ?>" target="_blank" class="btn btn-primary mt-3">Abrir material</a>
                                    <?php else: ?>
                                        <p><em>Arquivo disponível:</em> <a href="../../Public/<?= htmlspecialchars($url) ?>" target="_blank">Clique para abrir</a></p>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p>Tipo de material desconhecido.</p>
                                <?php endif; ?>

                                <!-- Botões Editar / Excluir -->
                                <div class="mt-3">
                                    <a href="../Views/cadastro_material.php?id=<?= $material['id'] ?>" 
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i> Editar
                                    </a>
                                    <a href="../Controllers/excluir_material.php?id=<?= $material['id'] ?>&bib_id=<?= $id ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Tem certeza que deseja excluir este material?')">
                                        <i class="bi bi-trash"></i> Excluir
                                    </a>
                                </div>

                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#carouselMateriais" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselMateriais" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Próximo</span>
            </button>
        </div>
    <?php else: ?>
        <p>Não há materiais cadastrados para esta biblioteca.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
