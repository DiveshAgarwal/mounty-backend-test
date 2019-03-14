<?php
	include("../lib/library.php");
	require "vali.php";
	$ob=new database();
	$r=$ob->order("product","odate","desc");
	/*extract($r);
	if(isset($_GET['didimg']))
	{
		$a=$ob->delete_where("product",array("id"=>$_GET['didimg'])," and ","");
		extract($a);
		if($status && $aff_rows>0){
			echo "<script>alert('Delete Successful');window.location='view_pro.php'</script>";
		}else{
			echo "<script>alert('Delete Failed');window.location='view_pro.php'</script>";
		}
	}
	if(isset($_GET['stimg']) && isset($_GET['sta']))
	{
		if(strcmp($_GET['sta'],'visible')==0)
			$v='hidden';
		else
			$v='visible';
		$a=$ob->update("product",array("visibility"=>$v),array("id"=>$_GET['stimg'])," and ","");
		extract($a);
		if($status && $aff_rows>0){
			echo "<script>alert('Visibility Changed Successfully');window.location='view_pro.php'</script>";
		}else{
			echo "<script>alert('visibility Changing Failed');window.location='view_pro.php'</script>";
		}
	}
	*/
	if(isset($_GET['oid']) && isset($_GET['ostatus'])){
		$res=$ob->update("orders",array("order_status"=>$_GET['ostatus']),array("id"=>$_GET['oid']),"","");
		if($res['status']){
			echo "<script>window.location='view_orders.php'</script>";
		}else{
			echo "<script>alert('error');window.location='view_orders.php'</script>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Orders</title>
	<?php include("link.php");?>
</head>
<body>
    <div id="wrapper">
        <?php include("nav.php") ?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
						<h2 class="text-center">View Orders</h2>
						<hr width="50%">
                    </div>
                </div>  
				<br>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<?php
								$past_ord=$ob->getall("orders");
								while($fpo=mysqli_fetch_array($past_ord['data'])){
									echo '<div>
									<h3 class="text-center">Order id: ord00'.$fpo[0].'</h3>
									<span>Cart Quantity: '.$fpo[2].'</span><br/>
									<span>Change Order Status:
										<form onsubmit="" action="" method="get">
										<input name="oid" type="hidden" value="'.$fpo[0].'" />
										<select name="ostatus" onchange="this.form.submit()">';
										if($fpo[13]=='Recieved'){
											echo '<option selected>Recieved</option>';
											echo '<option>Processing</option>
											<option>Dispatched</option>
											<option>Cancelled</option>
											<option>Delievered</option>';
										}
										elseif($fpo[13]=='Processing'){
											echo '<option>Recieved</option>';
											echo '<option selected>Processing</option>
											<option>Dispatched</option>
											<option>Cancelled</option>
											<option>Delievered</option>';
										}
										elseif($fpo[13]=='Dispatched'){
											echo '<option selected>Recieved</option>';
											echo '<option>Processing</option>
											<option selected>Dispatched</option>
											<option>Cancelled</option>
											<option>Delievered</option>';
										}
										elseif($fpo[13]=='Cancelled'){
											echo '<option>Recieved</option>';
											echo '<option>Processing</option>
											<option>Dispatched</option>
											<option selected>Cancelled</option>
											<option>Delievered</option>';
										}
										elseif($fpo[13]=='Delievered'){
											echo '<option>Recieved</option>';
											echo '<option>Processing</option>
											<option>Dispatched</option>
											<option>Cancelled</option>
											<option selected>Delievered</option>';
										}
										echo '</select>
										</form>
									</span>
									<span>Cart Total: '.$fpo[3].'</span><br/>
									<span>Order Date: '.$fpo[15].'</span><br/>
									<span>Last Updated: '.$fpo[16].'</span><br/>
									<h5 class="text-center">Order Details</h5>';
									$pname=mysqli_fetch_array($ob->get_where("products",array("pid"=>$fpo[1]))['data'])[1];
									echo '<div class="table-responsive"><table class="table table-bordered">
										<tr>
											<th>Product Name</th>
											<th>Quantity</th>
											<th>User Name</th>
											<th>Email</th>
											<th>Mobile</th>
											<th>Address Line 1</th>
											<th>Address Line 2</th>
											<th>City</th>
											<th>State</th>
											<th>Pin</th>
										</tr>
										<tr>
											<td>'.$pname.'</td>
											<td>'.$fpo[2].'</td>
											<td>'.$fpo[4].'</td>
											<td>'.$fpo[5].'</td>
											<td>'.$fpo[6].'</td>
											<td>'.$fpo[7].'</td>
											<td>'.$fpo[8].'</td>
											<td>'.$fpo[9].'</td>
											<td>'.$fpo[10].'</td>
											<td>'.$fpo[11].'</td>
										</tr>
									</table></div>
									</div>';
								}
							?>
						</div>
						<div class="col-md-1"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php") ?>
</body>
</html>