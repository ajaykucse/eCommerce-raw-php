<?php 
	require_once 'core/init.php';
	include 'includes/head.php';
	include 'includes/navigation.php';
	include 'includes/headerfull.php';

	$sql = "SELECT * FROM products WHERE featured = 1";
	$featured = $db->query($sql);
?>
<div class="container">
		<!-- main content -->
	<section class="one-third text-center">
		<div class="circle">
			<td><i class="fa fa-cart-arrow-down" aria-hidden="true"></i></td>
		</div>
		<h3 class="text-center">Featured Products</h3>
	</section>
	<div class="clearfix"></div>
	<div class="row">
		<?php while ($product = mysqli_fetch_assoc($featured)) : ?>
			<div class="col-md-3">
				<h4><?= $product['title']; ?></h4>
					<img src="<?= $product['image']; ?>" alt="<?= $product['title']; ?>" class="img-thumbnail" id="img-thumb" />
				<p class="list-price text-danger">List Price: 
						<s>$<?= $product['list_price']; ?></s>
				</p>
				<p class="price">Our price: $<?= $product['price']; ?></p>
				<button type="button" class="btn btn-sm btn-success" onclick="detailsmodal(<?=$product['id']; ?>)">Details
				</button>
			</div>

		<?php endwhile; ?>

			<div class="clearfix"></div>
	</div>
</div>

<?php include'includes/footer.php'; ?>
