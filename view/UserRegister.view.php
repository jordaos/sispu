<?php 
if ( ! defined('ABSPATH')) exit;
// Carrega todos os métodos do modelo
$modelo->validarDadosFormulario();
?>
<div class="wrap">

<form method="post" action="" enctype="multipart/form-data">
	<table class="form-table">
		<tr>
			<td>Nome: </td>
			<td> <input type="text" name="user_name" value="<?php 
				echo htmlentities(chk_array($modelo->form_data, 'user_name'));
				?>" /></td>
		</tr>
		<tr>
			<td>E-mail: </td>
			<td> <input type="text" name="email" value="<?php
				echo htmlentities( chk_array( $modelo->form_data, 'email') );
			?>" /></td>
		</tr>
		<tr>
			<td>Password: </td>
			<td> <input type="password" name="user_password" value="<?php
			echo htmlentities( chk_array( $modelo->form_data, 'user_password') );
			?>" /></td>
		</tr>
		<tr>
			<td>Nível: </td>
			<td> <input type="number" name="user_nivel" value="<?php
				echo htmlentities(chk_array( $modelo->form_data, 'user_nivel') );
			?>" /></td>
		</tr>
		<tr>
			<td colspan="2">
				<?php echo $modelo->form_msg;?>
				<input type="submit" value="Save" />
				<a href="<?php echo HOME_URI . '/UserRegister';?>">New user</a>
			</td>
		</tr>
	</table>
</form>
</div> <!-- .wrap -->