<?php  
require_once '../core/init.php';
if(!is_logged_in()){
	login_error_redirect();
}
include 'includes/head.php';
include 'includes/navigation.php';
$sql = "SELECT * FROM brands ORDER BY brand";
$results = $db->query($sql);
$errors = array();

// Edit Brand
if(isset($_GET['edit']) && !empty($_GET['edit'])){
	$edit_id = (int)$_GET['edit'];
	$sql2 = "SELECT * FROM brands WHERE id = '$edit_id'";
	$edit_result = $db->query($sql2);
	$eBrand = mysqli_fetch_assoc($edit_result);
}

// Delete Brand 
if(isset($_GET['delete']) && !empty($_GET['delete'])){
	$delete_id = (int)$_GET['delete'];
	
	$sql = "DELETE FROM brands WHERE id = '$delete_id'";
	$db->query($sql);
	header('Location: brands.php');
}
 // If add form is submitted

 if(isset($_POST['add_submit'])){
 	$brand = $_POST['brand'];
 	// check brand is blank
 	if($_POST['brand']==''){
 		$errors[] .='You must enter a brand!';
 	}
 	// check if brand exists in database
$sql = "SELECT * FROM brands WHERE brand = '$brand'";
if(isset($_GET['edit'])){
	$sql = "SELECT * FROM brands WHERE brand='$brand' AND id != '$edit_id'";
}
$result = $db->query($sql);
$count = mysqli_num_rows($result);
if ($count > 0){
	$errors[].= $brand.' already exists. Please Choose another brand name...';
}
 	// display errors
 	if (!empty($errors)){
 		echo display_errors($errors);
 	}else{
 		//Add brand to database
 		$sql = "INSERT INTO brands (brand) VALUES ('$brand')";
 		if(isset($_GET['edit'])) {
 			$sql = "UPDATE brands SET brand = '$brand' WHERE id = '$edit_id'";
 		}
 		$db->query($sql);
 		header('Location:brands.php');
 	}

 }
?> 
<br><br><br>
<h2 class="text-center">Brands</h2>
<hr>
<!-- Brand Form --> 
<div class="d-flex justify-content-center align-items-center" style="height:30px;">
	<form class="form-inline" action="brands.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="post">
		<div class="form-group" id="btn-grid">
			<?php 
			$brand_value = '';
			if(isset($_GET['edit'])){
				$brand_value = $eBrand['brand'];
			}else{
				if(isset($_POST['brand'])){
					$brand_value = ($_POST['brand']);
				}
			} ?>
			<input type="text" name="brand" id="brand" class="form-control" value="<?=$brand_value; ?>" placeholder="<?=((isset($_GET['edit']))?'Edit':'Add A'); ?> Brand:" id="ebtn" required>
		</div>&nbsp
		<div class="form-group" id="btn-grid">
			<?php if(isset($_GET['edit'])): ?>
				<a href="brands.php" class="btn btn-secondary btn-primary-spacing" id="ebtn">Cancle</a>
			<?php endif; ?>
		</div>&nbsp
		<div class="form-group" id="btn-grid">
			<input type="submit" name="add_submit" class="btn btn-success" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?>" id="ebtn" />
		</div>
	</form>
</div>
<hr>
<table class="table table-bordered table-striped table-hover" id="btable">
	<thead class="thead-light">
		<th><i class="fa fa-cog fa-spin" aria-hidden="true" style="font-size:25px;color:green"></i></th><th>Brand</th><th><i class="fa fa-cog fa-spin" aria-hidden="true" style="font-size:25px;color:green"></i></th>
	</thead>
	<tbody>
		<?php while($brand = mysqli_fetch_assoc($results)):?>
		<tr>
			<td><a href="brands.php?edit=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><i class="fa fa-edit" aria-hidden="true" style="font-size:20px;color:green"></i></a></td>
			<td><?=$brand['brand']; ?></td>
			<td><a href="brands.php?delete=<?=$brand['id']; ?>" class="btn btn-xs btn-default"><i class="fa fa-trash-o" aria-hidden="true" style="font-size:20px;color:red"></i></a></td>
		</tr>
		<?php endwhile; ?>		 
	</tbody>
</table>

<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function(){
    $('#btable').DataTable();
});
</script>