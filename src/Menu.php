<?php include("head.php");?>
<body>
<style>
/* Responsividade e Dropdowns */
.menu-nav {
    background: rgba(203, 0, 0, 0.1);
    padding: 10px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    display: flex;
    justify-content: space-between;
    align-items: center;
    width: 100%;
    position: absolute;
    top: 0;
    z-index: 10;
}
.menu-logo {
    font-size: 2em;
    font-weight: bold;
    color: #fff;
}
.menu-list {
    list-style: none;
    display: flex;
    gap: 30px;
    margin: 0;
    padding: 0;
}
.menu-list li {
    position: relative;
}
.menu-list a {
    color: #fff;
    text-decoration: none;
    transition: color 0.3s;
    padding: 8px 12px;
    display: block;
}
.menu-list li:hover > ul {
    display: block;
}
.menu-dropdown {
    display: none;
    position: absolute;
    background: rgba(203, 0, 0, 0.98);
    top: 100%;
    left: 0;
    min-width: 150px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.15);
    z-index: 20;
}
.menu-dropdown li {
    width: 100%;
}
.menu-dropdown a {
    padding: 10px 15px;
    color: #fff;
}
.menu-toggle {
    display: none;
    flex-direction: column;
    cursor: pointer;
    gap: 5px;
}
.menu-toggle span {
    width: 30px;
    height: 4px;
    background: #fff;
    border-radius: 2px;
    display: block;
}
.menu-profile {
    margin-left: 20px;
    display: flex;
    align-items: center;
}
.menu-profile a {
    display: flex;
    align-items: center;
    color: #fff;
    text-decoration: none;
    font-size: 1.5em;
    transition: color 0.3s;
}
.menu-profile a:hover {
    color: #ffd700;
}
@media (max-width: 800px) {
    .menu-list {
        display: none;
        flex-direction: column;
        background: rgba(203,0,0,0.98);
        position: absolute;
        top: 60px;
        right: 0;
        width: 200px;
        gap: 0;
    }
    .menu-list.show {
        display: flex;
    }
    .menu-toggle {
        display: flex;
    }
    .menu-logo {
        font-size: 1.5em;
    }
    .menu-profile {
        margin-left: 10px;
    }
}
</style>
<nav class="menu-nav">
    <div class="menu-logo">BiblioLab</div>
    <div class="menu-toggle" onclick="document.querySelector('.menu-list').classList.toggle('show')">
        <span></span><span></span><span></span>
    </div>
    <ul class="menu-list">
        <li><a href="index.php">Home</a></li>
        <li>
            <a href="#">Sobre</a>
            <ul class="menu-dropdown">
                <li><a href="sobre.php">Quem Somos</a></li>
                <li><a href="equipe.php">Equipe</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Contato</a>
            <ul class="menu-dropdown">
                <li><a href="contato.php">Fale Conosco</a></li>
                <li><a href="faq.php">FAQ</a></li>
            </ul>
        </li>
        <li>
            <a href="#">Conta</a>
            <ul class="menu-dropdown">
                <li><a href="cadastro.php">Cadastre-se</a></li>
                <li><a href="login.php">Login</a></li>
            </ul>
        </li>
    </ul>
    <div class="menu-profile">
        <a href="perfil.php" title="Perfil do Usuário">
            <!-- Ícone SVG de usuário -->
            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 24 24">
                <circle cx="12" cy="8" r="4"/>
                <path d="M12 14c-5 0-8 2.5-8 5v1h16v-1c0-2.5-3-5-8-5z"/>
            </svg>
        </a>
    </div>
</nav>
</body>
