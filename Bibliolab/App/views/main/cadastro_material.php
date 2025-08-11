<!DOCTYPE html>
<html lang="pt-br">
<?php include("../layouts/head.php"); ?>

<script>
    function exibirCamposMaterial() {
        const origem = document.getElementById("origem")?.value;
        if (document.getElementById("divUrl")) {
            document.getElementById("divUrl").style.display = origem === 'link' ? 'block' : 'none';
        }
        if (document.getElementById("divArquivo")) {
            document.getElementById("divArquivo").style.display = origem === 'arquivo' ? 'block' : 'none';
        }
    }
    window.onload = exibirCamposMaterial;
</script>

<div class="container-fluid">
    <?php include("../layouts/MenuLateral.php"); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="mt-4 mb-4">Cadastrar Material</h1>

        <form action="../../Controllers/salvar_material.php" method="post" class="mb-4">
            <div class="mb-3">
                <label class="form-label">Título:</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição:</label>
                <textarea name="descricao" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Tipo:</label>
                <select name="tipo" class="form-select" required>
                    <option value="video">Vídeo</option>
                    <option value="ebook">E-book</option>
                    <option value="artigo">Artigo</option>
                </select>
            </div>
            <div class="mb-3" id="divUrl">
                <label class="form-label">URL (link):</label>
                <input type="text" name="url" class="form-control" placeholder="https://exemplo.com/material">
            </div>
            <div class="mb-3" id="divArquivo" style="display:none;">
                <label class="form-label">Arquivo (upload):</label>
                <input type="file" name="arquivo" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Categoria:</label>
                <select name="categoria_id" class="form-select" required>
                    <?php
                    require_once("../../Models/Categoria.class.php");
                    $categorias = Categoria::listar();
                    foreach ($categorias as $c) {
                        echo "<option value='{$c['id']}'>{$c['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Biblioteca:</label>
                <select name="biblioteca_id" class="form-select" required>
                    <?php
                    require_once("../../Models/Biblioteca.class.php");
                    $bibliotecas = Biblioteca::listar();
                    foreach ($bibliotecas as $b) {
                        echo "<option value='{$b['id']}'>{$b['titulo']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-warning">Salvar Material</button>
        </form>
    </main>
</div>

</body>
</html>
