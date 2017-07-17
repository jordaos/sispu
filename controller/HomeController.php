<?php
/**
 * home - Controller da página inicial
 *
 */
class HomeController extends Main
{

	/**
	 * Carrega a página "/views/home/index.php"
	 */
    public function index() {
		// Título da página
		$this->title = 'Home';
		
		// Parametros da função
		$parametros = (func_num_args() >= 1 ) ? func_get_arg(0) : array();
	
		// Essa página não precisa de modelo (model)
		
		/** Carrega os arquivos do view **/

		if ( $this->logged_in ) {
			$modeloDemanda = $this->load_model('Demanda');
			$modeloComentario = $this->load_model('Comentario');
			$modeloCategoria = $this->load_model('Categoria');
			$modeloApoiar = $this->load_model('Apoiar');
			
			require ABSPATH . '/view/Logged.view.php';
		}else{
			require ABSPATH . '/view/layouts/header.php';
			
			require ABSPATH . '/view/layouts/menu.php';
			
			require ABSPATH . '/view/Home.view.php';
			
			require ABSPATH . '/view/layouts/footer.php';
		}
		
    } // index
	
} // class HomeController