<?php
require_once '../../Config/config.inc.php';
require_once __DIR__ . '/../Models/Materiais.class.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Método inválido.";
    exit;
}

$id = (int) $_POST['id'];
$bib_id = (int) $_POST['bib_id'];

try {
    $material = new Materiais(
        $id,
        $_POST['titulo'],
        $_POST['descricao'],
        $_POST['tipo'],
        $_POST['url'],
        $_POST['categoria_id'],
        $bib_id
    );

    if ($material->alterar()) {
        header("Location: ../Views/biblioteca.php?id=" . $bib_id);
        exit;
    } else {
        echo "Erro ao atualizar material.";
    }
} catch (Exception $e) {
    echo "Erro: " . $e->getMessage();
}
