<?php
	class UserDAO{
		public function adicionarUsuario($usuario){
			try{
				$sql = "INSERT INTO usuario(codigo, nome, email, senha, dataCadastro, session_id) VALUES (NULL, :nome, :email, :senha, :dataCadastro, :session_id);";

				$p_sql = Conexao::getInstance()->prepare($sql);

				$p_sql->bindValue(":nome", $usuario->getNome());
				$p_sql->bindValue(":email", $usuario->getEmail());
				$p_sql->bindValue(":senha", $usuario->getSenha());
				$p_sql->bindValue(":dataCadastro", $usuario->getDataCadastro());
				$p_sql->bindValue(":session_id", $usuario->getSessionID());

				return $p_sql->execute();
			}catch (Exception $e){
				print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function deletarUsuario($codigo){
			try{
				$sql = "DELETE FROM usuario WHERE codigo = :codigo";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":codigo", $codigo);
				return $p_sql->execute();
			}catch (Exception $e){
				print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function listarUsuarios(){
			try{
				$sql = "SELECT * FROM usuario";
				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->execute();
				$arrayUsers = array();
				foreach($p_sql->fetchAll() as $row){
					$arrayUsers[] = $this->populaUsuario($row);
				}
				return $arrayUsers;
			}catch (Exception $e){
	        	print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function getUsuario($codigo){
			try{
				$sql = "SELECT * FROM usuario WHERE codigo = :codigo";
				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":codigo", $codigo);
				$p_sql->execute();
				return $this->populaUsuario($p_sql->fetch(PDO::FETCH_ASSOC));
			}catch (Exception $e){
				print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function getUsuarioByEmail($email){
			try{
				$sql = "SELECT * FROM usuario WHERE email = :email";
				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":email", $email);
				$p_sql->execute();
				return $this->populaUsuario($p_sql->fetch(PDO::FETCH_ASSOC));
			}catch (Exception $e){
				print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function getUserFetch($email){
			try{
				$sql = "SELECT * FROM usuario WHERE email = :email";
				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":email", $email);
				$p_sql->execute();
				return ($p_sql->fetch(PDO::FETCH_ASSOC));
			}catch (Exception $e){
				print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function setSessionID($codigo, $session_id){
			try{
				$sql = "UPDATE usuario SET session_id = :session_id WHERE codigo = :codigo";
				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":session_id", $session_id);
				$p_sql->bindValue(":codigo", $codigo);
				return $p_sql->execute();
			}catch (Exception $e){
				print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		public function autentica($email, $senha){
			$sql = "SELECT email, senha FROM usuario WHERE email = :email AND senha = :senha";

			$p_sql = Conexao::getInstance()->prepare($sql);
			$p_sql->bindValue(":email", $email);
			$p_sql->bindValue(":senha", $senha);
			$p_sql->execute();

			$row_cnt = $sql->num_rows;
			if($row_cnt == 1){
				return true;
			}
			return false;
		}

		public function editarPerfil($usuario){
			try{
				$sql = "UPDATE usuario SET nome = :nome, email = :email, senha = :senha, nivel = :nivel, session_id = :session_id WHERE codigo = :codigo";
				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":nome", $usuario->getNome());
				$p_sql->bindValue(":email", $usuario->getEmail());
				$p_sql->bindValue(":senha", $usuario->getSenha());
				$p_sql->bindValue(":nivel", $usuario->getNivel());
				$p_sql->bindValue(":session_id", $usuario->getSessionID());
				return $p_sql->execute();
			}catch (Exception $e){
				print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}

		private function populaUsuario($row) {
	    	$pojo = new UserENTITY();
	    	$pojo->setCodigo($row['codigo']);
	    	$pojo->setNome($row['nome']);
	    	$pojo->setEmail($row['email']);
	    	$pojo->setSenha($row['senha']);
	    	$pojo->setNivel($row['nivel']);
	    	$pojo->setDataCadastro($row['dataCadastro']);
	    	$pojo->setSessionID($row['session_id']);
	    	return $pojo;
		}
	}
?>