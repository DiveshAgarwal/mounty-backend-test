<?php
	include("../lib/library.php");
	require "vali.php";
	$ob=new database();
	$r=$ob->getall("products");
	extract($r);
	if(isset($_GET['didimg']))
	{
		$a=$ob->delete_where("products",array("pid"=>$_GET['didimg'])," and ","");
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
		$a=$ob->update("products",array("visibility"=>$v),array("pid"=>$_GET['stimg'])," and ","");
		extract($a);
		if($status && $aff_rows>0){
			echo "<script>alert('Visibility Changed Successfully');window.location='view_pro.php'</script>";
		}else{
			echo "<script>alert('visibility Changing Failed');window.location='view_pro.php'</script>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Products</title>
	<?php include("link.php");?>
</head>
<body>
    <div id="wrapper">
        <?php include("nav.php") ?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
						<h2 class="text-center">View Products</h2>
						<hr width="50%">
                    </div>
                </div>  
				<br>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10 table-responsive">
							<?php
							if($num_rec>0)
							{
								echo '<table class="table table-bordered">';
								echo '<tr><th>S no.</th><th>Product Title</th><th>Description</th><th>Cost Price</th><th>Selling Price</th><th>Images</th><th>Date Added</th><th>Visibility</th><th>Delete</th></tr>';
								$c=1;
								while($f=mysqli_fetch_array($data))
								{
									echo "<tr>";
									echo "<td>".$c++."</td>";
									echo "<td>".$f[1]."</td>";
									echo "<td>".$f[2]."</td>";
									echo "<td>".$f[3]."</td>";
									echo "<td>".$f[4]."</td>";
									$img=explode(",",$f['pimg']);
									echo "<td>";
									foreach($img as $i){
										echo '<img src="../images/'.$i.'" height="70" />';
									}
									echo "</td>";
									echo "<td>".$f[7]."</td>";
									echo "<td class='text-center'><a href='view_pro.php?stimg=".$f[0]."&sta=".$f[6]."'>".$f[6]."</a></td>";
									echo "<td class='text-center'><a href='view_pro.php?didimg=".$f[0]."'><i class='fa fa-trash' aria-hidden='true'></i></a></td>";
									echo "</tr>";
								}
								echo '</table>';
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