<?php
class DemandaDAO {
    public function inserir($demanda) {
        try {
            $sql = "INSERT INTO demanda (
                codigo_categoria,
                codigo_usuario,
                rua,
                bairro,
                latitude,
                longitude,
                descricao,
                foto,
                dataDemanda)
                VALUES (
                :codigo_categoria,
                :codigo_usuario,
                :rua,
                :bairro,
                :latitude,
                :longitude,
                :descricao,
                :foto,
                :dataDemanda)";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":codigo_usuario", $demanda->getUsuario()->getCodigo());
            $p_sql->bindValue(":codigo_categoria", $demanda->getCategoria()->getCodigo());
            $p_sql->bindValue(":rua", $demanda->getRua());
            $p_sql->bindValue(":bairro", $demanda->getBairro());
            $p_sql->bindValue(":latitude", $demanda->getLatitude());
            $p_sql->bindValue(":longitude", $demanda->getLongitude());
            $p_sql->bindValue(":descricao", $demanda->getDescricao());
            $p_sql->bindValue(":foto", $demanda->getFoto());
            $p_sql->bindValue(":dataDemanda", $demanda->getDataDemanda());


            return $p_sql->execute();
        } catch (Exception $e) {
            print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function getDemanda($codigo){
        try{
            $sql = "SELECT * FROM demanda WHERE codigo = :codigo";
            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":codigo", $codigo);
            $p_sql->execute();
            return $this->populaDemanda($p_sql->fetch(PDO::FETCH_ASSOC));
        }catch (Exception $e){
            print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function listaDemandas(){
        try{
            $sql = "SELECT D.*, C.icone, COUNT(A.codigo_demanda) FROM categoria C, demanda D LEFT JOIN apoiar A ON A.codigo_demanda = D.codigo WHERE D.codigo_categoria = C.codigo GROUP BY D.codigo";

            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            return $p_sql->fetchAll();
        }catch (Exception $e){
            print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    private function populaDemanda($row) {
        $pojo = new DemandaENTITY();
        $pojo->setCodigo($row['codigo']);
        $pojo->setRua($row['rua']);
        $pojo->setBairro($row['bairro']);
        $pojo->setLatitude($row['latitude']);
        $pojo->setLongitude($row['longitude']);
        $pojo->setDataDemanda($row['dataDemanda']);
        $pojo->setFoto($row['foto']);
        $pojo->setDescricao($row['descricao']);

        $UserDAO = new UserDAO();
        $pojo->setUsuario($UserDAO->getUsuario($row['codigo']));
        $CategoriaDAO = new CategoriaDAO();
        $pojo->setCategoria($CategoriaDAO->getCategoria($row['codigo']));

        return $pojo;
    }
}

?>