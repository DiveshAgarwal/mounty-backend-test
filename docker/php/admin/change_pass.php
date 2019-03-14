<?php 
	include("../lib/library.php");
	require "vali.php";
	$ob=new database();
	if(isset($_POST['btn'])){
		$r=$ob->update("admin",array("apass"=>$_POST['newpass']),array("apass"=>$_POST['oldpass'],"aname"=>$_SESSION['aname']),"and","=");
		extract($r);
		if($status && $aff_rows>0)
			echo "<script>alert('password changed successfully')</script>";
		else
			echo "<script>alert('Error in changing password')</script>";
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Change Password</title>
	<?php include("link.php");?>
</head>
<body>
    <div id="wrapper">
        <?php include("nav.php"); ?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
						<h2 class="text-center">Change Password</h2>
						<hr width="50%">
                    </div>
                </div>  
				 <br>
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-1"></div>
							<div class="col-md-10">
								<form method="post" action="" onsubmit="return validate()">
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-edit"></i></span>
										<input type="password" value="" name="oldpass" placeholder="Enter Old Password" class="form-control" required/>
									</div>
									<br>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-edit"></i></span>
										<input type="password" value="" name="newpass" placeholder="Enter New Password" class="form-control" required/>
									</div>
									<br>
									<div class="input-group">
										<span class="input-group-addon"><i class="fa fa-edit"></i></span>
										<input type="password" value="" name="conpass" placeholder="Confirm New Password" class="form-control" required/>
									</div>
									<br>
									<input type="submit" name="btn" class="btn btn-block btn-info" value="Submit"/>
								</form>
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