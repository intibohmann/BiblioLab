
<?php
// Conexão com o banco de dados
require_once '../App/Models/Biblioteca.class.php';


try {
    $conexao = new PDO(DSN, username: DB_USER, password: DB_PASSWORD);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para listar as bibliotecas
    $sql = "SELECT * FROM Biblioteca";
    $stmt = $conexao->query($sql);
    $bibliotecas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao conectar ou consultar o banco de dados: " . $e->getMessage();
    exit;
}
include "../App/views/layouts/head.php";
include "../App/views/layouts/Menu.php";
?>

<!DOCTYPE html>
<html lang="pt-br">

<body class="bg-light">
    <div class="container mt-4">
        <h1 class="mb-4">Bibliotecas Cadastradas</h1>

        <?php if (count($bibliotecas) > 0): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Título</th>
                        <th>Descrição</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bibliotecas as $biblioteca): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($biblioteca['id']); ?></td>
                            <td><?php echo htmlspecialchars($biblioteca['titulo']); ?></td>
                            <td><?php echo htmlspecialchars($biblioteca['descricao']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="alert alert-warning">Nenhuma biblioteca cadastrada.</p>
        <?php endif; ?>
    </div>

        <
</body>

<?php

?>
</html>
