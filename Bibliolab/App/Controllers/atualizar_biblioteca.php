<?php
require_once '../../Config/config.inc.php';
require_once __DIR__ . '/../Models/Biblioteca.class.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Método inválido.");
}

$id = (int) $_POST['id'];
$titulo = trim($_POST['titulo']);
$descricao = trim($_POST['descricao']);
$categoria_id = (int) $_POST['categoria_id'];

try {
    $biblioteca = new Biblioteca($id, $titulo, $descricao, $categoria_id);
    $resultado = $biblioteca->alterar();

    if ($resultado) {
        header("Location: ../Views/biblioteca.php?id=$id&msg=Biblioteca atualizada com sucesso!");
        exit;
    } else {
        echo "<div class='alert alert-danger'>Falha ao atualizar a biblioteca.</div>";
    }
} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
}
