<?php
session_start();

require_once(__DIR__ . '/../Models/Usuarios.class.php');
require_once(__DIR__ . '/../../Config/config.inc.php');

// Garante que o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    header("Location: ../views/login.php?erro=1");
    exit;
}

$id_usuario = $_SESSION['id_usuario'];

try {
    // Atualizar dados básicos
    if (!empty($_POST['nome']) && !empty($_POST['email'])) {
        $usuario = new Usuario(
            $id_usuario,
            $_POST['nome'],
            $_POST['email'],
            $_POST['usuario'] ?? "", // caso exista no form
            "", // senha só se mudar
            "aluno" // ou pega da sessão se preferir
        );

        // Senha nova (opcional)
        if (!empty($_POST['senha'])) {
            $senha_hash = password_hash($_POST['senha'], PASSWORD_DEFAULT);
            $usuario->setSenhaHash($senha_hash);
        } else {
            // Recupera senha atual do banco para não perder
            $dados = Usuario::listar(1, $id_usuario);
            if ($dados && isset($dados[0]['senha_hash'])) {
                $usuario->setSenhaHash($dados[0]['senha_hash']);
            }
        }

        // Foto de perfil (upload)
        if (!empty($_FILES['foto']['name'])) {
            $foto_nome = uniqid() . "_" . basename($_FILES['foto']['name']);
            $destino = __DIR__ . '/../../public/assets/img/' . $foto_nome;

            if (move_uploaded_file($_FILES['foto']['tmp_name'], $destino)) {
                $usuario->setFotoPerfil($foto_nome);
            } else {
                throw new Exception("Erro ao mover a foto enviada.");
            }
        } else {
            // Mantém a foto existente
            $dados = Usuario::listar(1, $id_usuario);
            if ($dados && isset($dados[0]['foto_perfil'])) {
                $usuario->setFotoPerfil($dados[0]['foto_perfil']);
            }
        }

        // Salva alterações
        if ($usuario->alterar()) {
            header("Location: ../views/profile/index.php?sucesso=1");
            exit;
        } else {
            throw new Exception("Erro ao salvar alterações no banco.");
        }
    } else {
        throw new Exception("Nome e Email são obrigatórios.");
    }
} catch (Exception $e) {
    header("Location: ../views/profile/index.php?erro=" . urlencode($e->getMessage()));
    exit;
}
