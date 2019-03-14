<?php
	include("../lib/library.php");
	require "vali.php";
	$ob=new database();
	$r=$ob->getall("users");
	extract($r);
	if(isset($_GET['stimg']) && isset($_GET['sta']))
	{
		if(strcmp($_GET['sta'],'visible')==0)
			$v='hidden';
		else
			$v='visible';
		$a=$ob->update("users",array("visibility"=>$v),array("id"=>$_GET['stimg'])," and ","");
		extract($a);
		if($status && $aff_rows>0){
			echo "<script>alert('Visibility Changed Successfully');window.location='users.php'</script>";
		}else{
			echo "<script>alert('visibility Changing Failed');window.location='users.php'</script>";
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>View Users</title>
	<?php include("link.php");?>
</head>
<body>
    <div id="wrapper">
        <?php include("nav.php") ?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
						<h2 class="text-center">View Users</h2>
						<hr width="50%">
                    </div>
                </div>  
				<br>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<?php
							if($num_rec>0)
							{
								echo '<table class="table table-bordered">';
								echo '<tr><th>S no.</th><th>Name</th><th>Email</th><th>Mobile</th><th>Address Line 1</th><th>Address Line 2</th><th>City</th><th>State</th><th>Pin Code</th><th>Visibility</th></tr>';
								$i=1;
								while($f=mysqli_fetch_array($data))
								{
									echo "<tr>";
									echo "<td>".$i++."</td>";
									echo "<td>".$f[1]."</td>";
									echo "<td>".$f[2]."</td>";
									echo "<td>".$f[3]."</td>";
									echo "<td>".$f[5]."</td>";
									echo "<td>".$f[6]."</td>";
									echo "<td>".$f[7]."</td>";
									echo "<td>".$f[8]."</td>";
									echo "<td>".$f[9]."</td>";
									echo "<td class='text-center'><a href='users.php?stimg=".$f[0]."&sta=".$f[10]."'>".$f[10]."</a></td>";
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