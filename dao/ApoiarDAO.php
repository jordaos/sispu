<?php
	class ApoiarDAO{
		public function apoiar($usuario, $demanda){
			try{
				$sql = "INSERT INTO apoiar(codigo_demanda, codigo_usuario) VALUES (:codigo_demanda, :codigo_usuario);";

				$p_sql = Conexao::getInstance()->prepare($sql);

				$p_sql->bindValue(":codigo_demanda", $demanda->getCodigo());
				$p_sql->bindValue(":codigo_usuario", $usuario->getCodigo());

				return $p_sql->execute();
			}catch (Exception $e){
				if($e->getCode() == 23000){
					print "Você já apoiou esta demanda";
				}else{
					print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
				}
			}
		}

		public function deixarDeApoiar($usuario, $demanda){
			try{
				$sql = "DELETE FROM apoiar WHERE codigo_demanda = :codigo_demanda AND codigo_usuario = :codigo_usuario;";

				$p_sql = Conexao::getInstance()->prepare($sql);
				$p_sql->bindValue(":codigo_demanda", $demanda->getCodigo());
				$p_sql->bindValue(":codigo_usuario", $usuario->getCodigo());
				return $p_sql->execute();
			}catch (Exception $e){
				print ("Erro! Código: " . $e->getCode() . " Mensagem: " . $e->getMessage());
			}
		}
	}
?>