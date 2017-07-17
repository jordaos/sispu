<?php  
	class CategoriaENTITY{
		private $codigo;
		private $nome;
		private $icone;

		public function getCodigo(){
			return $this->codigo;
		}

		public function setCodigo($codigo){
			$this->codigo = $codigo;
		}

		public function getNome(){
			return $this->nome;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getIcone(){
			return $this->icone;
		}

		public function setIcone($icone){
			$this->icone = $icone;
		}
	}
?>