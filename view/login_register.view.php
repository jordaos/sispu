<?php if ( ! defined('ABSPATH')) exit; ?>
<?php
	if ( $this->logged_in ) {
		echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '";</script>';
	}

$modeloRegister->validarDadosFormulario();
?>

<html >
<head>
  <meta charset="UTF-8">
<title>SISPU</title>
      <link rel="stylesheet" href="<?php echo HOME_URI;?>/view/_css/login_register.css">
<script>
function retornoNome(){
    var nome = document.getElementById('nome').value;
	tamanhoNome= nome.length;
	if (tamanhoNome >= 1){
		document.getElementById('resultado').innerHTML = nome + "? Que belo nome o seu!";
	}
} 
function retornoUsuario(){
    var nome = document.getElementById('usuario').value;
	tamanhoUser = nome.length;
	if (tamanhoUser >= 1){
		document.getElementById('retornoUsuario').innerHTML = "Esse será seu login de acesso";
	}
} 

function retornoSenha(){
  var senha   = document.getElementById('senha').value;
  tamanhoSenha1 = senha.length;
  if (tamanhoSenha1 >= 1){
	if(tamanhoSenha1 > 8){
		document.getElementById('retornoSenha').innerHTML = "Sua senha é bem forte. Parabéns";   
	  }else{
		document.getElementById('retornoSenha').innerHTML = "Não acho que seja uma senha tão segura";   
	  }
  }
}

function retornoFile(){
	var file = document.getElementById('file').value;
	if(file != null || file !="" ){
		document.getElementById('retornoFile').innerHTML = "Que bela foto a sua :)"; 
	}
}

function retornoSenha2(){

	var senha1   = document.getElementById('senha').value;
	var senha2   = document.getElementById('senha2').value;
	tamanhoSenha2 = senha2.length;
	if (tamanhoSenha2 >= 1){
		if(senha1 != senha2){
			document.getElementById('retornoSenha2').innerHTML = "Senhas não são compatíveis. Verifique isso";   
		}else{
			document.getElementById('retornoSenha2').innerHTML = "Bom, falta pouco! Agora nos informe seu email no campo abaixo";  
		}
	}
}
function retornoEmail(){
	var txt   = document.getElementById('email').value;
	n = txt.length;
	if (n >= 1){
		    document.getElementById('retornoEmail').innerHTML = "Pronto! Agora verifique se todos os campos estão preenchidos corretamente. Se estiver tudo certo, você já pode criar sua conta.";   
	}

}
</script>

<style>  	  
.retorno{
color: #011aa5;
    font-size: 13px;
    float: left;
    margin-left: 3px;
    height: 15px;
	text-align:left;
}
.submit{
	    font-family: "Roboto", sans-serif;
    text-transform: uppercase;
    outline: 0;
    background: #29cafd;
    width: 100%;
    border: 0;
    padding: 15px;
    color: #FFFFFF;
    font-size: 14px;
    -webkit-transition: all 0.3 ease;
    transition: all 0.3 ease;
    cursor: pointer;
    margin-top: 33px;
}
</style>  	  
</head>

<body>
<center>

  <div class="login-page">
  <div class="form">
  <img src="<?php echo HOME_URI;?>/view/_img/sispu.png" class="logo"/>
    <form class="register-form" method="post" action="" enctype="multipart/form-data">
    	<h2>Registre-se</h2>
		<div id="resultado" class="retorno" ></div>			  
		<input type="text" name="user_name" id="nome" onblur="retornoNome()" required placeholder="Nome"/>
		  
		<div id="retornoSenha" class="retorno" ></div>			  
		<input type="password" name="user_password" id="senha" onblur="retornoSenha()" required placeholder="Senha"/>
	  
	  	<div id="retornoSenha2" class="retorno" ></div>			  
		<input type="password" name="senha2" id="senha2" onblur="retornoSenha2()" required placeholder="Confirmar senha"/>

		<input type="email" name="email" id="email" onblur="retornoEmail()" required placeholder="Endereço de email"/>
	  	<div id="retornoEmail" class="retorno" style="color:red;" ></div>
		
		
		<input type="submit" class="submit" style="margin-top: 40px; background: #29cafd;" value="Criar"/>
		<p class="message">Já é registrado? <a href="#"> Faça login aqui</a></p>
    </form>
    <form class="login-form" method="post">
    	<h2>Entrar</h2>
      <input type="text" name= "userdata[user_email]" placeholder="E-mail"/>
      <input type="password" name="userdata[user_password]" placeholder="Senha"/>
      <button>Login</button>
      <p class="message">Ainda não tem uma conta/ <a href="#"> Cadastra-se no sistema aqui</a></p>
    </form>

  </div>
</div>
</center>

 	<script src="<?php echo HOME_URI;?>/view/_js/jquery.min.js"></script>

    <script src="<?php echo HOME_URI;?>/view/_js/login_register.js"></script>

</body>
</html>
