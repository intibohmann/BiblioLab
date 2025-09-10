<?php
require_once '../../Config/config.inc.php';
require_once __DIR__ . '/../Models/Materiais.class.php';
require_once __DIR__ . '/../Models/Categorias.class.php';

if (!isset($_GET['id']) || !isset($_GET['bib_id'])) {
    echo "ID do material ou da biblioteca não fornecido.";
    exit;
}

$id = (int) $_GET['id'];
$bib_id = (int) $_GET['bib_id'];

$material = Materiais::buscarPorId($id);
if (!$material) {
    echo "Material não encontrado.";
    exit;
}

// Buscar categorias para o select
$conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
$stmt = $conexao->query("SELECT id, nome FROM Categorias ORDER BY nome");
$categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Material</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h1>Editar Material</h1>

    <form action="../Controllers/atualizar_material.php" method="POST">
        <input type="hidden" name="id" value="<?= $material['id'] ?>">
        <input type="hidden" name="bib_id" value="<?= $bib_id ?>">

        <div class="mb-3">
            <label class="form-label">Título</label>
            <input type="text" name="titulo" class="form-control" value="<?= htmlspecialchars($material['titulo']) ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descrição</label>
            <textarea name="descricao" class="form-control" rows="4"><?= htmlspecialchars($material['descricao']) ?></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tipo</label>
            <select name="tipo" class="form-select" required>
                <option value="video" <?= $material['tipo'] == 'video' ? 'selected' : '' ?>>Vídeo</option>
                <option value="ebook" <?= $material['tipo'] == 'ebook' ? 'selected' : '' ?>>E-book</option>
                <option value="artigo" <?= $material['tipo'] == 'artigo' ? 'selected' : '' ?>>Artigo</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">URL ou Caminho do Arquivo</label>
            <input type="text" name="url" class="form-control" value="<?= htmlspecialchars($material['url']) ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Categoria</label>
            <select name="categoria_id" class="form-select">
                <?php foreach ($categorias as $cat): ?>
                    <option value="<?= $cat['id'] ?>" <?= $material['categoria_id'] == $cat['id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat['nome']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
        <a href="biblioteca.php?id=<?= $bib_id ?>" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
