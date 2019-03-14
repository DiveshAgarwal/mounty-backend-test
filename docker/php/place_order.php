<?php
	require_once("lib/library.php");
	$ob=new database();
	if(!isset($_GET['pid']) || !isset($_GET['qty'])){
		header("Location:index.php");
	}	
	$r=$ob->get_where("products",array("pid"=>$_GET['pid']));
	$data=mysqli_fetch_array($r['data']);
	if(isset($_POST['csub'])){
		$ins=$ob->insert("orders",array("pid"=>$_GET['pid'],"qty"=>$_GET['qty'],"cart_amt"=>$data['psell']*$_GET['qty'],"ouser"=>$_POST['cname'],"mobile"=>$_POST['cmob'],"email"=>$_POST['cmail'],"addr1"=>$_POST['cadd1'],"addr2"=>$_POST['cadd2'],"city"=>$_POST['ccity'],"state"=>$_POST['cstate'],"pincode"=>$_POST['cpin']));
		if($ins['status'])
			echo '<script>alert("order placed.");window.location="index.php"</script>';
		else
			echo '<script>alert("problem occurred.");</script>';
	}
?>
<!doctype html>
<html>
	<head>
		<title>Confirm Order</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet" />
	</head>
	<body>
		<div class="container">
			<div class="col-sm-6">
				<h3 class="text-center">Cart Details</h3>
				<table class="table table-bordered">
					<tr>
						<th>Item</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total</th>
					</tr>
					<tr>
						<td><?php echo $data[1]?></td>
						<td><?php echo $data['psell']?></td>
						<td><?php echo $_GET['qty'] ?></td>
						<th><?php echo $data['psell']*$_GET['qty']; ?></th>
					</tr>
				</table>
			</div>
			<div class="col-sm-6">
				<h3 class="text-center">Delivery Details</h3>
				<form action="" method="post" onsubmit="">
					<div class="form-group">
						<label for="name">Full Name:</label>
						<input type="text" class="form-control" value="" name="cname" required />
					</div>
					<div class="form-group">
						<label for="mob">Mobile Number:</label>
						<input type="text" class="form-control" value="" name="cmob" required />
					</div>
					<div class="form-group">
						<label for="email">Email address:</label>
						<input type="email" class="form-control" value="" name="cmail" required />
					</div>
					<div class="form-group">
						<label for="addr1">Address Line 1:</label>
						<input type="text" class="form-control" value="" name="cadd1" required />
					</div>
					<div class="form-group">
						<label for="addr2">Address Line 2:</label>
						<input type="text" class="form-control" value="" name="cadd2" />
					</div>
					<div class="form-group">
						<label for="city">City:</label>
						<input type="text" class="form-control" value="" name="ccity" required />
					</div>
					<div class="form-group">
						<label for="state">State:</label>
						<input type="text" class="form-control" value="" name="cstate" required />
					</div>
					<div class="form-group">
						<label for="pin">Pin Code:</label>
						<input type="text" class="form-control" value="" name="cpin" required />
					</div>
					<button type="submit" class="btn btn-primary" name="csub">Place Order</button>
				</form>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	</body>
</html>