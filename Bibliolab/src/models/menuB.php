<?php include("head.php");?>
<!-- Navbar -->
<nav class="navbar is-primary">
    <div class="container">
      <div class="navbar-brand">
        <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarMenu">
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
          <span aria-hidden="true"></span>
        </a>
        <a class="navbar-item" href="index.php">
          Home
        </a>
        <a class="navbar-item" href="#">
          Sobre
        </a>
      </div>
      <div id="navbarMenu" class="navbar-menu">
        <div class="navbar-start"></div>
        <div class="navbar-end">
          <div class="navbar-item">
            <h1>Biblioteca Dirigida</h1>
          </div>
          <div class="navbar-item">
            <div class="buttons">
              <a class="button is-light" href="login.php">Login</a>
              <a class="button is-light" href="cadastro.php">Cadastro</a>
            </div>
          </div>
        </div>
      </div>
    </div>
</nav>

<!-- Menu de Botões -->
<section class="section2">
    <div class="button-container">
        <a href="grupo.php" class="button is-primary">Material da Biblioteca</a>
        <a href="chat.php" class="button is-primary">Chat da Biblioteca</a>
    </div>
</section>
