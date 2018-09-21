<?php
require_once $_SERVER['DOCUMENT_ROOT'].'/E-commerce/core/init.php';
if(!is_logged_in()){
	login_error_redirect();
}
require_once '../core/init.php';
include 'includes/head.php';
include 'includes/navigation.php';

// Delete the Featured Product.
if(isset($_GET['delete'])){
	$id = sanitize($_GET['delete']);
	$db->query("UPDATE products SET deleted = 1 WHERE id = '$id'");
	header('Location: products.php');
}
// Archive the Featured Product.
if(isset($_GET['archive'])){
	$arid = sanitize($_GET['archive']);
	$db->query("UPDATE products SET deleted = 0 WHERE id = '$arid'");
	header('Location: products.php?archived=1');
}

$dbpath = '';
if(isset($_GET['add']) || isset($_GET['edit'])){
$brandQuery = $db->query("SELECT * FROM brands ORDER BY brand");
$parentQuery = $db->query("SELECT * FROM categories WHERE parent = 0 ORDER BY category");
$title = ((isset($_POST['title']) && $_POST['title'] != '')? sanitize($_POST['title']):'');
$brand = ((isset($_POST['brand']) && $_POST['brand'] != '')? sanitize($_POST['brand']):'');
$parent = ((isset($_POST['parent']) && $parent_POST['parent'] != '')? sanitize($_POST['parent']):'');
$category = ((isset($_POST['child'])) && !empty($_POST['child'])?sanitize($_POST['child']):'');
$price = ((isset($_POST['price']) && $_POST['price'] != '')? sanitize($_POST['price']):'');
$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')? sanitize($_POST['list_price']):'');
$description = ((isset($_POST['description']) && $_POST['description'] != '')? sanitize($_POST['description']):'');
$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')? sanitize($_POST['sizes']):'');
$sizes = rtrim($sizes,',');
$saved_image = '';
	if(isset($_GET['edit'])){
		$edit_id = (int)$_GET['edit'];
		$productResults = $db->query("SELECT * FROM products WHERE id = '$edit_id'");
		$product = mysqli_fetch_assoc($productResults);
		if(isset($_GET['delete_image'])){
			$image_url = $_SERVER['DOCUMENT_ROOT'].$product['image'];echo $image_url;
			unlink($image_url);
			$db->query("UPDATE products SET image = '' WHERE id = '$edit_id'");
			header('Location: products.php?edit='.$edit_id);
		}
		$category = ((isset($_POST['child']) && $_POST['child'] != '')?sanitize($_POST['child']):$product['categories']);
		$title = ((isset($_POST['title']) && $_POST['title'] != '')?sanitize($_POST['title']):$product['title']);
		$brand = ((isset($_POST['brand']) && $_POST['brand'] != '')?sanitize($_POST['brand']):$product['brand']);
		$parentQ = $db->query("SELECT * FROM categories WHERE id = '$category'");
		$parentResult = mysqli_fetch_assoc($parentQ);
		$parent = ((isset($_POST['parent']) && $_POST['parent'] != '')?sanitize($_POST['brand']):$parentResult['parent']);
		$price = ((isset($_POST['price']) && $_POST['price'] != '')?sanitize($_POST['price']):$product['price']);
		$list_price = ((isset($_POST['list_price']) && $_POST['list_price'] != '')?sanitize($_POST['list_price']):$product['list_price']);
		$description = ((isset($_POST['description']) && $_POST['description'] != '')?sanitize($_POST['description']):$product['description']);
		$sizes = ((isset($_POST['sizes']) && $_POST['sizes'] != '')?sanitize($_POST['sizes']):$product['sizes']);
		$sizes = rtrim($sizes,',');
		$saved_image = (($product['image'] !='')?$product['image']:'');
		$dbpath = $saved_image;
	}
if(!empty($sizes)){
		$sizeString = sanitize($sizes);
		$sizeString = rtrim($sizeString,',');
		$sizesArray = explode(',',$sizeString);
		$sArray = array();
		$qArray = array();
		foreach($sizesArray as $ss){
			$s = explode(':',$ss);
			$sArray[] = $s[0];
			$qArray[] = $s[1];
		}
}else{$sizesArray = array();}

$sizesArray = array();
if($_POST){
	$errors = array();
	$required = array('title','brand','price','parent','child','sizes');
	foreach($required as $field){
		if($_POST[$field]==''){  
			$errors[] = 'All Fields With and Astrisk are required.';
			break;
		}
	}
	if(!empty($_FILES)){
		var_dump($_FILES);
		$photo = $_FILES['photo'];
		$name = $photo['name'];
		$nameArray = explode('.', $name);
		$fileName = $nameArray[0];
		$fileExt = $nameArray[1];
		$mime = explode('/', $photo['type']);
		$mimeType = $mime[0];
		$mimeExt = $mime[1];
		$tmpLoc = $photo['tmp_name'];
		$fileSize = $photo['size'];
		$allowed = array('png','jpg','jpeg','gif');
		$uploadName = md5(microtime()).'.'.$fileExt;
		$uploadPath = BASEURL.'/images/products/'.$uploadName;
		$dbpath = '/E-commerce/images/products/'.$uploadName;
		if($mimeType !='image'){
		$errors[] = 'The file must be an image.';
	}
	if(!in_array($fileExt, $allowed)){
		$errors[] = 'The file extension must be a png, jpg, jpeg, or gif';
	}
	if($fileSize > 15000000){
		$errors[] = 'The file size be under 15MB.';
	}
	if($fileExt != $mimeExt && ($mimeExt == 'jpeg' && $fileExt != 'jpg')){
		$errors[] = 'File extension does not match the file.';
	}
}
	if(!empty($errors)){
		echo display_errors($errors);
	}else{
	//Upload file and insert into database
	if(!empty($_FILES)){
		move_uploaded_file($tmpLoc, $uploadPath);
	}
	$insertSql = "INSERT INTO products (title,price,list_price,brand,categories,sizes,image,description)
	VALUES ('$title','$price','$list_price','$brand','$category','$sizes','$dbpath','$description')";
	if(isset($_GET['edit'])){
		$insertSql = "UPDATE products SET title = '$title', price = '$price', list_price= '$list_price', brand='$brand', categories = '$category', sizes = '$sizes', image= '$dbpath', description= '$description'
		WHERE id= '$edit_id'";
	}
	$db->query($insertSql);
	header('Location: products.php');
	}
}
?>

<br><br><br>
	<h2 class="text-center"><?=((isset($_GET['edit']))?'Edit':'Add A New'); ?> Product</h2><hr>
	<form action="products.php?<?=((isset($_GET['edit']))?'edit='.$edit_id:'add=1'); ?>" method="POST" enctype="multipart/form-data">
		<div class="row">
		<div class="form-group col-md-3">
			<label for="title">Title*:</label>
			<input type="text" name="title" class="form-control" id="title" value="<?=$title;?>" required>
		</div>
		<div class="form-group col-md-3">
			<label for="brand">Brand*:</label>
			<select class="form-control" id="brand" name="brand">
				<option value=""<?=(($brand == '')? ' selected':'');?> required>--Select-Brand--</option>
				<?php while($b = mysqli_fetch_assoc($brandQuery)): ?>
					<option value="<?=$b['id'];?>" <?=(($brand == $b['id'])? ' selected':'');?>><?=$b['brand'];?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="parent">Parent Category*:</label>
			<select class="form-control" id="parent" name="parent">
				<option value=""<?=(($parent =='')? ' selected':''); ?> required>--Select-Parent-Category--</option>
				<?php while($p = mysqli_fetch_assoc($parentQuery)): ?>
					<option value="<?=$p['id'];?>"<?=(($parent == $p['id'])? ' selected':''); ?>><?=$p['category']; ?></option>
				<?php endwhile; ?>
			</select>
		</div>
		<div class="form-group col-md-3">
			<label for="child">Child Category*:</label>
			<select id="child" name="child" class="form-control">
			</select>
		</div>
		</div>
		<div class="row">
			<div class="form-group col-md-3">
				<label for="price">Price*:</label>
				<input type="text" id="price" name="price" class="form-control" value="<?=$price; ?>" required>
			</div>
			<div class="form-group col-md-3">
				<label for="price">List Price*:</label>
				<input type="text" id="list_price" name="list_price" class="form-control" value="<?=$list_price; ?>" required>
			</div>
			<div class="form-group col-md-3">
				<label for="qty_sizes">Sizes & Quantity*:</label>
				<button class="btn btn-info form-control" onclick="jQuery('#sizesModal').modal('toggle');return false;">Browse Sizes & Quantity &nbsp<i class="fa fa-file-text-o" aria-hidden="true" style="font-size:22px;color:F0F0F0;"></i></button>
			</div>
			<div class="form-group col-md-3">
				<label class="text-center" for="sizes">Sizes & Qty Preview</label>
				<input type="text" name="sizes" class="form-control" id="sizes" value="<?=$sizes; ?>" required>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?php if($saved_image !=''): ?>
				<div class="saved-image">
					<img src="<?=$saved_image;?>" alt="save mage" style="width: 100px;height: auto;" /><br>
					<a href="products.php?delete_image=1&edit=<?=$edit_id;?>" class="text-danger">Delete Image</a>
				</div>
				<?php else: ?>
				<label for="photo" class="control-label">Product Photo*: <i class="fa fa-picture-o" aria-hidden="true" style="font-size:20px;color:green"></i></label>
				<div class="form-group">
  					<input type="file" class="filestyle" data-icon="false" name="photo" id="photo" required>	
				</div>
			<?php endif; ?>
			</div>
			<div class="form-group col-md-6">
				<label for="description">Description*:</label>
				<textarea required name="description" class="form-control" id="description" placeholder="Type Description About Product"><?=$description;?></textarea>
			</div>
		</div>
		<div class="form-group pull-right">
			<a href="products.php" class="btn btn-info">Cancle</a>
			<input type="submit" name="Add Product" class="btn btn-success" value="<?=((isset($_GET['edit']))?'Edit':'Submit'); ?>" >
		</div><div class="clearfix"></div>
	</form>

	<!-- Modal -->
<div class="modal fade" id="sizesModal" tabindex="-1" role="dialog" aria-labelledby="sizesModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
      	<h4 class="modal-title text-center" id="sizesModalLabel">Size & Quantity</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
        	<div class="row">
        		<?php for($i=1;$i<=12;$i++): ?>
        		<div class="form-group col-md-4">
        			<label for="size<?=$i;?>">Size:</label>
        			<input type="text" name="size<?=$i;?>" id="size<?=$i;?>" value="<?=((!empty($sArray[$i-1]))?$sArray[$i-1]:'');?>" class="form-control">
        		</div>
        		<div class="form-group col-md-2">
        			<label for="qty<?=$i;?>">Quantity:</label>
        			<input type="number" name="qty<?=$i;?>" id="qty<?=$i;?>" value="<?=((!empty($qArray[$i-1]))?$qArray[$i-1]:'');?>" class="form-control">
        		</div>
        	<?php endfor; ?>
        	</div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="updateSizes();jQuery('#sizesModal').modal('toggle');return false;">Save changes</button>
      </div>
    </div>
  </div>
</div>
<?php } elseif(isset($_GET['archived'])){

	$sql = "SELECT * FROM products WHERE deleted =1";
	$products = $db->query($sql);
	if(isset($_GET['featured'])){
		$id = (int)$_GET['id'];
		$featured = (int)$_GET['featured'];
		$featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
		$db->query($featuredSql);
		header('Location: products.php');
	}
?>
<br><br><br>
<h2 class="text-center">Archived Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn" style="margin-top:-35px;">Add</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-striped table-hover" id="ptable">
	<thead class="thead-light">
		<th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th><th>Archive</th>
	</thead>
	<tbody>
		<?php while($product = mysqli_fetch_assoc($products)): 
			$childID = $product['categories'];
			$catSql ="SELECT * FROM categories WHERE id = '$childID'";
			$result = $db->query($catSql);
			$child = mysqli_fetch_assoc($result);
			$parentID = $child['parent'];
			$pSql = "SELECT * FROM categories WHERE id = '$parentID'";
			$presult = $db->query($pSql);
			$parent = mysqli_fetch_assoc($presult);
			$category = $parent['category'].'-'.$child['category'];
		?>
			<tr>
				<td><?=$product['title'];?></td>
				<td><?=money($product['price']); ?></td>
				<td><?=$category;?></td>
				<td>
					<a href="products.php?featured=<?=(($product['featured']==0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-default"><i class="fa fa-<?=(($product['featured']==1)?'minus':'plus');?>"></i>
					</a>&nbsp <?=(($product['featured']==1)?'Featured Product':'');?></td>
				<td>0</td>
				<td>
					<a href="products.php?archive=<?=$product['id'];?>" class="btn btn-default">
						<i class="fa fa-refresh" aria-hidden="true" style="font-size:20px;color:FFF;"></i>
					</a>
				</td>
			</tr>
		<?php endwhile; ?>	
	</tbody>
</table>
<?php }else{
	$sql = "SELECT * FROM products WHERE deleted =0";
	$products = $db->query($sql);
	if(isset($_GET['featured'])){
		$id = (int)$_GET['id'];
		$featured = (int)$_GET['featured'];
		$featuredSql = "UPDATE products SET featured = '$featured' WHERE id = '$id'";
		$db->query($featuredSql);
		header('Location: products.php');
	}
?>
<br><br><br>
<h2 class="text-center">Products</h2>
<a href="products.php?add=1" class="btn btn-success pull-right" id="add-product-btn" style="margin-top:-35px;">Add</a><div class="clearfix"></div>
<hr>
<table class="table table-bordered table-striped table-hover" id="ptable">
	<thead class="thead-light">
		<th>Product</th><th>Price</th><th>Category</th><th>Featured</th><th>Sold</th><th>Action</th>
	</thead>
	<tbody>
		<?php while($product = mysqli_fetch_assoc($products)): 
			$childID = $product['categories'];
			$catSql ="SELECT * FROM categories WHERE id = '$childID'";
			$result = $db->query($catSql);
			$child = mysqli_fetch_assoc($result);
			$parentID = $child['parent'];
			$pSql = "SELECT * FROM categories WHERE id = '$parentID'";
			$presult = $db->query($pSql);
			$parent = mysqli_fetch_assoc($presult);
			$category = $parent['category'].'-'.$child['category'];
		?>
			<tr>
				<td><?=$product['title'];?></td>
				<td><?=money($product['price']); ?></td>
				<td><?=$category;?></td>
				<td>
					<a href="products.php?featured=<?=(($product['featured']==0)?'1':'0');?>&id=<?=$product['id'];?>" class="btn btn-default"><i class="fa fa-<?=(($product['featured']==1)?'minus':'plus');?>"></i>
					</a>&nbsp <?=(($product['featured']==1)?'Featured Product':'');?></td>
				<td>0</td>
				<td>
					<a href="products.php?edit=<?=$product['id'];?>" class="btn btn-xs btn-default">
						<i class="fa fa-edit" aria-hidden="true" style="font-size:20px;color:green"></i>
					</a>
					<a href="products.php?delete=<?=$product['id'];?>" class="btn btn-xs btn-default">
						<i class="fa fa-trash-o" aria-hidden="true" style="font-size:20px;color:red"></i>
					</a>
				</td>
			</tr>
		<?php endwhile; ?>	
	</tbody>
</table>
<?php } include 'includes/footer.php'; ?>
<script>
	jQuery('document').ready(function(){
		get_child_options('<?=$category;?>');
	});
</script>

<script>
$(document).ready(function(){
    $('#ptable').DataTable();
});
</script>