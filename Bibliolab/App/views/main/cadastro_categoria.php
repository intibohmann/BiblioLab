<!DOCTYPE html>
<html lang="pt-br">
<?php include("../layouts/head.php"); ?>



<div class="container-fluid">
    <?php include("../layouts/MenuLateral.php"); ?>

    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <h1 class="mt-4 mb-4">Cadastrar Categoria</h1>

        <form action="../../Controllers/salvar_categoria.php" method="post" class="mb-4">
            <div class="mb-3">
                <label class="form-label">Nome:</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição:</label>
                <textarea name="descricao" class="form-control" required></textarea>
            </div>
            <button type="submit" class="btn btn-success">Salvar Categoria</button>
        </form>
    </main>
</div>

</body>
</html>

