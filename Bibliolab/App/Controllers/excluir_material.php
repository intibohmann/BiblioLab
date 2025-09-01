<?php
require_once '../../Config/config.inc.php';

if (!isset($_GET['id']) || !isset($_GET['bib_id'])) {
    die("Parâmetros inválidos.");
}

$id = (int) $_GET['id'];
$bib_id = (int) $_GET['bib_id'];

try {
    $pdo = new PDO(DSN, DB_USER, DB_PASSWORD);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stmt = $pdo->prepare("DELETE FROM Materiais WHERE id = :id");
    $stmt->execute(['id' => $id]);

    header("Location: ../views/biblioteca.php?id={$bib_id}");
    exit;

} catch (PDOException $e) {
    die("Erro ao excluir material: " . $e->getMessage());
}
