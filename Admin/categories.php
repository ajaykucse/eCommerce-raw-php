<?php
	require_once $_SERVER['DOCUMENT_ROOT'].'/E-commerce/core/init.php';
	if(!is_logged_in()){
	login_error_redirect();
}
	require_once '../core/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';

	$sql = "SELECT * FROM categories WHERE parent = 0";
	$result = $db->query($sql);
	$errors = array();
	$category = '';
	$post_parent = '';

	//Edit Category 
	if(isset($_GET['edit']) && !empty($_GET['edit'])){
		$edit_id = (int)$_GET['edit'];
		$edit_sql = "SELECT * FROM categories WHERE id = '$edit_id'";
		$edit_result = $db->query($edit_sql);
		$edit_category = mysqli_fetch_assoc($edit_result);
	}

	//Delete Category
	if(isset($_GET['delete']) && !empty($_GET['delete'])){
		$delete_id = (int)$_GET['delete'];
		$sql = "SELECT * FROM categories WHERE id = '$delete_id'";
		$result = $db->query($sql);
		$category = mysqli_fetch_assoc($result);
		if($category['parent']==0);{
		$sql = "DELETE FROM categories WHERE parent = '$delete_id'";
		$db->query($sql);
	}
		$dsql = "DELETE FROM categories WHERE id = '$delete_id'";
		$db->query($dsql);
		header('Location: categories.php');
	}

	//Process Form
	if(isset($_POST) && !empty($_POST)){
		$post_parent = ($_POST['parent']);
		$category = ($_POST['category']);
		$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent ='$post_parent'";
		if(isset($_GET['edit'])){
			$id = $edit_category['id'];
			$sqlform = "SELECT * FROM categories WHERE category = '$category' AND parent = '$post_parent' AND id != '$id'";
		}
		$fresult = $db->query($sqlform);
		$count = mysqli_num_rows($fresult);
		//If category is blank
		if($category == ''){
			$errors[] .= 'The category cannot be left blank.';
		}
		//If exists in the database
		if($count > 0){
			$errors[] .= $category. ' already exists. Please choose a new category.';
		}

		//Display Errors or Update Database
		if(!empty($errors)){
			//display errors
			$display = display_errors($errors); ?>
			<script>
				jQuery('document').ready(function(){
					jQuery('#errors').html('<?=$display; ?>');
				});
			</script>
			<?pHp }else{
				//Update Database
				$updatesql = "INSERT INTO categories (category, parent) VALUES ('$category','$post_parent')";
				if(isset($_GET['edit'])){
					$updatesql = "UPDATE categories SET category = '$category', parent= '$post_parent' WHERE id = '$edit_id'";
				}
				$db->query($updatesql);
				header('Location: categories.php');
			}
	}

	$category_value = '';
	$parent_value = 0;
	if(isset($_GET['edit'])){
		$category_value = $edit_category['category'];
		$parent_value = $edit_category['parent'];
	}else{
		if(isset($_POST)){
		 $category_value = $category;
		 $parent_value = $post_parent;
		}
	}

?>
<br><br><br>
<h2 class="text-center">Categories</h2><hr>
<div class="row">
	<!-- Form -->
	<div class="col-md-6">
		<form class="form" action="categories.php<?=((isset($_GET['edit']))?'?edit='.$edit_id:''); ?>" method="post">
			<legend><?=((isset($_GET['edit']))?'Edit ':'Add A '); ?>Category:</legend><hr>
			<div id="errors"></div>
			<div class="form-group">
				<label for="parent">Parent</label>
				<select class="form-control" name="parent" id="parent" required>
					<option value="0"<?=(($parent_value==0)?'selected="selected"':''); ?> required>Parent</option>
					<?php while($parent = mysqli_fetch_assoc($result)) : ?>
						<option value="<?=$parent['id']; ?>"<?=(($parent_value == $parent['id'])?' selected="selected"':'');?>><?=$parent['category']; ?></option>
					<?php endwhile;  ?>
				</select>
			</div>
			<div class="form-group">
				<label for="category">Category</label>
				<input type="text" class="form-control" name="category" value="<?=$category_value; ?>" id="category" required>
			</div>
			<div class="form-group">
				<input type="submit" name="button" class="btn btn-success" value="<?=((isset($_GET['edit']))?'Edit':'Add'); ?>">
			</div>
		</form>
	</div>
	<!-- Category Table -->
	<div class="col-md-6">
		<table class="table table-bordered table-striped table-hover" id="ctable">
			<thead class="thead-dark">
				<th>Category</th><th>Parent</th><th>Action</th>
			</thead>
			<tbody>
				<?php 
				$sql = "SELECT * FROM categories WHERE parent = 0";
				$result = $db->query($sql);
				while($parent = mysqli_fetch_assoc($result)): 
					$parent_id = (int)$parent['id'];
					$sql2 = "SELECT * FROM categories WHERE parent = '$parent_id'";
					$cresult = $db->query($sql2);
				?>
				<tr class="p-3 mb-2 bg-primary text-white">
					<td><?=$parent['category']; ?></td>
					<td>Parent</td>
					<td>
						<a href="categories.php?edit=<?=$parent['id']; ?>" class="btn btn-xs btn-default">
							<i class="fa fa-edit" aria-hidden="true" style="font-size:20px;color:green"></i>
						</a>
						<a href="categories.php?delete=<?=$parent['id']; ?>" class="btn btn-xs btn-default">
							<i class="fa fa-trash-o" aria-hidden="true" style="font-size:20px;color:red"></i>
						</a>
					</td>
				</tr>
				<?php while($child = mysqli_fetch_assoc($cresult)): ?>
					<tr class="p-3 mb-2 bg-light text-dark">
					<td><?=$child['category']; ?></td>
					<td><?=$parent['category']; ?></td>
					<td>
						<a href="categories.php?edit=<?=$child['id']; ?>" class="btn btn-xs btn-default">
							<i class="fa fa-edit" aria-hidden="true" style="font-size:20px;color:green"></i>
						</a>
						<a href="categories.php?delete=<?=$child['id']; ?>" class="btn btn-xs btn-default">
							<i class="fa fa-trash-o" aria-hidden="true" style="font-size:20px;color:red"></i>
						</a>
					</td>
				</tr>
				<?php endwhile; ?>	
			<?php endwhile; ?>
			</tbody>
		</table>
	</div>
</div>
<?php include 'includes/footer.php'; ?>

<script>
$(document).ready(function(){
    $('#ctable').DataTable();
});
</script>