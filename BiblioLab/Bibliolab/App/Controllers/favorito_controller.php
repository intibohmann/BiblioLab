<?php
session_start();
require_once '../../Config/config.inc.php';
require_once '../Models/Favoritos.class.php';

if (!isset($_SESSION['usuario_id']) || !isset($_POST['biblioteca_id']) || !isset($_POST['acao'])) {
    header("Location: ../../public/index.php");
    exit;
}

$usuario_id = $_SESSION['usuario_id'];
$biblioteca_id = (int) $_POST['biblioteca_id'];
$acao = $_POST['acao'];

$favorito = new Favoritos($usuario_id, $biblioteca_id);

if ($acao === 'adicionar') {
    $favorito->inserir();
} elseif ($acao === 'remover') {
    $favorito->excluir();
}

header("Location: ../../public/index.php");
exit;

