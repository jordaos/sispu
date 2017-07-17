<?php
class UserENTITY {
	private $codigo;
	private $nome;
	private $email;
	private $senha;
	private $nivel;
	private $dataCadastro;
	private $sessionID;
	
	public function getCodigo(){
		return $this->codigo;
	}
	public function setCodigo($codigo){
		$this->codigo = (int)$codigo;
	}
	public function getNome(){
		return $this->nome;
	}
	public function setNome($nome){
		$this->nome = $nome;
	}
	public function getEmail(){
		return $this->email;
	}
	public function setEmail($email){
		$this->email = $email;
	}
	public function getSenha(){
		return $this->senha;
	}
	public function setSenha($senha){
		$this->senha = $senha;
	}
	public function getNivel(){
		return $this->nivel;
	}
	public function setNivel($nivel){
		$this->nivel = (int)$nivel;
	}
	public function getDataCadastro(){
		return $this->dataCadastro;
	}
	public function setDataCadastro($dataCadastro){
		$this->dataCadastro = $dataCadastro;
	}
	public function getSessionID(){
		return $this->sessionID;
	}
	public function setSessionID($sessionID){
		$this->sessionID = $sessionID;
	}
}
?>