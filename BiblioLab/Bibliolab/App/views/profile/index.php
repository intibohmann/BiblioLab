<?php
session_start();
require_once(__DIR__ . '/../../../Config/config.inc.php');
require_once(__DIR__ . '/../../Models/Usuarios.class.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "<div class='alert alert-danger'>Você não está logado.</div>";
    exit;
}

try {
    $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->prepare("SELECT id, nome, email, data_cadastro FROM Usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "<div class='alert alert-danger'>Usuário não encontrado.</div>";
        exit;
    }

    // Força a usar foto mockada
    $usuario['foto_perfil'] = "default-user.png";

} catch (Exception $e) {
    echo "<div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div>";
    exit;
}

include '../layouts/head.php';
?>
<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <h2 class="mb-4 text-center">Meu Perfil</h2>

            <!-- Retirei action e enctype porque não precisamos mais -->
            <form id="formPerfil" method="POST">
                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

                <div class="text-center mb-4">
                    <img id="previewFoto" 
                         src="/BiblioLab/Bibliolab/public/assets/img/<?= htmlspecialchars($usuario['foto_perfil']) ?>" 
                         class="rounded-circle border border-3 shadow-lg animate__animated" 
                         width="150" height="150" 
                         style="object-fit: cover; transition: 0.3s;">
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nome</label>
                    <input type="text" name="nome" class="form-control" 
                           value="<?= htmlspecialchars($usuario['nome']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <input type="email" name="email" class="form-control" 
                           value="<?= htmlspecialchars($usuario['email']) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Nova Senha <small class="text-muted">(opcional)</small></label>
                    <input type="password" name="senha" class="form-control">
                </div>

                <div class="d-grid">
                    <button type="submit" id="btnSalvar" class="btn btn-primary btn-lg">💾 Salvar Alterações</button>
                </div>

                <div id="resposta" class="mt-3"></div>
            </form>
        </div>
    </div>
</div>

<script>
const formPerfil = document.getElementById('formPerfil');
const respostaDiv = document.getElementById('resposta');
const btnSalvar = document.getElementById('btnSalvar');

formPerfil.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(formPerfil);

    btnSalvar.disabled = true;
    btnSalvar.innerText = '⏳ Salvando...';
    respostaDiv.innerHTML = '';

    try {
        // Aqui você pode ainda mandar pro atualizar_perfil.php
        const resp = await fetch('../../Controllers/atualizar_perfil.php', {
            method: 'POST',
            body: formData
        });

        const json = await resp.json();

        if (json.sucesso) {
            respostaDiv.innerHTML = `<div class="alert alert-success animate__animated animate__fadeIn">${json.mensagem}</div>`;
            setTimeout(() => { respostaDiv.innerHTML = ''; }, 3000);
        } else {
            respostaDiv.innerHTML = `<div class="alert alert-danger animate__animated animate__shakeX">${json.mensagem}</div>`;
        }
    } catch (error) {
        respostaDiv.innerHTML = `<div class="alert alert-danger">Erro ao salvar: ${error.message}</div>`;
        console.error(error);
    } finally {
        btnSalvar.disabled = false;
        btnSalvar.innerText = '💾 Salvar Alterações';
    }
});
</script>
