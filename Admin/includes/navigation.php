<nav class="navbar fixed-top navbar-expand-sm bg-light navbar-light">
	<a class="navbar-brand" href="/E-commerce/admin/index.php">Aditya's Shop Admin</a>
  	<ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="/E-commerce/index.php">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="brands.php">Brands</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="categories.php">Categories</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="products.php">Products</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="products.php?archived=1">Archived</a>
      </li>
      <?php if(has_permission('admin')): ?>
      <li class="nav-item">
        <a class="nav-link" href="users.php">Users</a>
      </li>
      <?php endif; ?>
      <li class="nav-item dropdown float-sm-right" style="margin-left: 450px;">
          <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?=$user_data['first']; ?> <?=$user_data['middel']; ?> <?=$user_data['last'] ; ?>
            <span class="caret"></span>
          </a>
        <ul class="dropdown-menu" role="menu">
          <li class="nav-item"><a class="nav-link" href="change_password.php">Change Password</a></li>
          <li class="nav-item"><a class="nav-link" href="logout.php">Log Out</a></li>
        </ul>
      </li>
  	</ul>
</nav>
<style>
  .dropdown:hover>.dropdown-menu{
    display: block;
  }
</style>