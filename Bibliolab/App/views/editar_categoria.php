<?php
require_once __DIR__ . '/../Models/Categorias.class.php';
require_once __DIR__ . '/../../Config/config.inc.php';
session_start();

try {
    $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Buscar todas as categorias
    $sql = "SELECT * FROM Categorias";
    $stmt = $conexao->query($sql);
    $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
    exit;
}

// Se enviou o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = (int)$_POST['id'];
    $nome = $_POST['nome'] ?? '';
    $descricao = $_POST['descricao'] ?? '';

    try {
        $cat = new Categoria($id, $nome, $descricao);
        if ($cat->alterar()) {
            echo "<div class='alert alert-success'>Categoria atualizada com sucesso!</div>";
            header("Location: /BiblioLab/Bibliolab/Public/index.php");
            // Atualiza a lista de categorias
            $stmt = $conexao->query("SELECT * FROM Categorias");
            $categorias = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } else {
            echo "<div class='alert alert-danger'>Erro ao atualizar categoria.</div>";
        }
    } catch (Exception $e) {
        echo "<div class='alert alert-danger'>Erro: {$e->getMessage()}</div>";
    }
}

// Se veio para editar uma categoria específica
$editarCategoria = null;
if (isset($_GET['editar'])) {
    $editarId = (int)$_GET['editar'];
    foreach ($categorias as $c) {
        if ($c['id'] == $editarId) {
            $editarCategoria = $c;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerenciar Categorias</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Categorias Cadastradas</h2>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome</th>
                <th>Descrição</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($categorias as $categoria): ?>
                <tr>
                    <td><?= $categoria['id'] ?></td>
                    <td><?= htmlspecialchars($categoria['nome']) ?></td>
                    <td><?= htmlspecialchars($categoria['descricao']) ?></td>
                    <td>
                        <a href="?editar=<?= $categoria['id'] ?>" class="btn btn-sm btn-primary">Editar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php if ($editarCategoria): ?>
        <div class="card shadow border-0 mt-5">
            <div class="card-body">
                <h2 class="mb-4">Editar Categoria: <?= htmlspecialchars($editarCategoria['nome']) ?></h2>
                <form method="post">
                    <input type="hidden" name="id" value="<?= $editarCategoria['id'] ?>">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($editarCategoria['nome']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($editarCategoria['descricao']) ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-success">Salvar Alterações</button>
                    <a href="/BiblioLab/Bibliolab/Public/index.php" class="btn btn-secondary">Cancelar</a>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

</body>
</html>
