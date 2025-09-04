<?php
session_start();
require_once(__DIR__ . '/../../../Config/config.inc.php');
require_once(__DIR__ . '/../../Models/Usuario.class.php');

header('Content-Type: application/json');

// Verifica método POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["sucesso" => false, "mensagem" => "Método inválido."]);
    exit;
}

// Captura dados do formulário
$id     = $_POST['id'] ?? null;
$nome   = trim($_POST['nome'] ?? '');
$email  = trim($_POST['email'] ?? '');
$senha  = $_POST['senha'] ?? '';
$foto   = $_FILES['foto'] ?? null;

// Valida ID
if (empty($id) || !is_numeric($id)) {
    echo json_encode(["sucesso" => false, "mensagem" => "ID de usuário inválido."]);
    exit;
}

// Verifica sessão
if (!isset($_SESSION['usuario_id']) || $_SESSION['usuario_id'] != $id) {
    echo json_encode(["sucesso" => false, "mensagem" => "Acesso não autorizado."]);
    exit;
}

// Campos obrigatórios
if (empty($nome) || empty($email)) {
    echo json_encode(["sucesso" => false, "mensagem" => "Preencha todos os campos obrigatórios."]);
    exit;
}

try {
    // Pega os dados atuais do usuário
    $dados = Usuario::listar(1, $id);
    if (!$dados) {
        echo json_encode(["sucesso" => false, "mensagem" => "Usuário não encontrado."]);
        exit;
    }

    $usuario = new Usuario(
        $dados[0]['id'],
        $nome,
        $email,
        $dados[0]['usuario'],
        $dados[0]['senha_hash'],
        $dados[0]['tipo'],
        $dados[0]['foto_perfil'],
        $dados[0]['data_cadastro']
    );

    // Atualiza senha se preenchida
    if (!empty($senha)) {
        $usuario->setSenhaHash(password_hash($senha, PASSWORD_DEFAULT));
    }

    // Atualiza foto se enviada
    if (!empty($foto['name']) && $foto['error'] === 0) {
        $extensao = strtolower(pathinfo($foto['name'], PATHINFO_EXTENSION));
        $permitidas = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($extensao, $permitidas)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Formato de imagem inválido."]);
            exit;
        }

        $nomeArquivo = uniqid('perfil_', true) . "." . $extensao;
        $caminhoDestino = __DIR__ . '/../../Public/assets/img/' . $nomeArquivo;

        if (!move_uploaded_file($foto['tmp_name'], $caminhoDestino)) {
            echo json_encode(["sucesso" => false, "mensagem" => "Erro ao enviar a foto."]);
            exit;
        }

        $usuario->setFotoPerfil($nomeArquivo);
        $_SESSION['usuario_foto'] = $nomeArquivo;
    }

    // Executa alteração
    if ($usuario->alterar()) {
        // Atualiza sessão
        $_SESSION['usuario_nome']  = $nome;
        $_SESSION['usuario_email'] = $email;

        echo json_encode(["sucesso" => true, "mensagem" => "Perfil atualizado com sucesso!"]);
    } else {
        echo json_encode(["sucesso" => false, "mensagem" => "Nenhuma alteração realizada."]);
    }

} catch (Exception $e) {
    echo json_encode(["sucesso" => false, "mensagem" => "Erro: " . $e->getMessage()]);
}
?>
