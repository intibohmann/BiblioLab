<?php
require_once '../../core/Database.class.php';
require_once '../../Models/Biblioteca.class.php';
require_once '../../Models/Categorias.class.php';
require_once '../../Models/Materiais.class.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? $_POST['id'] : 0;
    $titulo = isset($_POST['titulo']) ? $_POST['titulo'] : "";
    $descricao = isset($_POST['descricao']) ? $_POST['descricao'] : "";
    $categoria_id = isset($_POST['categoria_id']) ? $_POST['categoria_id'] : "";
    $acao = isset($_POST['acao']) ? $_POST['acao'] : "salvar";

    $biblioteca = new Biblioteca($id, $titulo, $descricao, $categoria_id);

    if ($acao === 'salvar') {
        $resultado = ($id > 0) ? $biblioteca->alterar() : $biblioteca->inserir();
    } elseif ($acao === 'excluir') {
        $resultado = $biblioteca->excluir();
    }

    if ($resultado) {
        header("Location: index.php");
        exit;
    } else {
        echo "Erro ao salvar dados: " . $biblioteca;
    }

} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $formulario = file_get_contents('form_cad_biblioteca.html');

    $id = isset($_GET['id']) ? $_GET['id'] : 0;
    $resultado = Biblioteca::listar(1, $id);

    if ($resultado) {
        $biblioteca = $resultado[0];
        $formulario = str_replace('{id}', $biblioteca['id'], $formulario);
        $formulario = str_replace('{titulo}', $biblioteca['titulo'], $formulario);
        $formulario = str_replace('{descricao}', $biblioteca['descricao'], $formulario);
    } else {
        $formulario = str_replace('{id}', 0, $formulario);
        $formulario = str_replace('{titulo}', '', $formulario);
        $formulario = str_replace('{descricao}', '', $formulario);
    }

    // Monta as opções da categoria
    $categorias = Categoria::listar();
    $opcoes = "";
    foreach ($categorias as $c) {
        $selected = ($resultado && $c['id'] == $biblioteca['categoria_nome']) ? "selected" : "";
        $opcoes .= "<option value='{$c['id']}' $selected>{$c['nome']}</option>";
    }

    $formulario = str_replace('{opcoes_categoria}', $opcoes, $formulario);

    echo $formulario;
    include_once('lista_biblioteca.php');
}
?>