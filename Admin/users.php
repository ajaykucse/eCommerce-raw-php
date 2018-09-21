<br><br><br>
<?php  
require_once '../core/init.php';
if(!is_logged_in()){
	login_error_redirect();
}
if(!has_permission('admin')){
	permission_error_redirect('index.php');
}
include 'includes/head.php';
include 'includes/navigation.php';
if(isset($_GET['delete'])){
	$delete_id = sanitize($_GET['delete']);
	$db->query("DELETE FROM users WHERE id = '$delete_id'");
	$_SESSION['success_flash']='User has been deleted!';
	header('Location: users.php');
}
if(isset($_GET['add'])){
	$name = ((isset($_POST['name']))?sanitize($_POST['name']):'');
	$email = ((isset($_POST['email']))?sanitize($_POST['email']):'');
	$password = ((isset($_POST['password']))?sanitize($_POST['password']):'');
	$confirm = ((isset($_POST['confirm']))?sanitize($_POST['confirm']):'');
	$permissions = ((isset($_POST['permissions']))?sanitize($_POST['permissions']):'');
	$errors = array();
	if($_POST){
		$emailQuery = $db->query("SELECT * FROM users WHERE email = '$email'");
		$emailCount = mysqli_num_rows($emailQuery);

		if($emailCount != 0){
			$errors[] = 'That email already exists in our database. Please..! try another one!';
		}
		$required = array('name','email','password','confirm','permissions');
		foreach($required as $f){
			if(empty($_POST[$f])){
				$errors[] = 'You must fill out all fields';
				break;
			}
		}
		if(strlen($password) < 6){
			$errors[] = 'Your password must be at least 6 characters';
		}
		if($password != $confirm){
			$errors[] = 'Your password do not match.';
		}
		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
			$errors[] = 'You must enter a valid email';
		}
		if(!empty($errors)){
			echo display_errors($errors);
		}else{
			//add user to database
			$current_date = time();
			$current_date = date("Y-m-d H:i:s",$current_date);
			$last_login = '0000-00-00 00:00:00';
			$hashed = password_hash($password,PASSWORD_DEFAULT);
			$insert_user = "INSERT INTO users (full_name, email, password, join_date, last_login, permission) VALUES ('$name','$email','$hashed','$current_date','$last_login','$permissions')";
			$db->query($insert_user);
			$_SESSION['success_flash'] = 'User has been added';
			header('Location: users.php');
		}
	}

?> 
<h2 class="text-center">Add New Users</h2><hr>
<form action="users.php?add=1" method="POST">
<div class="row">
	<div class="form-group col-md-6">
		<label for="name">Full Name:</label>
		<input type="text" name="name" id="name" class="form-control" value="<?=$name;?>">
	</div>
	<div class="form-group col-md-6">
		<label for="email">Email:</label>
		<input type="email" name="email" id="email" class="form-control" value="<?=$email;?>">
	</div>
</div>
<div class="row">
	<div class="form-group col-md-6">
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" class="form-control" value="<?=$password;?>">
	</div>
	<div class="form-group col-md-6">
		<label for="confirm">Confirm Password:</label>
		<input type="password" name="confirm" id="cpassword" class="form-control" value="<?=$confirm;?>">
	</div>
</div>
<div class="row">
	<div class="form-group col-md-6">
		<label for="permission">Permission:</label>
		<select class="form-control" name="permissions">
			<option value="" <?=(($permissions == '')?' selected':'');?>>--Select-User--</option>
			<option value="editor"<?=(($permissions == 'editor')?' selected':'');?>>Editor</option>
			<option value="admin,editor" <?=(($permissions == 'admin,editor')?' selected':'');?>>Admin</option>
		</select>
	</div>
</div>
	<div class="form-group text-right">
		<a href="users.php" class="btn btn-info">Cancle</a>
		<input type="submit" value="Add" class="btn btn-primary">
	</div>
</form>
<?php 

}else{
$userQuery = $db->query("SELECT * FROM users ORDER BY full_name");

?> 
<br><br><br>
<h2 class="text-center"> Users</h2>
<a href="users.php?add=1" class="btn btn-success pull-right" style="margin-top:-35px;">Add</a>
<hr>
<table class="table table-bordered table-striped table-hover" id="usertable">
	<thead class="thead-light"><th>Name</th><th>Email</th><th>Join Date</th><th>Last Login</th><th>Permissions</th><th>Action</th></thead>
	<tbody>
		<?php while($user = mysqli_fetch_assoc($userQuery)): ?>
		<tr>
			<td><?=$user['full_name'];?></td>
			<td><?=$user['email'];?></td>
			 <td><?= pretty_date($user['join_date']);?></td>
			 <td><?=($user['last_login'] == '0000-00-00 00:00:00')? 'Never' : pretty_date($user['last_login']) ;?></td>
			<td><?=$user['permission']; ?></td>
			<td>
				<?php if($user['id'] != $user_data['id']): ?>
					<a href="users.php?delete=<?=$user['id']; ?>" class="btn btn-xs btn-default">
						<i class="fa fa-trash-o" aria-hidden="true" style="font-size:20px;color:red"></i>
					</a>
				<?php endif; ?>
			</td>
		</tr>
		<?php endwhile; ?>
	</tbody>
</table>
<?php } include 'includes/footer.php'; ?>

<script>
$(document).ready(function(){
    $('#usertable').DataTable();
});
</script>