<?php

class ComentarioENTITY {

    private $codigo;
    private $demanda;
    private $usuario;
    private $mensagem;
    private $dataComentario;

    public function getCodigo() {
        return $this->codigo;
    }
    public function setCodigo($cod) {
        $this->codigo = $cod;
    }

    public function getDemanda() {
        return $this->demanda;
    }
    
    public function setDemanda($demanda) {
        $this->demanda = $demanda;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usu) {
        $this->usuario = $usu;
    }    

    public function getMensagem() {
        return $this->mensagem;
    }

    public function setMensagem($msg) {
        $this->mensagem = $msg;
    }

    public function getDataComentario() {
        return $this->dataComentario;
    }

    public function setDataComentario($data) {
        $this->dataComentario = $data;
    }
}

?>