<!DOCTYPE html>
<html lang="pt-br">
<?php include("../layouts/head.php"); ?>
<div class="container-fluid">
    <?php include("../layouts/MenuLateral.php"); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="mt-4 mb-4">Cadastrar Biblioteca</h1>

        <form action="../../Controllers/salvar_biblioteca.php" method="post" class="mb-4">
            <div class="mb-3">
                <label class="form-label">Título:</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição:</label>
                <textarea name="descricao" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Categoria:</label>
                <select name="categoria_id" class="form-select" required>
                    <?php
                    require_once("../../Models/Categorias.class.php");
                    $categorias = Categoria::listar();
                    foreach ($categorias as $c) {
                        echo "<option value='{$c['id']}'>{$c['nome']}</option>";
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Salvar Biblioteca</button>
        </form>
    </main>
</div>
</body>
</html>
