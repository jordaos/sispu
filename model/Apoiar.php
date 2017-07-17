<?php 
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class Apoiar{
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
	public function Apoiar(){
		$parametros = array();
		if ( isset( $_GET['path'] ) ) {
			// Captura o valor de $_GET['path']
			$path = $_GET['path'];
			// Limpa os dados
			$path = rtrim($path, '/');
			$path = filter_var($path, FILTER_SANITIZE_URL);
			// Cria um array de parâmetros
			$path = explode('/', $path);

			// Configura os parâmetros
			if ( chk_array( $path, 2 ) ) {
				unset( $path[0] );

				// Os parâmetros sempre virão após a ação
				$parametros = array_values( $path );
			}
		}

		$codigoDemanda = 0;
		// Verifica se existe o parâmetro "del" na URL
		if ( chk_array( $parametros, 0 ) == 'apoiar' ) {
			// Verifica se o valor do parâmetro é um número
			if (is_numeric(chk_array($parametros, 1))){
				$codigoDemanda = chk_array($parametros, 1);
			}
		}
		
		// Verifica se a propriedade $form_data foi preenchida
		if(empty($codigoDemanda) || $codigoDemanda == 0){
			return;
		}

		$ApoiarDAO = new ApoiarDAO();

		$UserDAO = new UserDAO();
		$usuario = $UserDAO->getUsuario($_SESSION['userdata']['codigo']);

		$DemandaDAO = new DemandaDAO();
		$demanda = $DemandaDAO->getDemanda($codigoDemanda);
		
		// Verifica se a consulta está OK e configura a mensagem
		if (!$ApoiarDAO->apoiar($usuario, $demanda)) {
			$this->form_msg = '<p class="form_error">Um erro interno ocorreu. Tente novamente.</p>';
			header('Location: '.HOME_URI);
			// Termina
			return;
		} else {
			$this->form_msg = '<p>Apoiado!</p>';
			header('Location: '.HOME_URI);
			// Termina
			return;
		}
	} // validarDadosFormulario

	public function listarCategorias(){
		$CategoriaDAO = new CategoriaDAO();
		return $CategoriaDAO->listarCategorias();
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
            'image/png',
        );
        
        // Verifica se o mimetype enviado é permitido
        if ( ! in_array( $tipo_imagem, $permitir_tipos ) ) {
            // Retorna uma mensagem
            $this->form_msg = '<p class="error">Você deve enviar uma imagem.</p>';
            return;
        }
        
        // Tenta mover o arquivo enviado
        if ( ! move_uploaded_file( $tmp_imagem, UP_ICON_CATEG . '/' . $nome_imagem ) ) {
            // Retorna uma mensagem
            $this->form_msg = '<p class="error">Erro ao enviar imagem.</p>';
            return;
        }
        
        // Retorna o nome da imagem
        return $nome_imagem;
        
    } // upload_imagem
}