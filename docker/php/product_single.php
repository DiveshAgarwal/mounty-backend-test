<?php 
	require_once("lib/library.php");
	$ob=new database();
	if(!isset($_GET['pro_id'])){
		header("Location:index.php");
	}
	$res=$ob->get_where("products",array("visibility"=>"visible","pid"=>$_GET['pro_id']),"and");
	if($res['aff_rows']!=1){
		header("Location:index.php");
	}
	$data=mysqli_fetch_array($res['data']);
?>
<!doctype html>
<html>
	<head>
		<title><?php echo $data[1].' Details'; ?></title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<link type="text/css" rel="stylesheet" media="all" href="https://unpkg.com/xzoom/dist/xzoom.css" />
		<link href="css/style.css" rel="stylesheet" />
	</head>
	<body>
		<div class="container">
			<div class="col-sm-8 showcase">
				<div class="col-sm-3 products-list">
					<?php
						$arr=explode(",",$data['pimg']);
						foreach($arr as $i){
							?>
							<div class="item">
								<img src="images/<?php echo $i ?>" class="img-responsive" onclick="changeImg('<?php echo $i; ?>')" />
							</div>
							<?php
						}
					?>
				</div>
				<div class="col-sm-9">
					<img src="images/<?php echo $arr[0] ?>" xoriginal="images/<?php echo $arr[0] ?>" class="img-responsive xzoom main" id="main" />
				</div>
			</div>
			<div class="col-sm-4 showcase-desc">
				<h3><?php echo $data[1] ?></h3>
				<h5>Cost Price: <?php echo $data['pcost']?></h5>
				<h5>Selling Price: <?php echo $data['psell']?></h5>
				<p><?php echo $data['pdesc'] ?></p>
				<form class="form-horizontal" action="place_order.php">
					<input type="hidden" name="pid" value="<?php echo $_GET['pro_id'] ?>" />
					<div class="form-group">
						<label class="control-label col-sm-6 col-md-3 col-lg-2" for="qty">Quantity:</label>
						<div class="col-sm-6 col-md-4 col-lg-3	">
							<input type="number" class="form-control" name="qty" min="1" value="1" placeholder="">
						</div>
					</div>
					<div class="form-group"> 
						<div class="col-sm-offset-0 col-sm-10">
							<button type="submit" class="btn btn-default">Place Order</button>
						</div>
					</div>
				</form>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
		<script type="text/javascript" src="https://unpkg.com/xzoom/dist/xzoom.min.js"></script>
		<script>
			$('.xzoom').xzoom({
				zoomWidth:400,
				zoomHeight:600,
				lensCollision:true,
				defaultScale:-1, //-100%
				smoothScale:6,
				tint: '#333',
				smoothZoomMove:6
			});
			function changeImg(img){
				$("#main, .item").attr("src","images/"+img);
				$("#main").attr("xoriginal","images/"+img);
			}
		</script>
	</body>
</html>