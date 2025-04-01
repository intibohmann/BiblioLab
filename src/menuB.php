<style>

        .navbar {
            margin-bottom: 20px; 
        }


        .section2 {
            background-color: #5934f9;
            padding: 1px 0;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            border-top: 5px solid white;
            margin-top: 20px;
        }

        .button-container {
            display: flex;
            gap: 20px;
        }

        .button {
            font-size: 18px;
            font-weight: bold;
            transition: all 0.3s ease;
            padding: 10px 20px;
            border-radius: 5px; 
        }

        

        .button:hover {
            background-color: #ffdd57;
            color: #5934f9; 
        }

        .button:focus {
            outline: none;
            box-shadow: 0 0 5px 2px rgba(255, 221, 87, 0.5);
        }

        .button.is-primary {
            background-color: #5934f9;
            border-color: #5934f9;
            color: aliceblue;
        }

        .button.is-primary:hover {
            background-color: #ffdd57;
            color: #5934f9;
        }
    </style>


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
