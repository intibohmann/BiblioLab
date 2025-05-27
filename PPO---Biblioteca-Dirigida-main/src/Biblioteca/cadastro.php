<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro Biblioteca</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function exibirCamposMaterial() {
            const origem = document.getElementById("origem").value;
            document.getElementById("divUrl").style.display = origem === 'link' ? 'block' : 'none';
            document.getElementById("divArquivo").style.display = origem === 'arquivo' ? 'block' : 'none';
        }
        window.onload = exibirCamposMaterial;
    </script>
</head>

<body>
<nav style="background-color: #f8f9fa; padding: 20px; display: flex; justify-content: space-between; align-items: center;">
    <img src="../../img/logo.png" alt="Logo" style="width: 100px; height: auto;"> 
    <div style="font-size: 3em; font-weight: bold; color: black;">BiblioLab</div>
    <ul style="list-style: none; display: flex; gap: 30px; margin: 0; padding: 0;">
        <li><a href="../index.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Home</a></li>
        <li><a href="../sobre.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Sobre</a></li>
        <li><a href="../contato.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Contato</a></li>
        <li><a href="../cadastro.php"style="color: black; text-decoration: none; transition: color 0.3s ease;">Cadastre-se</a></li>
        <li><a href="../login.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Login</a></li>
    </ul>
</nav>
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
