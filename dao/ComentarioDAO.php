<?php
class ComentarioDAO {
    public function inserir($comentario) {
        try {
            $sql = "INSERT INTO comentario (
                codigo_demanda,
                codigo_usuario,
                mensagem,
                dataComentario)
                VALUES (
                :codigo_demanda,
                :codigo_usuario,
                :mensagem,
                :dataComentario)";

            $p_sql = Conexao::getInstance()->prepare($sql);

            $p_sql->bindValue(":codigo_usuario", $comentario->getUsuario()->getCodigo());
            $p_sql->bindValue(":codigo_demanda", $comentario->getDemanda()->getCodigo());
            $p_sql->bindValue(":mensagem", $comentario->getMensagem());
            $p_sql->bindValue(":dataComentario", $comentario->getDataComentario());

            return $p_sql->execute();
        } catch (Exception $e) {
            print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function listaComentarios(){
        try{
            $sql = "SELECT C.*, U.nome FROM comentario C, usuario U WHERE C.codigo_usuario = U.codigo;";

            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->execute();
            return $p_sql->fetchAll();
        }catch (Exception $e){
            print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    public function listaComentariosDemanda($demanda){
        try{
            $sql = "SELECT C.*, U.nome FROM comentario C, usuario U WHERE C.codigo_usuario = U.codigo AND C.codigo_demanda = :demanda;";

            $p_sql = Conexao::getInstance()->prepare($sql);
            $p_sql->bindValue(":demanda", $demanda);
            $p_sql->execute();
            return $p_sql->fetchAll();
        }catch (Exception $e){
            print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
        }
    }

    private function populaComentario($row) {
        $pojo = new ComentarioENTITY();
        $pojo->setCodigo($row['codigo']);
        $pojo->setMensagem($row['mensagem']);
        $pojo->setDataComentario($row['dataComentario']);

        $UserDAO = new UserDAO();
        $pojo->setUsuario($UserDAO->getUsuario($row['codigo']));
        $demandaDAO = new DemandaDAO();
        $pojo->setDemanda($demandaDAO->getDemanda($row['codigo']));

        return $pojo;
    }
}

?>