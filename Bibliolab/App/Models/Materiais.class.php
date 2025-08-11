<?php
require_once(__DIR__ . '/../Core/Database.class.php');
require_once('Biblioteca.class.php');

class Materiais extends Biblioteca {
    private $tipo;
    private $url;
    private $biblioteca_id;

    public function __construct($id = null, $titulo = "", $descricao = "", $tipo = "", $url = "", $categoria_id = null, $biblioteca_id = null) {
        parent::__construct($id, $titulo, $descricao, $categoria_id);
        $this->tipo = $tipo;
        $this->url = $url;
        $this->biblioteca_id = $biblioteca_id;
    }

    // Setters e Getters adicionais
    public function setTipo($tipo) {
        $tipos = ['ebook', 'video', 'artigo'];
        if (!in_array($tipo, $tipos)) throw new Exception("Tipo inválido");
        $this->tipo = $tipo;
    }
    public function getTipo() { return $this->tipo; }

    public function setUrl($url) {
        if (empty($url)) throw new Exception("URL obrigatória");
        $this->url = $url;
    }
    public function getUrl() { return $this->url; }

    public function setBibliotecaId($biblioteca_id) {
        if ($biblioteca_id < 0) throw new Exception("Biblioteca inválida");
        $this->biblioteca_id = $biblioteca_id;
    }
    public function getBibliotecaId() { return $this->biblioteca_id; }

    public function __toString() {
        return parent::__toString() . " - Tipo: $this->tipo - URL: $this->url - Biblioteca: $this->biblioteca_id";
    }

    public function inserir() {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "INSERT INTO Materiais (titulo, descricao, tipo, url, categoria_id, biblioteca_id)
                VALUES (:titulo, :descricao, :tipo, :url, :categoria_id, :biblioteca_id)";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':titulo', $this->getTitulo());
        $comando->bindValue(':descricao', $this->getDescricao());
        $comando->bindValue(':tipo', $this->getTipo());
        $comando->bindValue(':url', $this->getUrl());
        $comando->bindValue(':categoria_id', $this->getCategoriaId());
        $comando->bindValue(':biblioteca_id', $this->getBibliotecaId());
        return $comando->execute();
    }

    public static function listar($tipo = 0, $info = '') {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "SELECT m.id, m.titulo, m.descricao, m.tipo, m.url,
                       c.nome AS categoria_nome,
                       b.titulo AS biblioteca_nome
                FROM Materiais m
                JOIN Categorias c ON m.categoria_id = c.id
                JOIN Biblioteca b ON m.biblioteca_id = b.id";

        if ($tipo > 0) {
            switch ($tipo) {
                case 1: $sql .= " WHERE m.id = :info ORDER BY m.id"; break;
                case 2: $sql .= " WHERE m.titulo LIKE :info ORDER BY m.titulo"; $info = '%' . $info . '%'; break;
                case 3: $sql .= " WHERE m.descricao LIKE :info ORDER BY m.descricao"; $info = '%' . $info . '%'; break;
                case 4: $sql .= " WHERE m.tipo = :info ORDER BY m.tipo"; break;
                case 5: $sql .= " WHERE m.url LIKE :info ORDER BY m.url"; $info = '%' . $info . '%'; break;
                case 8: $sql .= " WHERE m.categoria_id = :info ORDER BY c.nome"; break;
            }
        }

        $comando = $conexao->prepare($sql);
        if ($tipo > 0) {
            $comando->bindValue(':info', $info);
        }
        $comando->execute();
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterar() {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "UPDATE Materiais SET
                    titulo = :titulo,
                    descricao = :descricao,
                    tipo = :tipo,
                    url = :url,
                    categoria_id = :categoria_id,
                    biblioteca_id = :biblioteca_id
                WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':titulo', $this->getTitulo());
        $comando->bindValue(':descricao', $this->getDescricao());
        $comando->bindValue(':tipo', $this->getTipo());
        $comando->bindValue(':url', $this->getUrl());
        $comando->bindValue(':categoria_id', $this->getCategoriaId());
        $comando->bindValue(':biblioteca_id', $this->getBibliotecaId());
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function excluir() {
        $conexao = new PDO(DSN, DB_USER, DB_PASSWORD);
        $sql = "DELETE FROM Materiais WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }
}
?>

