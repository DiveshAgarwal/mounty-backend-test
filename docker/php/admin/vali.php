<?php
	if(!isset($_SESSION['aname']) || empty($_SESSION['aname']))
		header("Location:index.php");
?>