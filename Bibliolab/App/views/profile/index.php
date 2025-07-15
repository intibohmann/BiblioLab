<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit;
}

$dsn = "mysql:host=localhost;dbname=biblioteca;charset=utf8mb4";
$dbUsername = "root";
$dbPassword = "";

try {
    $pdo = new PDO($dsn, $dbUsername, $dbPassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $user_id = $_SESSION['usuario_id'];
    $stmt = $pdo->prepare("SELECT nome, email, usuario, foto_perfil FROM Usuarios WHERE id = ?");
    $stmt->execute([$user_id]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro de conexão: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Meu Perfil</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card shadow mx-auto" style="max-width: 600px;">
            <div class="card-body p-4">
                <h3 class="card-title text-center mb-4">Meu Perfil</h3>

                <div class="text-center mb-4">
                    <img src="<?= !empty($usuario['foto_perfil']) ? '/BiblioLab/Bibliolab/Public/assets/img/' . htmlspecialchars($usuario['foto_perfil']) : 'https://via.placeholder.com/120?text=Sem+Foto' ?>" 
                         alt="Foto de Perfil" 
                         class="rounded-circle img-thumbnail" 
                         style="width: 120px; height: 120px; object-fit: cover;">
                </div>

                <form action="/BiblioLab/Bibliolab/App/controllers/atualizar_perfil.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label class="form-label">Nome</label>
                        <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" value="<?= htmlspecialchars($usuario['email']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nova senha <small class="text-muted">(deixe em branco para não mudar)</small></label>
                        <input type="password" name="nova_senha" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Foto de perfil</label>
                        <input type="file" name="foto" class="form-control">
                    </div>

                    <?php if (!empty($usuario['foto_perfil'])): ?>
                        <div class="mb-3 text-center">
                            <a href="/BiblioLab/Bibliolab/App/controllers/remover_foto.php" class="btn btn-danger btn-sm">
                                Remover Foto
                            </a>
                        </div>
                    <?php endif; ?>

                    <div class="d-grid mt-4">
                        <input type="submit" value="Atualizar Perfil" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>


