<br><br><br>
<?php  
require_once '../core/init.php';
if(!is_logged_in()){
	header('Location: login.php');
}
include 'includes/head.php';
include 'includes/navigation.php';

?> 
<br><br><br>
<div>
<h2 class="text-center"> Administrator Home </h2><hr>
</div>
<?php include 'includes/footer.php'; ?>