<?php 
include("head.php");
?>
<body>
<nav style="background-color: #f8f9fa; padding: 20px; display: flex; justify-content: space-between; align-items: center;">
    <img src="/BiblioLab/Bibliolab/Public/assets/img/logo.png" alt="Logo" style="width: 100px; height: auto;"> 
    <div style="font-size: 3em; font-weight: bold; color: black;">BiblioLab</div>
    <ul style="list-style: none; display: flex; gap: 30px; margin: 0; padding: 0;">
        <li><a href="/BiblioLab/Bibliolab/Public/index.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Home</a></li>
        <li><a href="/BiblioLab/Bibliolab/App/views/sobre.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Sobre</a></li>
        <li><a href="/BiblioLab/Bibliolab/App/views/contato.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Contato</a></li>
        
    <?php if (!isset($_SESSION['usuario_id'])): ?>
        <li><a href="/BiblioLab/Bibliolab/App/views/auth/cad_usuario.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Cadastre-se</a></li>
        <li><a href="/BiblioLab/Bibliolab/App/views/auth/login.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Login</a></li>
    <?php elseif ($_SESSION['tipo'] === 'admin'): ?>
        <li><a href="/BiblioLab/Bibliolab/App/views/profile/admin.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Painel do Administrador</a></li>
        <li><a href="/BiblioLab/Bibliolab/App/views/profile/index.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Meu Perfil</a></li>
        <li><a href="/BiblioLab/Bibliolab/App/views/auth/logout.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Sair</a></li>
    <?php else: ?>
        <li><a href="/BiblioLab/Bibliolab/App/views/main/cadastro.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Cadastro de biblioteca</a></li>
        <li><a href="/BiblioLab/Bibliolab/App/views/profile/index.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Meu Perfil</a></li>
        <li><a href="/BiblioLab/Bibliolab/App/Controllers/logout.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Sair</a></li>
    <?php endif; ?>
    </ul>
</nav>
<br>
</body>

