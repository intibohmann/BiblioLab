<?php
require_once('../Models/Materiais.class.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        $id = !empty($_POST['id']) ? (int)$_POST['id'] : null;
        $titulo = $_POST["titulo"];
        $descricao = $_POST["descricao"];
        $tipo = $_POST["tipo"];
        $categoria_id = $_POST["categoria_id"];
        $biblioteca_id = $_POST["biblioteca_id"];
        $origem = $_POST["origem"];
        $url = "";

        // Trata origem do material
        if ($origem === 'link') {
            if (!empty($_POST["url"])) {
                $url = filter_var($_POST["url"], FILTER_VALIDATE_URL);
                if (!$url) throw new Exception("URL inválida.");
            } else {
                throw new Exception("URL não fornecida.");
            }
        } elseif ($origem === 'arquivo') {
            $arquivoExistente = !empty($_POST['arquivo_existente']) ? $_POST['arquivo_existente'] : null;

            if (isset($_FILES["arquivo_pdf"]) && $_FILES["arquivo_pdf"]["error"] === UPLOAD_ERR_OK) {
                $arquivoTmp = $_FILES["arquivo_pdf"]["tmp_name"];
                $nomeArquivo = basename($_FILES["arquivo_pdf"]["name"]);
                $ext = strtolower(pathinfo($nomeArquivo, PATHINFO_EXTENSION));

                if ($ext !== "pdf") throw new Exception("Apenas arquivos PDF são permitidos.");

                $mime = mime_content_type($arquivoTmp);
                if ($mime !== 'application/pdf') throw new Exception("O arquivo enviado não é um PDF válido.");

                if ($_FILES["arquivo_pdf"]["size"] > 5 * 1024 * 1024)
                    throw new Exception("O arquivo PDF não pode ultrapassar 5MB.");

                $diretorioUpload = realpath(__DIR__ . "/../../Public/assets/pdf");
                if (!$diretorioUpload) {
                    mkdir(__DIR__ . "/../../Public/assets/pdf", 0777, true);
                    $diretorioUpload = realpath(__DIR__ . "/../../Public/assets/pdf");
                }

                $novoNomeArquivo = bin2hex(random_bytes(8)) . "-" .
                    preg_replace('/[^a-zA-Z0-9_\.-]/', '_', pathinfo($nomeArquivo, PATHINFO_FILENAME)) .
                    ".pdf";

                $destino = $diretorioUpload . "/" . $novoNomeArquivo;

                if (!move_uploaded_file($arquivoTmp, $destino)) {
                    throw new Exception("Erro ao mover o arquivo enviado.");
                }

                $url = "assets/pdf/" . $novoNomeArquivo;
            } elseif ($arquivoExistente) {
                // mantém arquivo existente
                $url = $arquivoExistente;
            } else {
                throw new Exception("Arquivo PDF não foi enviado corretamente.");
            }
        } else {
            throw new Exception("Origem do material inválida.");
        }

        // Cria objeto Material
        $material = new Materiais();
        if ($id) $material->setId($id);

        $material->setTitulo($titulo);
        $material->setDescricao($descricao);
        $material->setTipo($tipo);
        $material->setUrl($url);
        $material->setCategoriaId($categoria_id);
        $material->setBibliotecaId($biblioteca_id);

        // Salva ou altera
        if ($material->salvarOuAlterar()) {
           header("Location: /Bibliolab/Bibliolab/App/views/biblioteca.php?id=" . $biblioteca_id);
            exit;
        } else {
            echo "<div class='alert alert-danger m-4'>Erro ao salvar material. <a href='../Views/cadastro_material.php'>Tentar novamente</a></div>";
        }

    } catch (Exception $e) {
        echo "<div class='alert alert-danger m-4'>Erro: " . htmlspecialchars($e->getMessage()) . "</div>";
    }
} else {
    echo "<div class='alert alert-warning m-4'>Método inválido</div>";
}
?>
