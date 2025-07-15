<?php
    require_once("../../Models/Biblioteca.class.php");
    $busca = isset($_GET['busca'])?$_GET['busca']:0;
    $tipo = isset($_GET['tipo'])?$_GET['tipo']:0;
   
    $lista = Biblioteca::listar($tipo, $busca);
    $itens = '';
    foreach($lista as $biblioteca){
        $item = file_get_contents('itens_listagem_biblioteca.html');
        $item = str_replace('{id}', $biblioteca['id'], $item);
        $item = str_replace('{titulo}', $biblioteca['titulo'], $item);
        $item = str_replace('{descricao}', $biblioteca['descricao'], $item);
        $item = str_replace('{categoria_id}', $biblioteca['categoria_id'], $item);
        $itens .= $item;
    }
    $listagem = file_get_contents('listagem_biblioteca.html');
    $listagem = str_replace('{itens}',$itens,$listagem);
    print($listagem);
     
?>