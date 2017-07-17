<?php
/**
 * LoginController - Controller de exemplo
 *
 * @package TutsupMVC
 * @since 0.1
 */
class LoginController extends Main
{

	/**
	 * Carrega a página "/view/login/index.php"
	 */
    public function index() {
		// Título da página
		$this->title = 'Login';
		
		// Parametros da função
		$parametros = ( func_num_args() >= 1 ) ? func_get_arg(0) : array();
	
		$modeloRegister = $this->load_model('UserRegister');
		
		/** Carrega os arquivos do view **/
		
		// /view/layouts/header.php
        require ABSPATH . '/view/login_register.view.php';
		
    } // index
	
} // class LoginController