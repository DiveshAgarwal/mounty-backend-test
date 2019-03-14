<?php 
	include("../lib/library.php");
	$ob=new database();
	if(isset($_POST['go']))
	{
		$r=$ob->get_where("admin",array("name"=>$_POST['name'],"pass"=>$_POST['password'])," and ","");
		extract($r);
		if($status && $num_rec==1){
			$nm=mysqli_fetch_array($data)[1];
			$_SESSION['aname']=$nm;
			header("Location:home.php");
            echo $_SESSION['aname'];
		}else{
			echo "<script>alert('access denied');window.location='index.php'</script>";
		}
	}
?>
<html>
<head>
	<title>Admin Panel</title>
	<?php include("link.php");?>
</head>
<body>
	<div id="wrapper" class="bg">
        <div class="navbar navbar-inverse navbar-fixed-top menu">
            <div class="adjust-nav">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">
                        <img src="../images/logo.png" class="img-responsive"/>
                    </a>
                </div>
				<span class="logout-spn" >
                  <a href="logout" style="color:#fff;">LOGOUT</a>
                </span>
            </div>
        </div>
		<div class="container">
			<div class="row" id="pwd-container">
				<div class="col-md-offset-4 col-sm-offset-3 col-md-4 col-sm-6">
					<section class="login-form">
						<form method="post" action="" role="login">
							<h2 class="text-center">Admin Panel</h2>
							<input type="text" name="name" placeholder="Name" required class="form-control input-lg"/>
							<input type="password" class="form-control input-lg" name="password" placeholder="Password" required />
							<div class="pwstrength_viewport_progress"></div>
							<button type="submit" name="go" class="btn btn-lg btn-primary btn-block">Sign in</button>
						</form>
						<div class="form-links">
							<a href="../">www.jrchardware.com</a>
						</div>
					</section>
				</div>
			</div>
		</div>
	</div>
	<?php include("footer.php")?>
</body>
</html>