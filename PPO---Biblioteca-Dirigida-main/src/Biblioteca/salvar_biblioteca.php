<?php
require_once("../Class/Biblioteca.class.php");

try {
    $biblioteca = new Biblioteca(null, $_POST['titulo'], $_POST['descricao'], $_POST['categoria_id']);
    if ($biblioteca->inserir()) {
        echo "Biblioteca cadastrada com sucesso!";
    } else {
        echo "Erro ao cadastrar biblioteca.";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>
