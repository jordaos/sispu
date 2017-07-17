<?php 
/**
 * Classe para registros de usuários
 *
 * @package TutsupMVC
 * @since 0.1
 */

class Categoria{
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
		if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty($_POST) && ($_POST['formname'] == 'categoria')) {
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

		$CategoriaDAO = new CategoriaDAO();

		// Executa a consulta 
		$novaCategoria = new CategoriaENTITY();
		$novaCategoria->setNome($this->form_data['nome']);
		$novaCategoria->setIcone($imagem);
		
		// Verifica se a consulta está OK e configura a mensagem
		if (!$CategoriaDAO->inserir($novaCategoria)) {
			$this->form_msg = '<p class="form_error">Um erro interno ocorreu. Tente novamente.</p>';
			// Termina
			return;
		} else {
			$this->form_msg = '<p class="form_success">Categoria cadastrada com sucesso.</p>';
			$this->form_data = null;
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