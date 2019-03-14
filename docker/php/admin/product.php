<?php 
	include("../lib/library.php");
	require "vali.php";
	$ob=new database();
	if(isset($_GET['id']))
	{
		$r=$ob->get_where("product",array("id"=>$_GET['id']),"","");
		$fet=mysqli_fetch_array($r['data']);
		if(isset($_POST['xsub']))
		{
			if(empty($_FILES['img']['name']))
				$name=$fet[4];
			else{
				$imgs=$ob->unlink_img($fet[4],$_FILES['img'],"../images/");			
				if($imgs['status'])
					$name=$imgs['res'];
				else
					$name=$fet[4];
			}
			$r=$ob->update("product",array("pname"=>$_POST['pname'],"pdesc"=>$_POST['desc'],"cid"=>$_POST['pcid'],"bid"=>$_POST['bid'],"pimg"=>$name,"contents"=>$_POST['feat'],"stock"=>$_POST['stock'],"mrp"=>$_POST['mrp'],"discount"=>$_POST['disc'],"model"=>$_POST['model'],"visibility"=>$_POST['pvisible']),array("id"=>$_GET['id']),"","");
			extract($r);
			if($status){
				echo "<script>alert('Product updated successfully');window.location='view_pro.php'</script>";
			}else{
				echo "<script>alert('Problem to update Product');window.location='view_pro.php'</script>";
			}
		}
	}
	else
	{
		if(isset($_POST['xsub']))
		{
			$im=$ob->upload_multi_image($_FILES['img'],"../images/");
			extract($im);
			if($status){
				$res=implode(",",$res);
				$r=$ob->insert("products",array("ptitle"=>$_POST['pname'],"pdesc"=>$_POST['desc'],"pcost"=>$_POST['pcost'],"psell"=>$_POST['psell'],"pimg"=>$res,"visibility"=>$_POST['pvisible']));
				extract($r);
				if($status){
					echo "<script>alert('New product entered successfully');window.location='product.php'</script>";
				}else{
					echo "<script>alert('failed to insert new product');window.location='product.php'</script>";
				}
			}else{
				echo "<script>alert('some error occured');window.location='product.php'</script>";
			}
		}
	}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Product</title>
	<?php include("link.php");?>
</head>
<body>
    <div id="wrapper">
        <?php include("nav.php") ?>
        <div id="page-wrapper" >
            <div id="page-inner">
                <div class="row">
                    <div class="col-md-12">
						<h2 class="text-center">Add Product</h2>
						<hr width="50%">
                    </div>
                </div>  
				<br>
				<div class="container-fluid">
					<div class="row">
						<div class="col-md-1"></div>
						<div class="col-md-10">
							<form action="" method="post" enctype="multipart/form-data">
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-edit"></i></span>
									<input type="text" value="<?php if(isset($fet)) echo $fet[1]; ?>" name="pname" placeholder="Enter Product Title" class="form-control" required/>
								</div>
								<br>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-edit"></i></span>
									<textarea name="desc" placeholder="Enter Product Description" class="form-control" required><?php if(isset($fet)) echo $fet[2]; ?></textarea>
								</div>
								<br>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-picture-o" aria-hidden="true"></i></span>
									<input type="file" name="img[]" multiple="multiple" class="form-control btn btn-info">
								</div>
								<br>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-edit"></i></span>
									<input type="number" value="<?php if(isset($fet)) echo $fet[7]; ?>" name="pcost" placeholder="Enter Cost Price of Product" class="form-control" required/>
								</div>
								<br>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-edit"></i></span>
									<input type="number" value="<?php if(isset($fet)) echo $fet[8]; ?>" name="psell" placeholder="Enter Selling Price of Product" class="form-control" required/>
								</div>
								<br>
								<div class="input-group">
									<span class="input-group-addon"><i class="fa fa-edit"></i></span>
									<select name="pvisible" class="form-control" required>
										<option disabled selected value="visible" >Select Visibility of product</option>
										<?php 
											if(isset($fet)){
												if($fet['visibility']=='visible'){
													echo '<option value="visible" selected>Visible</option>';
													echo '<option value="hidden">Hidden</option>';
												}else{
													echo '<option value="visible">Visible</option>';
													echo '<option value="hidden" selected>Hidden</option>';
												}
											}else{
												echo '<option value="visible">Visible</option>';
												echo '<option value="hidden">Hidden</option>';
											}
										?>
									</select>
								</div>
								<br>
								<input type="submit" name="xsub" class="btn btn-block btn-info" value="Submit"/>
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