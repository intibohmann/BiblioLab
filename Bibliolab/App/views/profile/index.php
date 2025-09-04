<?php
session_start();
require_once(__DIR__ . '/../../../Config/config.inc.php');

if (!isset($_SESSION['usuario_id'])) {
    echo "<div class='alert alert-danger'>Você não está logado.</div>";
    exit;
}

try {
    $pdo = new PDO(DSN, DB_USER, DB_PASSWORD, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $stmt = $pdo->prepare("SELECT id, nome, email, foto_perfil, data_cadastro FROM Usuarios WHERE id = ?");
    $stmt->execute([$_SESSION['usuario_id']]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$usuario) {
        echo "<div class='alert alert-danger'>Usuário não encontrado.</div>";
        exit;
    }
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

            <form id="formPerfil" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="id" value="<?= $usuario['id'] ?>">

                <div class="text-center mb-4">
                    <div style="position: relative; display: inline-block;">
                        <img id="previewFoto" 
                       
                             class="rounded-circle border border-3 shadow-lg animate__animated" 
                             width="150" height="150" 
                             style="object-fit: cover; transition: 0.3s;">

                        <!-- Loading overlay -->
                        <div id="loadingFoto" style="display:none; position:absolute; top:0; left:0; width:150px; height:150px; background:rgba(255,255,255,0.6); border-radius:50%; display:flex; align-items:center; justify-content:center;">
                            <div class="spinner-border text-primary" role="status"></div>
                        </div>
                    </div>
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
                    <button type="submit" id="btnSalvar" class="btn btn-primary btn-lg">💾 Salvar Alterações</button>
                </div>

                <div id="resposta" class="mt-3"></div>
            </form>
        </div>
    </div>
</div>

<script>
const inputFoto = document.getElementById('inputFoto');
const previewFoto = document.getElementById('previewFoto');
const loadingFoto = document.getElementById('loadingFoto');
const formPerfil = document.getElementById('formPerfil');
const respostaDiv = document.getElementById('resposta');
const btnSalvar = document.getElementById('btnSalvar');

// Preview da foto com fade-in
inputFoto.addEventListener('change', () => {
    const file = inputFoto.files[0];
    if(file){
        previewFoto.src = URL.createObjectURL(file);
        previewFoto.classList.add('animate__fadeIn');
        setTimeout(() => previewFoto.classList.remove('animate__fadeIn'), 500);
    }
});

// Submit via AJAX
formPerfil.addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(formPerfil);

    // Feedback visual
    btnSalvar.disabled = true;
    btnSalvar.innerText = '⏳ Salvando...';
    respostaDiv.innerHTML = '';
    loadingFoto.style.display = 'flex';

    try {
        const resp = await fetch('/BiblioLab/Bibliolab/App/Controllers/atualizar_perfil.php', {
            method: 'POST',
            body: formData
        });
        const json = await resp.json();

        if(json.sucesso){
            respostaDiv.innerHTML = `<div class="alert alert-success animate__animated animate__fadeIn">${json.mensagem}</div>`;

            // Atualiza preview e inputs
            if(formData.get('foto').name){
                previewFoto.src = URL.createObjectURL(formData.get('foto'));
            }
            document.querySelector('input[name="nome"]').value = formData.get('nome');
            document.querySelector('input[name="email"]').value = formData.get('email');

            // Remove a mensagem após 3s
            setTimeout(() => {
                respostaDiv.innerHTML = '';
            }, 3000);
        }
        else{
            respostaDiv.innerHTML = `<div class="alert alert-danger animate__animated animate__shakeX">${json.mensagem}</div>`;
        }
    } catch (error) {
        respostaDiv.innerHTML = `<div class="alert alert-danger animate__animated animate__shakeX">Erro ao salvar: ${error.message}</div>`;
    } finally {
        btnSalvar.disabled = false;
        btnSalvar.innerText = '💾 Salvar Alterações';
        loadingFoto.style.display = 'none';
    }
});
</script>
