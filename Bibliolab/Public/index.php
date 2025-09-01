<?php 
require_once '../Config/config.inc.php';
require_once '../App/Models/Biblioteca.class.php';
require_once '../App/Models/Favoritos.class.php';

session_start();

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");

try {
    $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "SELECT b.id, b.titulo, b.descricao, c.nome AS categoria
            FROM Biblioteca b
            LEFT JOIN Categorias c ON b.categoria_id = c.id
            ORDER BY b.id DESC
            LIMIT 10";
    
    $stmt = $conexao->query($sql);
    $bibliotecas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao conectar ou consultar o banco de dados: " . $e->getMessage();
    exit;
}

include "../App/views/layouts/head.php";
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliotecas Cadastradas</title>
    <link rel="stylesheet" href="css/idx.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Bibliotecas Cadastradas</h1>

        <?php if (isset($_SESSION['usuario_id'])): ?>
            <!-- Dropdown de cadastro -->
            <div class="dropdown">
                <button class="btn btn-outline-primary btn-lg dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-plus-circle"></i> Cadastros
                </button>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                    <li>
                        <a class="dropdown-item" href="../App/views/main/cadastro_material.php">
                            <i class="bi bi-file-earmark-plus"></i> Cadastrar Material
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="../App/views/main/cadastro_biblioteca.php">
                            <i class="bi bi-folder-plus"></i> Cadastrar Biblioteca
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="../App/views/main/cadastro_categoria.php">
                            <i class="bi bi-tags"></i> Cadastrar Categoria
                        </a>
                    </li>
                </ul>
            </div>
        <?php endif; ?>
    </div>

    <?php if (count($bibliotecas) > 0): ?>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            <?php foreach ($bibliotecas as $biblioteca): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($biblioteca['titulo']) ?></h5>
                            <p class="card-text small text-muted"><?= htmlspecialchars($biblioteca['descricao']) ?></p>
                            <span class="badge bg-info text-dark mb-3"><?= htmlspecialchars($biblioteca['categoria'] ?? 'Sem categoria') ?></span>

                            <div class="mt-auto">
                                <div class="d-grid gap-2">
                                    <a href="../App/views/biblioteca.php?id=<?= $biblioteca['id'] ?>" class="btn btn-outline-primary btn-sm">
                                        <i class="bi bi-folder2-open"></i> Abrir Biblioteca
                                    </a>
                                    <a href="chat_biblioteca.php?id=<?= $biblioteca['id'] ?>" class="btn btn-outline-secondary btn-sm">
                                        <i class="bi bi-chat-left-dots"></i> Chat da Biblioteca
                                    </a>
                                    <form method="post" action="../App/Controllers/favorito_controller.php">
                                        <input type="hidden" name="biblioteca_id" value="<?= $biblioteca['id'] ?>">
                                        <?php
                                            $favoritado = Favoritos::existe($_SESSION['usuario_id'], $biblioteca['id']);
                                            if ($favoritado):
                                        ?>
                                            <button type="submit" name="acao" value="remover" class="btn btn-danger btn-sm">
                                                <i class="bi bi-heartbreak"></i> Remover Favorito
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" name="acao" value="adicionar" class="btn btn-success btn-sm">
                                                <i class="bi bi-heart"></i> Favoritar
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>Nenhuma biblioteca cadastrada.</p>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

