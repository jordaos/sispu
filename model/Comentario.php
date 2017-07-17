<?php 
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class Comentario{
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
	public function validarDadosComentario(){
	
		// Configura os dados do formulário
		$this->form_data = array();
		
		// Verifica se algo foi postado
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST) && ($_POST['formname'] == 'comentario')) {
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

		$ComentarioDAO = new ComentarioDAO();

		$UserDAO = new UserDAO();
		$usuario = $UserDAO->getUsuario($_SESSION['userdata']['codigo']);

		$demandaDAO = new DemandaDAO();
		$demanda = $demandaDAO->getDemanda($this->form_data['demanda']);

		// Executa a consulta 
		$novoComentario = new ComentarioENTITY();
		$novoComentario->setUsuario($usuario);
		$novoComentario->setDemanda($demanda);
		$novoComentario->setMensagem($this->form_data['mensagem']);
		$novoComentario->setDataComentario(date("d/m/Y"));		
		
		// Verifica se a consulta está OK e configura a mensagem
		if (!$ComentarioDAO->inserir($novoComentario)) {
			$this->form_msg = '<p class="form_error">Um erro interno ocorreu. Tente novamente.</p>';
			// Termina
			return;
		} else {
			$this->form_msg = '<p class="form_success">Comentario enviado com sucesso.</p>';
			$this->form_data = null;
			// Termina
			return;
		}
	} // validarDadosFormulario

	public function listarComentarios(){
		$ComentarioDAO = new ComentarioDAO();
		return $ComentarioDAO->listaComentarios();
	}
	public function listarComentariosDemanda($demanda){
		$ComentarioDAO = new ComentarioDAO();
		return $ComentarioDAO->listaComentariosDemanda($demanda);
	}
}	

?>