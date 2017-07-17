<?php
class CategoriaDAO {
    public function inserir($categoria){
        try {
            $sql = "INSERT INTO categoria (codigo, nome, icone) VALUES (NULL, :nome, :icone)";

            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":nome", $categoria->getNome());
            $p_sql->bindValue(":icone", $categoria->getIcone());
            return $p_sql->execute();
        } catch (Exception $e) {
            print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function getCategoria($codigo){
            try{
                $sql = "SELECT * FROM categoria WHERE codigo = :codigo";
                $p_sql = Conexao::getInstance()->prepare($sql);
                $p_sql->bindValue(":codigo", $codigo);
                $p_sql->execute();
                return $this->populaCategoria($p_sql->fetch(PDO::FETCH_ASSOC));
            }catch (Exception $e){
                print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
            }
        }

    public function listarCategorias(){
        try{
            $sql = "SELECT * FROM categoria";

            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            $arrayCat = array();
            foreach($p_sql->fetchAll() as $row){
                $arrayCat[] = $this->populaCategoria($row);
            }
            return $arrayCat;
        }catch (Exception $e){
            print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function BuscarPorCOD($cod) {
        try {
            $sql = "SELECT * FROM categoria WHERE codigo = :cod";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":cod", $cod);
            $p_sql->execute();
            return $this->populaCategoria($p_sql->fetch(PDO::FETCH_ASSOC));
        } catch (Exception $e) {
            print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }
    private function populaCategoria($row) {
        $pojo = new CategoriaENTITY();
        $pojo->setCodigo($row['codigo']);
        $pojo->setNome($row['nome']);
        $pojo->setIcone($row['icone']);
        return $pojo;
    }
}

?>