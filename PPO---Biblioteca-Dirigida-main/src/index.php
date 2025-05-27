<?php
// Conexão com o banco de dados
require_once 'Class/    Database.class.php';

try {
    $conexao = new PDO(DSN, USUARIO, SENHA);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Consulta para listar as bibliotecas
    $sql = "SELECT * FROM Biblioteca";
    $stmt = $conexao->query($sql);
    $bibliotecas = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Erro ao conectar ou consultar o banco de dados: " . $e->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Bibliotecas Cadastradas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
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
</body>
</html>
