<?php include("head.php");?>
<body>
<nav style="background: #6a11cb; padding: 10px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); display: flex; justify-content: space-between; align-items: center; width: 100%; position: absolute; top: 0; flex-wrap: wrap;">
    <div style="font-size: 2em; font-weight: bold; color: #fff; flex: 1; text-align: center;">BiblioLab</div>
    <ul style="list-style: none; display: flex; gap: 30px; margin: 0; padding: 0; flex-wrap: wrap; justify-content: center; flex: 2;">
        <li><a href="index.php" style="color: #fff; text-decoration: none; transition: color 0.3s ease;">Home</a></li>
        <li><a href="sobre.php" style="color: #fff; text-decoration: none; transition: color 0.3s ease;">Sobre</a></li>
        <li><a href="contato.php" style="color: #fff; text-decoration: none; transition: color 0.3s ease;">Contato</a></li>
        <li><a href="cadastro.php" style="color: #fff; text-decoration: none; transition: color 0.3s ease;">Cadastre-se</a></li>
        <li><a href="login.php" style="color: #fff; text-decoration: none; transition: color 0.3s ease;">Login</a></li>
    </ul>
</nav>
<style>
    @media (max-width: 768px) {
        nav {
            flex-direction: column;
            align-items: center;
        }
        nav div {
            font-size: 1.5em;
        }
        nav ul {
            gap: 15px;
        }
    }
</style>
</body>
