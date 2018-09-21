<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/E-commerce/core/init.php';
include 'includes/head.php';

$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
$email = trim($email);
$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
$password = trim($password);
$errors = array();
?>
<style>
	body{
	background-image: url("/E-commerce/images/background.png");
	background-size: 100vw 100vh;
	background-attachment: fixed;
}
</style>
<div id="login-form">
	<div>
		<?php
			if($_POST){
				//form validation
			if(empty($_POST['email'])|| empty($_POST['password'])){
				$errors[] = 'You must provide email and password';
			}

			// validate email
			if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
				$errors[] = 'You must enter a valid email';
			}
			if(strlen($password)<6){
				$errors[]= 'Password must be at least 6 characters.';
			}
			//check if email exists in database 
			$query = $db->query("SELECT * FROM users WHERE email = '$email'");
			$user = mysqli_fetch_assoc($query);
			$userCount = mysqli_num_rows($query);
			if($userCount < 1){
				$errors[] = 'That email doesn\'t exist in our database';
			}

			if(!password_verify($password, $user['password'])){
				$errors[]='The password doesn\'t match our records. Please...! try again.';
			}

			//check for errors
			if(!empty($errors)){
				echo display_errors($errors);
			}else{
				//log user in
				$user_id = $user['id'];
				login($user_id);
			}
		}
		?>
	</div>
	<h2 class="text-center">Login</h2><hr>
	<form action="login.php" method="POST">
		<div class="form-group">
			<label for="email">Email:</label>
			<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
		</div>
		<div class="form-group">
			<label for="password">Password:</label>
			<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
		</div>
		<div class="form-group">
			<input type="submit" name="" value="Login" class="btn btn-primary">
		</div>
	</form>
	<p class="text-right"><a href="/E-commerce/index.php" alt="home" class="btn btn-info">Visite Site</a></p>
</div>
<?php include 'includes/footer.php'; ?>

<style>
	#login-form{
	width: 40%;
	height: 50%;
	border: 2px solid #000;
	border-radius: 15px;
	box-shadow: 7px 7px 15px rgba(0,0,0,0.6);
	margin: 7% auto;
	padding: 15px;
	background-color: #FFF;
}
</style>