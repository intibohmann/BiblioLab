<?php 
include("head.php");
?>
<body>
<nav style="background-color: #f8f9fa; padding: 20px; display: flex; justify-content: space-between; align-items: center;">
    <img src="../../img/logo.png" alt="Logo" style="width: 100px; height: auto;"> 
    <div style="font-size: 3em; font-weight: bold; color: black;">BiblioLab</div>
    <ul style="list-style: none; display: flex; gap: 30px; margin: 0; padding: 0;">
        <li><a href="../models/index.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Home</a></li>
        <li><a href="../models/sobre.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Sobre</a></li>
        <li><a href="../models/contato.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Contato</a></li>
        
    <?php if (!isset($_SESSION['user_id'])): ?>
   <li><a href="../models/cadastro.php"style="color: black; text-decoration: none; transition: color 0.3s ease;">Cadastre-se</a></li>
    <li><a href="login.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Login</a></li>
    <?php else: ?>
        <li><a href="../main/cadastro.php" style="color: black; text-decoration: none; transition: color 0.3s ease;">Cadastro de biblioteca</a></li>
        <li><a href="perfil.php">Meu Perfil</a></li>
        <li><a href="logout.php">Sair</a></li>
    <?php endif; ?>

       
     
    </ul>
</nav>
<br>
</body>
