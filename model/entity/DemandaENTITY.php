<?php

class DemandaENTITY {

    private $codigo;
    private $categoria;
    private $usuario;
    private $rua;
    private $bairro;
    private $latitude;
    private $longitude;
    private $descricao;
    private $foto;
    private $dataDemanda;

    public function getCodigo() {
        return $this->codigo;
    }
    public function setCodigo($cod) {
        $this->codigo = $cod;
    }

    public function getCategoria() {
        return $this->categoria;
    }
    public function setCategoria($cat) {
        $this->categoria = $cat;
    }

    public function getUsuario() {
        return $this->usuario;
    }

    public function setUsuario($usu) {
        $this->usuario = $usu;
    }    

    public function getRua() {
        return $this->rua;
    }

    public function setRua($rua) {
        $this->rua = $rua;
    }

    public function getBairro() {
        return $this->bairro;
    }

    public function setBairro($bairro) {
        $this->bairro = $bairro;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function setLatitude($lat) {
        $this->latitude = $lat;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function setLongitude($long) {
        $this->longitude = $long;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($desc) {
        $this->descricao = $desc;
    }

    public function getFoto() {
        return $this->foto;
    }

    public function setFoto($foto) {
        $this->foto = $foto;
    }

    public function getDataDemanda() {
        return $this->dataDemanda;
    }

    public function setDataDemanda($data) {
        $this->dataDemanda = $data;
    }
}

?>