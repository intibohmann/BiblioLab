
<?php
require_once("../../Models/Materiais.class.php");

try {
    $materiais = new Materiais(null, $_POST['titulo'], $_POST['descricao'], $_POST['tipo'],  $_POST['URL'], );
    if ($materiais->inserir()) {
        echo "materiais cadastrado com sucesso!";
        header("Location: index.php");

    } else {
        echo "Erro ao cadastrar materiais.";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
?>