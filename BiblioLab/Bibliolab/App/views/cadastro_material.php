<?php
require_once("../Models/Materiais.class.php");
require_once("../Models/Categorias.class.php");
require_once("../Models/Biblioteca.class.php");

// Recebe o ID do material (para edição)
$material = null;
if (isset($_GET['id'])) {
    $idMaterial = (int) $_GET['id'];
    $material = Materiais::buscarPorId($idMaterial);
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<?php include("layouts/head.php"); ?>

<script>
function exibirCamposMaterial() {
    const origem = document.getElementById("origem")?.value;
    document.getElementById("divUrl").style.display = origem === 'link' ? 'block' : 'none';
    document.getElementById("divArquivo").style.display = origem === 'arquivo' ? 'block' : 'none';
}
window.onload = exibirCamposMaterial;

function validarForm(event) {
    const tipo = document.querySelector('select[name="tipo"]').value;
    const origem = document.getElementById("origem").value;

    if (origem === "arquivo" && tipo === "video") {
        alert("Não é permitido cadastrar um arquivo PDF com o tipo 'Vídeo'. Escolha 'E-book' ou 'Artigo'.");
        event.preventDefault();
        return false;
    }
    return true;
}
</script>

<body>
    <div class="container-fluid">
        <!-- layouts/MenuLateral.php -->
    <div class="d-flex">
    <!-- Sidebar -->
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
        <div class="position-sticky pt-3">
        <ul class="nav flex-column">
            <li class="nav-item mb-2">
            <a class="nav-link btn btn-outline-primary w-100" href="main/cadastro_categoria.php">
                Cadastrar Categoria
            </a>
            </li>
            <li class="nav-item mb-2">
            <a class="nav-link btn btn-outline-primary w-100" href="main/cadastro_biblioteca.php">
                Cadastrar Biblioteca
            </a>
            </li>
            <li class="nav-item mb-2">
            <a class="nav-link btn btn-outline-primary w-100" href="cadastro_material.php">
                Cadastrar Material
            </a>
            </li>
            <li class="nav-item mt-4">
            <a class="nav-link btn btn-outline-secondary w-100" href="/BiblioLab/Bibliolab/Public/index.php">
                Voltar ao Início
            </a>
            </li>
        </ul>
        </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">


    
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="mt-4 mb-4"><?= $material ? "Editar Material" : "Cadastrar Material" ?></h1>

        <form action="../Controllers/salvar_material.php" method="post" enctype="multipart/form-data" class="mb-4" onsubmit="return validarForm(event)">
            <?php if ($material): ?>
                <input type="hidden" name="id" value="<?= $material['id'] ?>">
            <?php endif; ?>

            <div class="mb-3">
                <label class="form-label">Título:</label>
                <input type="text" name="titulo" class="form-control" required
                       value="<?= htmlspecialchars($material['titulo'] ?? '') ?>">
            </div>

            <div class="mb-3">
                <label class="form-label">Descrição:</label>
                <textarea name="descricao" class="form-control" required><?= htmlspecialchars($material['descricao'] ?? '') ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tipo:</label>
                <select name="tipo" class="form-select" required>
                    <option value="video" <?= isset($material['tipo']) && $material['tipo'] === 'video' ? 'selected' : '' ?>>Vídeo</option>
                    <option value="ebook" <?= isset($material['tipo']) && $material['tipo'] === 'ebook' ? 'selected' : '' ?>>E-book</option>
                    <option value="artigo" <?= isset($material['tipo']) && $material['tipo'] === 'artigo' ? 'selected' : '' ?>>Artigo</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Origem do Material:</label>
                <select name="origem" id="origem" class="form-select" onchange="exibirCamposMaterial()" required>
                    <option value="link" <?= isset($material['url']) && filter_var($material['url'], FILTER_VALIDATE_URL) ? 'selected' : '' ?>>Link</option>
                    <option value="arquivo" <?= isset($material['url']) && !filter_var($material['url'], FILTER_VALIDATE_URL) ? 'selected' : '' ?>>Arquivo PDF</option>
                </select>
            </div>

            <div class="mb-3" id="divUrl">
                <label class="form-label">URL (link):</label>
                <input type="url" name="url" class="form-control" placeholder="https://exemplo.com/material"
                       value="<?= isset($material['url']) && filter_var($material['url'], FILTER_VALIDATE_URL) ? htmlspecialchars($material['url']) : '' ?>">
            </div>

            <div class="mb-3" id="divArquivo" style="display:none;">
                <label class="form-label">Arquivo PDF (upload):</label>
                <input type="file" name="arquivo_pdf" class="form-control" accept="application/pdf">
                <?php if ($material && isset($material['url']) && !filter_var($material['url'], FILTER_VALIDATE_URL)): ?>
                    <p>Arquivo atual: <a href="<?= htmlspecialchars($material['url']) ?>" target="_blank">Clique para abrir</a></p>
                <?php endif; ?>
            </div>

            <div class="mb-3">
                <label class="form-label">Categoria:</label>
                <select name="categoria_id" class="form-select" required>
                    <?php
                    $categorias = Categoria::listar();
                    foreach ($categorias as $c) {
                        $selected = isset($material['categoria_id']) && $material['categoria_id'] == $c['id'] ? 'selected' : '';
                        echo "<option value='{$c['id']}' $selected>{$c['nome']}</option>";
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Biblioteca:</label>
                <select name="biblioteca_id" class="form-select" required>
                    <?php
                    $bibliotecas = Biblioteca::listar();
                    foreach ($bibliotecas as $b) {
                        $selected = isset($material['biblioteca_id']) && $material['biblioteca_id'] == $b['id'] ? 'selected' : '';
                        echo "<option value='{$b['id']}' $selected>{$b['titulo']}</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-warning"><?= $material ? "Atualizar Material" : "Salvar Material" ?></button>
        </form>
    </main>
</div>
</body>
</html>
