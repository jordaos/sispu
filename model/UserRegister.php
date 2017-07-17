<?php 
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class UserRegister{
	/**
	 * $form_data
	 *
	 * Os dados do formulário de envio.
	 *
	 * @access public
	 */	
	public $form_data;

	/**
	 * $form_msg
	 *
	 * As mensagens de feedback para o usuário.
	 *
	 * @access public
	 */	
	public $form_msg;



	/**
	 * Construtor
	 * 
	 * Carrega  o DB.
	 *
	 * @since 0.1
	 * @access public
	 */
	public function __construct() {
		//$this->instance = $instance;
	}

	/**
	 * Valida o formulário de envio
	 * 
	 * Este método pode inserir ou atualizar dados dependendo do campo de
	 * usuário.
	 *
	 * @since 0.1
	 * @access public
	 */
	public function validarDadosFormulario(){
	
		// Configura os dados do formulário
		$this->form_data = array();
		
		// Verifica se algo foi postado
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && ! empty ( $_POST ) ) {
		
			// Faz o loop dos dados do post
			foreach ( $_POST as $key => $value ) {
			
				// Configura os dados do post para a propriedade $form_data
				$this->form_data[$key] = $value;
				
				// Nós não permitiremos nenhum campos em branco
				if ( empty( $value ) ) {
					
					// Configura a mensagem
					$this->form_msg = '<p class="form_error">Existem campos em branco.</p>';
					
					// Termina
					return;
					
				}			
			
			}
		
		} else {
			// Termina se nada foi enviado
			return;
		}
		
		// Verifica se a propriedade $form_data foi preenchida
		if(empty($this->form_data)){
			return;
		}

		$UserDAO = new UserDAO();
		$usuario = $UserDAO->getUsuarioByEmail($this->form_data['email']);
		
		// Verifica se a consulta foi realizada com sucesso
		if (!$usuario) {
			$this->form_msg = '<p class="form_error">Erro ao cadastrar. Tente novamente..</p>';
			return;
		}
		
		// Configura o ID do usuário
		$user_id = $usuario->getCodigo();
		
		$password_hash = new PasswordHash(8, FALSE);
		
		// Cria o hash da senha
		$password = $password_hash->HashPassword($this->form_data['user_password']);

		
		// Se o ID do usuário não estiver vazio, atualiza os dados
		if (!empty( $user_id ) ) {
			$novoUsuario = new UserENTITY();
			$novoUsuario->setCodigo($usuario->getCodigo());
			$novoUsuario->setNome($this->form_data['user_name']);
			$novoUsuario->setSenha($password);
			$novoUsuario->setEmail($this->form_data['email']);
			$novoUsuario->setSessionID(md5(time()));

			$UserDAO->editarPerfil($novoUsuario);
			$this->form_data = null;
			$this->form_msg = '<p class="form_success">Usuário atualizado com sucesso.</p>';
		// Se o ID do usuário estiver vazio, insere os dados
		} else {
			// Executa a consulta 
			$novoUsuario = new UserENTITY();
			$novoUsuario->setNome($this->form_data['user_name']);
			$novoUsuario->setEmail($this->form_data['email']);
			$novoUsuario->setSenha($password);
			$novoUsuario->setDataCadastro(date("d/m/Y"));
			$novoUsuario->setSessionID(md5(time()));
			
			// Verifica se a consulta está OK e configura a mensagem
			if (!$UserDAO->adicionarUsuario($novoUsuario)) {
				$this->form_msg = '<p class="form_error">Um erro interno ocorreu. Tente novamente.</p>';

				// Termina
				return;
			} else {
				$this->form_msg = '<p class="form_success">Usuário cadastrado com sucesso.</p>';
				$this->form_data = null;
				
				// Termina
				return;
			}
		}
	} // validate_register_form
	
	/**
	 * Obtém os dados do formulário
	 * 
	 * Obtém os dados para usuários registrados
	 *
	 * @since 0.1
	 * @access public
	 */
	public function get_register_form ( $user_id = false ) {
		// O ID de usuário que vamos pesquisar
		$s_user_id = false;
		
		// Verifica se você enviou algum ID para o método
		if (!empty($user_id)){
			$s_user_id = (int)$user_id;
		}
		
		// Verifica se existe um ID de usuário
		if ( empty( $s_user_id ) ) {
			return;
		}
		$UserMenager = new UserMenager();
		$UserDAO = $UserMenager->getDAO();
		$usuario = $UserDAO->getUsuario($s_user_id);
		
		// Verifica a consulta
		if (!$usuario){
			$this->form_msg = '<p class="form_error">Usuário não existe.</p>';
			return;
		}
		
		// Verifica se os dados da consulta estão vazios
		if (empty($usuario->getEmail())){
			$this->form_msg = '<p class="form_error">Usuário não existe.</p>';
			return;
		}
		
		// Configura os dados do formulário
		$this->form_data['user_name'] = $usuario->getNome();
		$this->form_data['email'] = $usuario->getEmail();
		// Por questões de segurança, a senha só poderá ser atualizada
		$this->form_data['user_password'] = null;
		// Remove a serialização das permissões
		$this->form_data['user_nivel'] = $usuario->getNivel();
		// Separa as permissões por vírgula
	} // get_register_form
	
	/**
	 * Apaga usuários
	 * 
	 * @since 0.1
	 * @access public
	 */
	public function del_user($parametros = array()){

		// O ID do usuário
		$user_id = null;
		
		// Verifica se existe o parâmetro "del" na URL
		if ( chk_array( $parametros, 0 ) == 'del' ) {

			// Mostra uma mensagem de confirmação
			echo '<p class="alert">Tem certeza que deseja apagar este valor?</p>';
			echo '<p><a href="' . $_SERVER['REQUEST_URI'] . '/confirma">Sim</a> | 
			<a href="' . HOME_URI . '/UserRegister">Não</a> </p>';
			
			// Verifica se o valor do parâmetro é um número
			if ( 
				is_numeric( chk_array( $parametros, 1 ) )
				&& chk_array( $parametros, 2 ) == 'confirma' 
			) {
				// Configura o ID do usuário a ser apagado
				$user_id = chk_array( $parametros, 1 );
			}
		}
		
		// Verifica se o ID não está vazio
		if ( !empty( $user_id ) ) {
		
			// O ID precisa ser inteiro
			$user_id = (int)$user_id;
			
			// Deleta o usuário
			$UserMenager = new UserMenager();
			$UserDAO = $UserMenager->getDAO();
			$UserDAO->deletarUsuario($user_id);
			
			// Redireciona para a página de registros
			echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '/UserRegister/">';
			echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '/UserRegister/";</script>';
			return;
		}
	} // del_user
}