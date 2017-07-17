<?php
/**
 * UserRegisterController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class RegisterController extends Main
{

	/**
	 * $login_required
	 *
	 * Se a página precisa de login
	 *
	 * @access public
	 */
	public $login_required = true;

	/**
	 * Carrega a página "/view/user-register/index.php"
	 */
    public function index() {
		// Page title
		$this->title = 'Cadastro de usuários';
	
		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
	
		// Carrega o modelo para este view
        $modeloRegister = $this->load_model('UserRegister');

		/** Carrega os arquivos do view **/
		
		// /view/layouts/header.php
        require ABSPATH . '/view/login_register.view.php';
		
    } // index
	
} // class home