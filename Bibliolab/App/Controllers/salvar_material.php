<?php
require_once("../Class/Materiais.class.php");

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Coletar dados do formulário
        $titulo = $_POST["titulo"];
        $descricao = $_POST["descricao"];
        $tipo = $_POST["tipo"];
        $url = $_POST["url"];
        $categoria_id = $_POST["categoria_id"];
        $biblioteca_id = $_POST["biblioteca_id"];
        $url = "";

        // Lógica para lidar com url
        

        // Criar objeto da classe e definir valores
        $material = new Materiais();
        $material->setTitulo($titulo);
        $material->setDescricao($descricao);
        $material->setTipo($tipo);
        $material->setUrl($url);
        $material->setCategoriaId($categoria_id);
        $material->setBibliotecaId($biblioteca_id);

        // Inserir no banco
        if ($material->inserir()) {
            echo "<div class='alert alert-success m-4'>Material cadastrado com sucesso! <a href='cadastro.php'>Voltar</a></div>";
            header("Location: ../inicio/index.php");
            
        } else {
            echo "<div class='alert alert-danger m-4'>Erro ao cadastrar material. <a href='cadastro.php'>Tentar novamente</a></div>";
        }

    } catch (Exception $e) {
        echo "<div class='alert alert-danger m-4'>Erro: " . $e->getMessage() . "</div>";
    }
} else {
    echo "<div class='alert alert-warning m-4'>Método inválido</div>";
}
?>
