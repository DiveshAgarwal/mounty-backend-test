<?php 
	require_once("lib/library.php");
	$ob=new database();
	$limit=4;
    if (isset($_GET["page"])){
		$page=$_GET["page"];  
    }else{  
		$page=1;  
    }
    $start_from=($page-1)*$limit;
	$getpro=$ob->limit_where("products",array("visibility"=>"visible"),"and","=",$start_from,$limit);	
	$num=$ob->get_where("products",array("visibility"=>"visible"),",","=")['num_rec'];
	$total=ceil($num/$limit);
?>
<!doctype html>
<html>
	<head>
		<title>Home || Products</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
		<link href="https://fonts.googleapis.com/css?family=Ubuntu" rel="stylesheet">
		<link href="css/style.css" rel="stylesheet" />
	</head>
	<body>
		<div class="container">
			<div class="product-row">
			<?php
				if($getpro['aff_rows']>0){
					$i=1;
					while($f=mysqli_fetch_array($getpro['data'])){
						$img=explode(",",$f['pimg']);
						?>
				<div class="col-sm-3">
					<div class="mid-item">
						<div class="pro-img">
							<img src="images/<?php echo $img[0];?>" class="img-responsive" />
						</div>
						<div class="pro-text">
							<h4><a href="product_single.php?pro_id=<?php echo $f[0] ?>"><?php echo $f[1] ?></a></h4>
						</div>
					</div>
				</div>
						<?php
						if($i++%4==0){
							echo '<div class="clearfix"></div></div><div class="product-row">';
						}
					}
				}else{
					echo "<h3>No products to show</h3>";
				}
			?>
				<div class="clearfix"></div>
			</div>
			<div class="text-center">
				<ul class="pagination pagination-lg">
				<?php
					if($page>1 && $page=$total)
						echo '<li><a href="index.php?page='.($page-1).'">&lt;&lt;</a></li>';
					else
						echo '<li class="disabled"><a>&lt;&lt;</a></li>';
					for($i=1;$i<=$total;$i++){ 
						if($i==$page){
							echo '<li class="active"><a href="index.php?page='.$i.'">'.$i.'</a></li>';
						}else{ 
							echo '<li><a href="index.php?page='.$i.'">'.$i.'</a></li>';
						} 
					}
					if($page<$total && $page>=1)
						echo '<li><a href="index.php?page='.($page+1).'">&gt;&gt;</a></li>';
					else
						echo '<li class="disabled"><a>&gt;&gt;</a></li>';
				?>
				</ul>
			</div>
		</div>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	</body>
</html>