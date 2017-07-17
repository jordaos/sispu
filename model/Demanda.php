<?php 
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class Demanda{
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
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST) && ($_POST['formname'] == 'demanda')) {
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

		// Tenta enviar a imagem
        $imagem = $this->upload_imagem();
        // Verifica se a imagem foi enviada
        if (!$imagem){
            $this->form_msg = '<p class="form_error">Erro ao enviar imagem.</p>';
            return;     
        }

		$DemandaDAO = new DemandaDAO();

		$UserDAO = new UserDAO();
		$usuario = $UserDAO->getUsuario($_SESSION['userdata']['codigo']);

		$categoriaDAO = new CategoriaDAO();
		$categoria = $categoriaDAO->getCategoria($this->form_data['categoria']);

		// Executa a consulta 
		$novaDemanda = new DemandaENTITY();
		$novaDemanda->setUsuario($usuario);
		$novaDemanda->setCategoria($categoria);
		$novaDemanda->setBairro($this->form_data['bairro']);
		$novaDemanda->setRua($this->form_data['rua']);
		$novaDemanda->setLatitude($this->form_data['latitude']);
		$novaDemanda->setLongitude($this->form_data['longitude']);
		$novaDemanda->setDescricao($this->form_data['descricao']);
		$novaDemanda->setFoto($imagem);
		$novaDemanda->setDataDemanda(date("d/m/Y"));
		
		
		// Verifica se a consulta está OK e configura a mensagem
		if (!$DemandaDAO->inserir($novaDemanda)) {
			$this->form_msg = '<p class="form_error">Um erro interno ocorreu. Tente novamente.</p>';
			// Termina
			return;
		} else {
			$this->form_msg = '<p class="form_success">Demanda cadastrada com sucesso.</p>';
			$this->form_data = null;
			// Termina
			return;
		}
	} // validarDadosFormulario

	public function listaDemandas(){
		$DemandaDAO = new DemandaDAO();
		return $DemandaDAO->listaDemandas();
	}


	public function upload_imagem() {
    
        // Verifica se o arquivo da imagem existe
        if ( empty( $_FILES['imagem'] ) ) {
            return;
        }
        
        // Configura os dados da imagem
        $imagem = $_FILES['imagem'];
        
        // Nome e extensão
        $nome_imagem    = strtolower( $imagem['name'] );
        $ext_imagem     = explode( '.', $nome_imagem );
        $ext_imagem     = end( $ext_imagem );
        $nome_imagem    = preg_replace( '/[^a-zA-Z0-9]/', '', $nome_imagem);
        $nome_imagem   .= '_' . mt_rand() . '.' . $ext_imagem;
        
        // Tipo, nome temporário, erro e tamanho
        $tipo_imagem    = $imagem['type'];
        $tmp_imagem     = $imagem['tmp_name'];
        $erro_imagem    = $imagem['error'];
        $tamanho_imagem = $imagem['size'];
        
        // Os mime types permitidos
        $permitir_tipos  = array(
            'image/bmp',
            'image/gif',
            'image/jpeg',
            'image/pjpeg',
            'image/png',
        );
        
        // Verifica se o mimetype enviado é permitido
        if ( ! in_array( $tipo_imagem, $permitir_tipos ) ) {
            // Retorna uma mensagem
            $this->form_msg = '<p class="error">Você deve enviar uma imagem.</p>';
            return;
        }
        
        // Tenta mover o arquivo enviado
        if ( ! move_uploaded_file( $tmp_imagem, UP_ABSPATH . '/' . $nome_imagem ) ) {
            // Retorna uma mensagem
            $this->form_msg = '<p class="error">Erro ao enviar imagem.</p>';
            return;
        }
        
        // Retorna o nome da imagem
        return $nome_imagem;
        
    } // upload_imagem
}