<?php include('head.php'); ?>
<body>
<?php include('menu.php'); ?>

    <h2>Login</h2>
    <form action="login.php" method="POST">
        <label for="username">Usuário:</label>
        <input type="text" class="input is-small"    id="username" name="username" required><br><br>

        <label for="password">Senha:</label>
        <input type="password" id="password" name="password" required><br><br>

        <input type="submit" value="Entrar">
    </form>
    <?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupera os dados do formulário
    $username = $_POST['username'];
    $password = $_POST['password'];


    $userData = [
        'username' => $username,
        'password' => $password
    ];


    $file = 'users.json';


    if (file_exists($file)) {

        $jsonData = file_get_contents($file);
        $users = json_decode($jsonData, true);
    } else {

        $users = [];
    }


    $users[] = $userData;


    file_put_contents($file, json_encode($users, JSON_PRETTY_PRINT));


    header("Location: index.php");
    exit; 
}
?>

<?php include("rodape.php");  ?>
</body>
</html>
