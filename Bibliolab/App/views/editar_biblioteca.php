<?php
require_once '../../Config/config.inc.php';
require_once __DIR__ . '/../Models/Biblioteca.class.php';

if (!isset($_GET['id'])) {
    echo "<div class='alert alert-danger'>ID da biblioteca não fornecido.</div>";
    exit;
}

$id = (int) $_GET['id'];
$biblioteca = Biblioteca::buscarPorId($id);

if (!$biblioteca) {
    echo "<div class='alert alert-danger'>Biblioteca não encontrada.</div>";
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="card shadow border-0">
        <div class="card-body">
            <h2 class="mb-4">Editar Biblioteca</h2>
            <form action="../Controllers/atualizar_biblioteca.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($biblioteca['id']) ?>">

                <div class="mb-3">
                    <label class="form-label fw-bold">Título</label>
                    <input type="text" name="titulo" class="form-control" 
                           value="<?= htmlspecialchars($biblioteca['titulo']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="4" required><?= htmlspecialchars($biblioteca['descricao']) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Categoria</label>
                    <select name="categoria_id" class="form-select" required>
                        <?php
                        try {
                            $pdo = new PDO(DSN, DB_USER, DB_PASSWORD);
                            $stmt = $pdo->query("SELECT id, nome FROM Categorias ORDER BY nome");
                            while ($cat = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                $selected = $cat['id'] == $biblioteca['categoria_id'] ? 'selected' : '';
                                echo "<option value='{$cat['id']}' $selected>" . htmlspecialchars($cat['nome']) . "</option>";
                            }
                        } catch (PDOException $e) {
                            echo "<option disabled>Erro ao carregar categorias</option>";
                        }
                        ?>
                    </select>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg">💾 Salvar Alterações</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>
