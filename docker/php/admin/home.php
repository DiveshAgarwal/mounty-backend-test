<?php 
	include("../lib/library.php");
	require "vali.php";
?>
<!DOCTYPE html>
<html>
<head>
	<title>Admin Dashboard</title>
	<?php include("link.php"); ?>
</head>
<body>
    <div id="wrapper">
        <?php include("nav.php") ?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-lg-12">
                     <h2 class="text-center">ADMIN DASHBOARD</h2>   
                    </div>
                </div>
                <hr width="80%"/>
				<div class="row text-center pad-top">
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                         <a href="home.php">
						<i class="fa fa-home fa-5x"></i>
                      <h4>Dashboard</h4>
                      </a>
                      </div>   
                  </div>
				  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                         <a href="view_orders.php">
						<i class="fa fa-cart-arrow-down fa-5x"></i>
                      <h4>View Orders</h4>
                      </a>
                      </div>
                  </div> 
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="product.php">
						   <i class="fa fa-product-hunt fa-5x"></i>
                      <h4>Add Products</h4>
                      </a>
                      </div>
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="view_pro.php">
						   <i class="fa fa-list fa-5x"></i>
                      <h4>View Products</h4>
                      </a>
                      </div>
                  </div>
                  <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                      <div class="div-square">
                           <a href="change_pass.php">
						   <i class="fa fa-key fa-5x"></i>
                      <h4>Change Password</h4>
                      </a>
                      </div>
                  </div>
              </div>    
            </div>
            </div>
        </div>
  <?php include("footer.php") ?>
</body>
</html>
