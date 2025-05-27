<?php
require_once("Database.class.php");

class Materiais {
    private $id;
    private $titulo;
    private $descricao;
    private $tipo;
    private $url;
    private $categoria_id;
    private $biblioteca_id;

    public function __construct($id = null, $titulo = "", $descricao = "", $tipo = "", $url = "", $categoria_id = null, $biblioteca_id = null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->tipo = $tipo;
        $this->url = $url;
        $this->categoria_id = $categoria_id;
        $this->biblioteca_id = $biblioteca_id;
    }

    // Setters
    public function setId($id) {
        if ($id < 0) throw new Exception("Id inválido");
        $this->id = $id;
    }
    public function setTitulo($titulo) {
        if (empty($titulo)) throw new Exception("Título obrigatório");
        $this->titulo = $titulo;
    }
    public function setDescricao($descricao) {
        if (empty($descricao)) throw new Exception("Descrição obrigatória");
        $this->descricao = $descricao;
    }
    public function setTipo($tipo) {
        $tipos = ['ebook', 'video', 'artigo'];
        if (!in_array($tipo, $tipos)) throw new Exception("Tipo inválido");
        $this->tipo = $tipo;
    }
    public function setUrl($url) {
        if (empty($url)) throw new Exception("URL obrigatória");
        $this->url = $url;
    }
    public function setCategoriaId($categoria_id) {
        if ($categoria_id < 0) throw new Exception("Categoria inválida");
        $this->categoria_id = $categoria_id;
    }
    public function setBibliotecaId($biblioteca_id) {
        if ($biblioteca_id < 0) throw new Exception("Biblioteca inválida");
        $this->biblioteca_id = $biblioteca_id;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getDescricao() { return $this->descricao; }
    public function getTipo() { return $this->tipo; }
    public function getUrl() { return $this->url; }
    public function getCategoriaId() { return $this->categoria_id; }
    public function getBibliotecaId() { return $this->biblioteca_id; }

    public function __toString() {
        return "Id: $this->id - Título: $this->titulo - Descrição: $this->descricao - Tipo: $this->tipo - URL: $this->url - Categoria: $this->categoria_id - Biblioteca: $this->biblioteca_id";
    }

    // CRUD
    public function inserir() {
        $conexao = new PDO(DSN, USUARIO, SENHA);
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
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "SELECT * FROM Materiais";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1: $sql .= " WHERE id = :info ORDER BY id"; break;
                case 2: $sql .= " WHERE titulo LIKE :info ORDER BY titulo"; $info = '%'.$info.'%'; break;
                case 3: $sql .= " WHERE descricao LIKE :info ORDER BY descricao"; $info = '%'.$info.'%'; break;
                case 4: $sql .= " WHERE tipo = :info ORDER BY tipo"; break;
                case 5: $sql .= " WHERE url LIKE :info ORDER BY url"; $info = '%'.$info.'%'; break;
                case 6: /* data_publicacao removido */ break;
                case 7: /* autor_id removido */ break;
                case 8: $sql .= " WHERE categoria_id = :info ORDER BY categoria_id"; break;
            }
        }
        $comando = $conexao->prepare($sql);
        if ($tipo > 0 && in_array($tipo, [1,2,3,4,5,8])) $comando->bindValue(':info', $info);
        $comando->execute();
        return $comando->fetchAll(PDO::FETCH_ASSOC);
    }

    public function alterar() {
        $conexao = new PDO(DSN, USUARIO, SENHA);
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
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "DELETE FROM Materiais WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }
}
?>
