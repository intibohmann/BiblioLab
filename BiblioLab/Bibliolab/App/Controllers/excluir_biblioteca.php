<?php
require_once __DIR__ . '/../Models/Biblioteca.class.php';
require_once __DIR__ . '/../../Config/config.inc.php';

session_start();

// Verifica se o ID foi passado
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: ../views/biblioteca.php?erro=1");
    exit;
}

$id = (int) $_GET['id'];

try {
    $biblioteca = new Biblioteca();
    $biblioteca->setId($id);

    if ($biblioteca->excluir()) {
        // Depois de excluir, volta para a listagem geral (index ou outro lugar)
        header("Location: /BiblioLab/Bibliolab/Public/index.php?msg=Biblioteca excluída com sucesso");
    } else {
        header("Location: ../views/biblioteca.php?id=" . $id . "&erro=2");
    }
    exit;

} catch (Exception $e) {
    header("Location: ../views/biblioteca.php?id=" . $id . "&erro=3&msg=" . urlencode($e->getMessage()));
    exit;
}
