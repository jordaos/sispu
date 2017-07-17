<?php
/**
 * Configuração geral
 */

// Caminho para a raiz
define( 'ABSPATH', dirname( __FILE__ ) );

// Caminho para a pasta de uploads
define( 'UP_ABSPATH', ABSPATH . '/view/_uploads' );

// Caminho para a pasta de uploads de icones das categorias
define( 'UP_ICON_CATEG', ABSPATH . '/view/_uploads/icons' );

// URL da home
define( 'HOME_URI', 'http://localhost/sispu' );

//ULR do caminho de arquivos de UPLOAD
define( 'UPLOAD_URI', HOME_URI . '/view/_uploads' );

//ULR do caminho de arquivos de UPLOAD
define( 'CATEGORIAS_URI', HOME_URI . '/view/_uploads/icons' );

// Nome do host da base de dados
define( 'HOSTNAME', 'localhost' );

// Nome do DB
define( 'DB_NAME', 'sispu' );

// Usuário do DB
define( 'DB_USER', 'root' );

// Senha do DB
define( 'DB_PASSWORD', '12345678' );

// Charset da conexão PDO
define( 'DB_CHARSET', 'utf8' );

// Se você estiver desenvolvendo, modifique o valor para true
define( 'DEBUG', true );

/**
 * Não edite daqui em diante
 */
// Carrega o loader, que vai carregar a aplicação inteira
require_once ABSPATH . '/loader.php';
?>