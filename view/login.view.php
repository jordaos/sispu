<?php if ( ! defined('ABSPATH')) exit; ?>
<?php
	if ( $this->logged_in ) {
		echo '<meta http-equiv="Refresh" content="0; url=' . HOME_URI . '">';
		echo '<script type="text/javascript">window.location.href = "' . HOME_URI . '";</script>';
	}
?>

<div class="wrap">
	<form method="post">
		<table class="form-table">
			<tr>
				<td>User</td>
				<td><input name="userdata[user_email]"></td>
			</tr>
			<tr>
				<td>Password </td>
				<td><input type="password" name="userdata[user_password]"></td>
			</tr>
			<?php
			if ($this->login_error){
				echo '<tr><td colspan="2" class="error">' . $this->login_error . '</td></tr>';
			}
			?>
			<tr>
				<td colspan="2">
					<input type="submit" value="Enter">
				</td>
			</tr>
		</table>
	</form>
	
</div> <!-- .wrap -->