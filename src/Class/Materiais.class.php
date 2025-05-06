<?php
require_once ("Database.class.php");
class usuario{
    private $id;
    private $titulo;
    private $descricao;
    private $tipo;
    private $url;
    private $data_publicacao;



    public function __construct($id,$titulo,$descricao,$tipo,$url,$data_publicacao){
        $this->id = $id;
        $this->titulo = $titulo;
        $this->descricao = $descricao;
        $this->tipo = $tipo;
        $this->url = $url;
        $this->data_publicacao = $data_publicacao;

    }

    public function setId($id){
        if ($id < 0)
            throw new Exception("Erro, o Id tem que ser maior que 0");
        else
            $this->id = $id;
    }
    public function setTitulo($titulo){
        if ($titulo == "")
            throw new Exception("Erro, o titulo deve ser informada!");
        else
            $this->titulo = $titulo;
    }
    public function setDescricao($descricao){
        if ($descricao == "")
            throw new Exception("Erro, a descricao deve ser informada!");
        else
            $this->descricao = $descricao;
    }
    public function setTipo($tipo){
        if ($tipo == "")
            throw new Exception("Erro, o tipo deve ser informada");
        else
            $this->tipo = $tipo;
    }
    public function setUrl($url){
            if ($url == "")
                throw new Exception("Erro, o url deve ser informada");
            else
                $this->url = $url;
    }
    public function setDataPublicacao($data_publicacao){
        if ($data_publicacao == "")
            throw new Exception("Erro, a data da publicacao deve ser informada");
        else
            $this->data_publicacao = $data_publicacao;
    }

    public function getId(): int{
        return $this->id;
    }
    public function getTitulo(): String{
        return $this->titulo;
    }
    public function getDescricao(): String{
        return $this->descricao;
    }
    public function getTipo(): String{
        return $this->tipo;
    }
    public function getUrl(): String{
        return $this->url;
    }
    public function getDataPublicacao(): String{
        return $this->data_publicacao;
    }


    public function __toString():String{  
        $str = " - Id: $this->id - Titulo: $this->titulo 
                 - Descricao: $this->descricao
                 - Tipo: $this->tipo
                 - Url: $this->url
                 - Data Publicacao: $this->data_publicacao";    
        return $str;
    }


    public function inserir():Bool{

        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "INSERT INTO materiais 
                    (titulo, descricao, tipo, url, data_publicacao)
                    VALUES(:titulo, :descricao, :tipo, :url, :data_publicacao)";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':titulo',$this->getTitulo());
        $comando->bindValue(':descricao',$this->getDescricao());
        $comando->bindValue(':tipo',$this->getTipo());
        $comando->bindValue(':url',$this->getUrl());
        $comando->bindValue(':data_publicacao',$this->getDataPublicacao());
        return $comando->execute();
    }

    public static function listar($tipo=0, $info=''):Array{
        

        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "SELECT * FROM materiais";
        if ($tipo > 0){
            switch ($tipo){
                case 1: $sql .= " WHERE id = :info ORDER BY id"; break; 
                case 2: $sql .= " WHERE titulo like :info ORDER BY titulo"; $info = '%'.$info.'%'; break;
                case 3: $sql .= " WHERE descricao like :info ORDER BY descricao"; $info = '%'.$info.'%'; break;
                case 4: $sql .= " WHERE tipo like :info ORDER BY tipo"; $info = '%'.$info.'%'; break;
                case 5: $sql .= " WHERE url like :info ORDER BY url"; $info = '%'.$info.'%'; break;
                case 6: $sql .= " WHERE data_publicacao like :info ORDER BY data_publicacao"; $info = '%'.$info.'%'; break;
            }
        }

        $comando = $conexao->prepare($sql);
        if ($tipo > 0)
            $comando->bindValue(':info',$info);
        $comando->execute();
        $resultado = $comando->fetchAll();
        return $resultado;
    }

    public function alterar():Bool{
       $sql = "UPDATE materiais
                  SET titulo = :titulo, 
                      descricao = :descricao,
                      tipo = :tipo,
                      url = :url,
                      data_publicacao = :data_publicacao
                WHERE id = :id";
        $parametros = array(':titulo'=>$this->getTitulo(),
                            ':descricao'=>$this->getDescricao(),
                            ':tipo'=>$this->getTipo(),
                            ':url'=>$this->getUrl(),
                            ':data_publicacao'=>$this->getDataPublicacao());
        return Database::executar($sql, $parametros) == true;
    }


    public function excluir():Bool{
        $conexao = new PDO(DSN, USUARIO, SENHA);
        $sql = "DELETE FROM materiais
                      WHERE id = :id";
        $comando = $conexao->prepare($sql);
        $comando->bindValue(':id',$this->getid());
        return $comando->execute();
     }
}
?>