<!-- Top Navigation -->
<?php  
  $sql = "SELECT * FROM categories WHERE parent = 0";
  $pquery = $db->query($sql);
?>
<header>
<div id="header-inner">
  <!-- Brand -->
<nav class="navbar fixed-top navbar-expand-sm bg-light navbar-light" style="border: 1px solid white;">
    <a class="navbar-brand" href="index.php" id="logo">
    </a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#mainNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon" id="navicon"></span>
  </button>
    <div class="collapse navbar-collapse" id="mainNav">
  	<!-- Links -->
  	<ul class="navbar-nav">
    	<!-- Dropdown -->
      <?php while ($parent = mysqli_fetch_assoc($pquery)) : ?>
      <?php 
        $parent_id = $parent['id']; 
        $sql2 = "SELECT * FROM categories WHERE parent = $parent_id";
        $cquery = $db->query($sql2);
        ?>
      <!-- Menu Items -->
    	<li class="nav-item dropdown">
      		<a class="nav-link dropdown-toggle" href="#" id="navbardrop" data-toggle="dropdown">
    			<?php echo $parent['category']; ?>
      		</a>
      		<div class="dropdown-menu">
            <?php while ($child = mysqli_fetch_assoc($cquery)) : ?>
        		<a class="dropdown-item" href="category.php?cat=<?=$child['id'];?>" id="child-cat"><?php echo $child['category']; ?> </a>
           <?php endwhile; ?> 
      		</div>
    	</li>
    <?php endwhile; ?>
    <li class="nav-item"> 
      <a class="nav-link btn btn-warning mr-sm-2" href="cart.php">
        <i class="fa fa-shopping-cart icon-white" aria-hidden="true" id="shopping-cart"></i>  My Cart
      </a>
    </li>
  	</ul>
    </div>
</nav>
</div>
</header>
<!--End Top Navigation -->
<style>
  .dropdown:hover>.dropdown-menu{
    display: block;
  }
  #child-cat {
    text-transform: none;
  }
</style>