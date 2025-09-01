<?php
session_start();
require_once(__DIR__ . '/../../../Config/config.inc.php');
require_once(__DIR__ . '/../../views/layouts/head.php');


if (!isset($_SESSION['usuario_id'])) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Você não está logado.</div></div>";
    exit;
}

try {
    $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Busca dados completos do usuário
    $stmt = $pdo->prepare("SELECT id, nome, email, foto_perfil, data_cadastro FROM Usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "<div class='container mt-5'><div class='alert alert-danger'>Usuário não encontrado.</div></div>";
        exit;
    }

} catch (Exception $e) {
    echo "<div class='container mt-5'><div class='alert alert-danger'>Erro: " . $e->getMessage() . "</div></div>";
    exit;
}
?>

<div class="container mt-5">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-body">
            <h2 class="mb-4 text-center">Meu Perfil</h2>

            <form id="formPerfil" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

                <div class="text-center mb-4">
                    <img id="previewFoto" 
                         src="/BiblioLab/Public/assets/img/<?= $usuario['foto_perfil'] ?: 'default.png' ?>" 
                         class="rounded-circle border border-3 shadow" 
                         width="150" height="150" 
                         style="object-fit: cover;">
                    <div class="mt-2">
                        <label class="btn btn-outline-primary btn-sm">
                            Alterar Foto
                            <input type="file" name="foto" id="inputFoto" accept="image/*" hidden>
                        </label>
                    </div>
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
                    <button type="submit" class="btn btn-primary btn-lg">💾 Salvar Alterações</button>
                </div>

                <div id="resposta" class="mt-3"></div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('inputFoto').addEventListener('change', function(){
    const file = this.files[0];
    if(file){
        document.getElementById('previewFoto').src = URL.createObjectURL(file);
    }
});

document.getElementById('formPerfil').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);

    const respostaDiv = document.getElementById('resposta');
    respostaDiv.innerHTML = '<div class="alert alert-info">Salvando...</div>';

    try {
        const resp = await fetch('/BiblioLab/App/Controllers/atualizar_perfil.php', {
            method: 'POST',
            body: formData
        });
        const json = await resp.json();

        if(json.sucesso){
            respostaDiv.innerHTML = `<div class="alert alert-success">${json.mensagem}</div>`;
        } else {
            respostaDiv.innerHTML = `<div class="alert alert-danger">${json.mensagem}</div>`;
        }
    } catch (err) {
        respostaDiv.innerHTML = `<div class="alert alert-danger">Erro ao enviar dados.</div>`;
    }
});
</script>