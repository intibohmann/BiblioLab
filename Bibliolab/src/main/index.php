<?php
require_once __DIR__ . '/../Class/Biblioteca.class.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = isset($_POST['id'])?$_POST['id']:0;
    $titulo = isset($_POST['titulo'])?$_POST['titulo']:"";
    $descricao = isset($_POST['descricao'])?$_POST['descricao']:0;
    $categoria_id = isset($_POST['categoria_id'])?$_POST['categoria_id']:"";
    $acao = isset($_POST['acao'])?$_POST['acao']:"";


    $biblioteca = new Biblioteca($id,$titulo,$descricao,$categoria_id);
    if ($acao == 'salvar')
        if ($id > 0)
            $resultado = $biblioteca->alterar();
        else
            $resultado = $biblioteca->inserir();
    elseif ($acao == 'excluir')
        $resultado = $biblioteca->excluir();

    if ($resultado)
        header("Location: index.php");
    else
        echo "Erro ao salvar dados: ". $biblioteca;
}elseif ($_SERVER['REQUEST_METHOD'] == 'GET'){
    $formulario = file_get_contents('form_cad_biblioteca.html');

    $id = isset($_GET['id'])?$_GET['id']:0;
    $resultado = Biblioteca::listar(1,$id);
    if ($resultado){
        $biblioteca = $resultado[0];
        $formulario = str_replace('{id}', isset($biblioteca['id']) ? $biblioteca['id'] : '', $formulario);
        $formulario = str_replace('{titulo}', isset($biblioteca['titulo']) ? $biblioteca['titulo'] : '', $formulario);
        $formulario = str_replace('{descricao}', isset($biblioteca['descricao']) ? $biblioteca['descricao'] : '', $formulario);
        $formulario = str_replace('{categoria_id}', isset($biblioteca['categoria_id']) ? $biblioteca['categoria_id'] : '', $formulario);
    }else{
        $formulario = str_replace('{id}',0,$formulario);
        $formulario = str_replace('{titulo}','',$formulario);
        $formulario = str_replace('{descricao}',0,$formulario);
        $formulario = str_replace('{categoria_id}','',$formulario);
    }
    print($formulario); 
    include_once('lista_biblioteca.php');
 

}
?>