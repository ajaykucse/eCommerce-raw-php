<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/E-commerce/core/init.php';
if(!is_logged_in()){
	login_error_redirect();
}
include 'includes/head.php';

$hashed = $user_data['password'];
$old_password = ((isset($_POST['old_password']))?sanitize($_POST['old_password']):'');
$old_password = trim($old_password);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
$confirm = trim($confirm);
$new_hashed = password_hash($password, PASSWORD_DEFAULT);
$user_id = $user_data['id'];
$errors = array();
?>
<style>
	
</style>
<div id="login-form">
	<div>
		<?php
			if($_POST){
				//form validation
			if(empty($_POST['old_password'])|| empty($_POST['password']) || empty($_POST['confirm'])){
				$errors[] = 'You must fill out all fields.';
			}

			if(strlen($password) < 6){
				$errors[]= 'Password must be at least 6 characters.';
			}
			//If new password matches confirm
			if($password != $confirm){
			$errors[] = 'The new password and confirm new password does not match.';
		}
			if(!password_verify($old_password, $hashed)){
				$errors[]='Your old password doesn\'t match our records. Please...! try again.';
			}

			//check for errors
			if(!empty($errors)){
				echo display_errors($errors);
			}else{
				//Change Password
				$db->query("UPDATE users SET password = '$new_hashed' WHERE id = '$user_id'");
				$_SESSION['success_flash'] = 'Your password has been updated!';
				header('Location: index.php');
			}
		}
		?>
	</div>
	<h2 class="text-center">Change Password</h2><hr>
	<form action="change_password.php" method="POST">
		<div class="form-group">
			<label for="old_password">Old Password:</label>
			<input type="password" name="old_password" id="old_password" class="form-control" value="<?=$old_password;?>">
		</div>
		<div class="form-group">
			<label for="password">New Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group">
			<label for="confirm">Confirm New Password:</label>
			<input type="password" name="confirm" id="confirm" class="form-control" value="<?=$confirm;?>">
		</div>
		<div class="form-group">
			<a href="index.php" class="btn btn-info">Cancel</a>
			<input type="submit" name="" value="Change Password" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/E-commerce/index.php" alt="home" class="btn btn-info">Visite Site</a></p>
</div>
<?php include 'includes/footer.php'; ?>
<style>
body{
	background-image: url("/E-commerce/images/background.png");
	background-size: 100vw 100vh;
	background-attachment: fixed;
}
	#login-form{
	width: 50%;
	height: 60%;
	border: 2px solid #000;
	border-radius: 15px;
	box-shadow: 7px 7px 15px rgba(0,0,0,0.6);
	margin: 7% auto;
	padding: 15px;
	background-color: #FFF;
}
</style>