<?php
session_start();
require_once(__DIR__ . '/../../views/layouts/head.php');

// Dados do usuário
$usuario = $_SESSION['usuario'] ?? null;
?>

<div class="container mt-5">
    <h2>Perfil do Usuário</h2>
    <form id="formPerfil" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
        
        <div class="mb-3">
            <label>Nome</label>
            <input type="text" name="nome" class="form-control" value="<?= $usuario['nome'] ?>">
        </div>

        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="<?= $usuario['email'] ?>">
        </div>

        <div class="mb-3">
            <label>Nova senha (deixe em branco para manter)</label>
            <input type="password" name="senha" class="form-control">
        </div>

        <div class="mb-3">
            <label>Foto de perfil</label><br>
            <input type="file" name="foto" accept="image/*">
            <div class="mt-2">
                <img src="/BiblioLab/Public/assets/img/<?= $usuario['foto'] ?>" width="100" alt="Foto atual">
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Salvar alterações</button>
        <div id="resposta" class="mt-3"></div>
    </form>
</div>

<script>
document.getElementById('formPerfil').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    const resp = await fetch('/BiblioLab/App/Controllers/atualizar_perfil.php', {
        method: 'POST',
        body: formData
    });
    const json = await resp.json();
    document.getElementById('resposta').innerHTML = json.mensagem;
});
</script>
