<?php
require_once("../../Models/Biblioteca.class.php");

try {
    $biblioteca = new Biblioteca(null, $_POST['titulo'], $_POST['descricao'], $_POST['categoria_id']);
    if ($biblioteca->inserir()) {
        echo "Biblioteca cadastrada com sucesso!";
        header("Location: index.php");

    } else {
        echo "Erro ao cadastrar biblioteca.";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
