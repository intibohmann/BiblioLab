<?php
session_start();
require_once __DIR__ . '/../../Config/config.inc.php';
require_once __DIR__ . '/../core/Database.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $usuario = $_POST['usuario'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $confirmar_senha = $_POST['confirmar_senha'] ?? '';

    if ($senha !== $confirmar_senha) {
        header("Location: ../views/auth/Cad_usuario.php?mensagem=" . urlencode("As senhas não coincidem."));
        exit;
    }

    try {
        $pdo = Database::getConexao(); // Usa a instância de conexão

        // Verifica se já existe usuário ou email
        $sql = "SELECT id FROM usuarios WHERE usuario = :usuario OR email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['usuario' => $usuario, 'email' => $email]);

        if ($stmt->rowCount() > 0) {
            header("Location: ../views/auth/Cad_usuario.php?mensagem=" . urlencode("Usuário ou e-mail já cadastrado."));
            exit;
        }

        // Insere novo usuário
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
        $tipo = 'aluno';

        $sql = "INSERT INTO usuarios (nome, email, usuario, senha_hash, tipo) 
                VALUES (:nome, :email, :usuario, :senha_hash, :tipo)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            'nome' => $nome,
            'email' => $email,
            'usuario' => $usuario,
            'senha_hash' => $senha_hash,
            'tipo' => $tipo
        ]);

        $ultimo_id = $pdo->lastInsertId();

        // Login automático após cadastro
        $_SESSION['usuario_id'] = $ultimo_id;
        $_SESSION['usuario'] = $usuario;
        $_SESSION['tipo'] = $tipo;

        // Redireciona com base no tipo
        if ($tipo === 'admin') {
            header("Location: ../views/profile/admin.php");
        } else {
            header("Location: ../../Public/index.php");
        }
        exit;

    } catch (Exception $e) {
        header("Location: ../views/auth/Cad_usuario.php?mensagem=" . urlencode("Erro: " . $e->getMessage()));
        exit;
    }
} else {
    header("Location: ../views/auth/Cad_usuario.php");
    exit;
}
?>
