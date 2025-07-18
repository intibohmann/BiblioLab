<?php
require_once(__DIR__ . '/../Core/Database.class.php');



class Biblioteca {
    private $id;
    private $titulo;
    private $descricao;
    private $categoria_id;

    public function __construct($id = null, $titulo = "", $descricao = "", $categoria_id = null) {
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->categoria_id = $categoria_id;
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
    public function setCategoriaId($categoria_id) {
        if ($categoria_id < 0) throw new Exception("Categoria inválida");
        $this->categoria_id = $categoria_id;
    }

    // Getters
    public function getId() { return $this->id; }
    public function getTitulo() { return $this->titulo; }
    public function getDescricao() { return $this->descricao; }
    public function getCategoriaId() { return $this->categoria_id; }

    public function __toString() {
        return "Id: $this->id - Título: $this->titulo - Descrição: $this->descricao - Categoria: $this->categoria_id";
    }

    // CRUD
    public function inserir() {
        $conexao = new PDO(DSN, username: DB_USER, password: DB_PASSWORD);
        // Verifica se categoria existe
        $catStmt = $conexao->prepare("SELECT COUNT(*) FROM categorias WHERE id = :categoria_id");
        $catStmt->bindValue(':categoria_id', $this->getCategoriaId(), PDO::PARAM_INT);
        $catStmt->execute();
        $categoriaExiste = $catStmt->fetchColumn();
        if (!$categoriaExiste) {
            throw new Exception("Categoria informada não existe. ID informado: " . $this->getCategoriaId());
        }
        $sql = "INSERT INTO Biblioteca (titulo, descricao, categoria_id)
                VALUES (:titulo, :descricao, :categoria_id)";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':titulo', $this->getTitulo());
        $comando->bindValue(':descricao', $this->getDescricao());
        $comando->bindValue(':categoria_id', $this->getCategoriaId());
        return $comando->execute();
    }

    public static function listar($tipo = 0, $info = '') {
        $conexao = new PDO(DSN,  username: DB_USER, password: DB_PASSWORD);
        $sql = "SELECT * FROM Biblioteca";
        if ($tipo > 0) {
            switch ($tipo) {
                case 1: $sql .= " WHERE id = :info ORDER BY id"; break;
                case 2: $sql .= " WHERE titulo LIKE :info ORDER BY titulo"; $info = '%'.$info.'%'; break;
                case 3: $sql .= " WHERE descricao LIKE :info ORDER BY descricao"; $info = '%'.$info.'%'; break;
                case 4: $sql .= " WHERE categoria_id = :info ORDER BY categoria_id"; break;
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
        $conexao = new PDO(DSN,  username: DB_USER, password: DB_PASSWORD);

        // Garante que categoria_id é um inteiro
        $categoriaId = $this->getCategoriaId();
        if (!is_numeric($categoriaId) || intval($categoriaId) != $categoriaId) {
            throw new Exception("Categoria informada deve ser um ID numérico. Valor informado: " . $categoriaId);
        }
        $categoriaId = intval($categoriaId);

        // Verifica se categoria existe
        $catStmt = $conexao->prepare("SELECT COUNT(*) FROM categorias WHERE id = :categoria_id");
        $catStmt->bindValue(':categoria_id', $categoriaId, PDO::PARAM_INT);
        $catStmt->execute();
        $categoriaExiste = $catStmt->fetchColumn();
        if (!$categoriaExiste) {
            throw new Exception("Categoria informada não existe. ID informado: " . $categoriaId);
        }

        $sql = "UPDATE Biblioteca SET
                    titulo = :titulo,
                    descricao = :descricao,
                    categoria_id = :categoria_id
                WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':titulo', $this->getTitulo());
        $comando->bindValue(':descricao', $this->getDescricao());
        $comando->bindValue(':categoria_id', $categoriaId);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }

    public function excluir() {
        $conexao = new PDO(DSN, username: DB_USER, password: DB_PASSWORD);
        $sql = "DELETE FROM Biblioteca WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id', $this->getId());
        return $comando->execute();
    }
}
?>
