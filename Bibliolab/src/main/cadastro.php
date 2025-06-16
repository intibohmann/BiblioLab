<!DOCTYPE html>
<html lang="pt-br">
<?php
    include("../models/head.php");
?>

    <script>
        function exibirCamposMaterial() {
            const origem = document.getElementById("origem").value;
            document.getElementById("divUrl").style.display = origem === 'link' ? 'block' : 'none';
            document.getElementById("divArquivo").style.display = origem === 'arquivo' ? 'block' : 'none';
        }
        window.onload = exibirCamposMaterial;
    </script>


<body>
<?php

include ("../models/Menu.php");
?>
<br>
</body>
<body class="bg-light">
    
    <div class="container mt-4">
        <h1 class="mb-4">Sistema Biblioteca</h1>

        <!-- CATEGORIA -->
        <div class="card mb-4">
            <div class="card-header">Cadastrar Categoria</div>
            <div class="card-body">
                <form action="salvar_categoria.php" method="post">
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
            </div>
        </div>

        <!-- BIBLIOTECA -->
        <div class="card mb-4">
            <div class="card-header">Cadastrar Biblioteca</div>
            <div class="card-body">
                <form action="salvar_biblioteca.php" method="post">
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
                            require_once("../Class/Categorias.class.php");
                            $categorias = Categoria::listar();
                            foreach ($categorias as $c) {
                                echo "<option value='{$c['id']}'>{$c['nome']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Salvar Biblioteca</button>
                </form>
            </div>
        </div>
    <!-- MATERIAL -->
    <div class="card mb-4">
        <div class="card-header">Cadastrar Material</div>
        <div class="card-body">
            <form action="salvar_material.php" method="post">
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
                        <option value="texto">Texto</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">URL (link):</label>
                    <input type="text" name="url" class="form-control" required placeholder="https://exemplo.com/material">
                </div>
                <div class="mb-3">
                    <label class="form-label">Categoria:</label>
                    <select name="categoria_id" class="form-select" required>
                        <?php
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
                        require_once("../Class/Biblioteca.class.php");
                        $bibliotecas = Biblioteca::listar();
                        foreach ($bibliotecas as $b) {
                            echo "<option value='{$b['id']}'>{$b['titulo']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-warning">Salvar Material</button>
            </form>
        </div>
    </div>

</body>
</html>
