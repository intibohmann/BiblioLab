<?php
require_once("../Class/Categorias.class.php");
try {
    $categoria = new Categoria(null, $_POST['nome'], $_POST['descricao']);
    $categoria->inserir();
    header("Location: ../inicio/index.php");
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
