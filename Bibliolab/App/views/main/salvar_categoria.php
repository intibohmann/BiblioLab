<?php
require_once("../../Models/Categorias.class.php");
try {
    $categoria = new Categoria(null, $_POST['nome'], $_POST['descricao']);
    $categoria->inserir();
    header("Location: index.php");
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
