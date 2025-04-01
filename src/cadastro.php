<?php include('head.php'); ?>
<body>
<?php include('menu.php'); ?>
<?php
// Processa o formulário quando enviado
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];
    $confirmar_senha = $_POST['confirmar_senha'];

    // Validação de dados
    if (empty($nome) || empty($email) || empty($usuario) || empty($senha) || empty($confirmar_senha)) {
        echo "Todos os campos são obrigatórios.";
    } elseif ($senha !== $confirmar_senha) {
        echo "As senhas não coincidem.";
    } else {
        // Estrutura dos dados
        $novo_usuario = array(
            'nome' => $nome,
            'email' => $email,
            'usuario' => $usuario,
            'senha' => password_hash($senha, PASSWORD_DEFAULT) // Usando hash para a senha
        );

        // Caminho para o arquivo JSON
        $arquivo_json = 'users.json';

        // Verifica se o arquivo já existe
        if (file_exists($arquivo_json)) {
            // Lê o conteúdo existente do arquivo
            $dados_arquivo = file_get_contents($arquivo_json);
            $usuarios = json_decode($dados_arquivo, true);
        } else {
            $usuarios = array();
        }

        // Adiciona o novo usuário aos dados existentes
        array_push($usuarios, $novo_usuario);

        // Salva os dados no arquivo JSON
        file_put_contents($arquivo_json, json_encode($usuarios, JSON_PRETTY_PRINT));

        echo "Cadastro realizado com sucesso!";
    }
}
?>
    <form method="POST" action="">
        <label for="nome">Nome:</label><br>
        <input type="text" id="nome" name="nome" required><br><br>

        <label for="email">E-mail:</label><br>
        <input type="email" id="email" name="email" required><br><br>

        <label for="usuario">Usuário:</label><br>
        <input type="text" id="usuario" name="usuario" required><br><br>

        <label for="senha">Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>

        <label for="confirmar_senha">Confirmar Senha:</label><br>
        <input type="password" id="confirmar_senha" name="confirmar_senha" required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>


<?php include("rodape.php");  ?>
</body>