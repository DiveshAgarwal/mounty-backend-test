<?php
	include_once "constant.php";
	session_start();
	class img
	{
		public function type($file_ob)
		{
			if(!empty($file_ob['name'])){
				$name=$file_ob['name'];
				$typeimg=array("jpeg","jpg","png","gif","bmp","JPG","PNG");
				$file=explode(".",$name);
				if(in_array(end($file),$typeimg)){
					$ret['status']=true;
					$ret['res']=$file;
					$ret["mess"]="This is a supported image type.";
				}else{
					$ret['status']=false;
					$ret['mess']="This is an unsupported file type.";
				}
			}else{
				$ret['status']=false;
				$ret['mess']="Empty Image";
			}
			return $ret;
		}
		public function newname($file_ob)
		{
			if(!empty($file_ob['name'])){
				$sol=$this->type($file_ob);
				if($sol['status']==true){
					$new=uniqid().".".end($sol['res']);
					$ret['status']=true;
					$ret['res']=$new;
					$ret['mess']="Name successfully changed.";
				}else{
					$ret['status']=false;
					$ret['mess']=$sol['mess']." Therefore name can not be changed.";
				}
			}else{
				$ret['status']=false;
				$ret['mess']="Empty Image";
			}
			return $ret;
		}
		public function compress($file_ob,$folder_loc,$quality=90){
			if(!empty($file_ob['name'])){
				$source=$file_ob['tmp_name'];
				$name=$this->newname($file_ob)['res'];
				$destination=$folder_loc.$name;
				$info = getimagesize($source);
				if($info['mime'] == 'image/jpeg')
					$image = imagecreatefromjpeg($source);
				else if($info['mime'] == 'image/gif')
					$image = imagecreatefromgif($source);
				else if($info['mime'] == 'image/png')
					$image = imagecreatefrompng($source);
				$r=imagejpeg($image, $destination, $quality);
				if($r){
					$ret['status']=true;
					$ret['mess']="Image compressed successfully";
					$ret['res']=$name;
				}else{
					$ret['status']=false;
					$ret['mess']="Can not compress image";
				}
			}else{
				$ret['status']=false;
				$ret['mess']="Empty Image";
			}
			return $ret;
		}
		public function small_image($file_ob,$folder_loc,$quality,$thumb_loc,$newWidth=260,$newHeight=200){
			$r1=$this->compress($file_ob,$folder_loc,$quality);
			if(!empty($file_ob['name'])){
				$originalFile=$file_ob['tmp_name'];
				$info = getimagesize($originalFile);
				$mime = $info['mime'];
				switch ($mime) {
					case 'image/jpeg':
						$image_create_func = 'imagecreatefromjpeg';
						$image_save_func = 'imagejpeg';
						break;
					case 'image/png':
						$image_create_func = 'imagecreatefrompng';
						$image_save_func = 'imagepng';
						break;
					case 'image/gif':
						$image_create_func = 'imagecreatefromgif';
						$image_save_func = 'imagegif';
						break;
					default: 
						$image_create_func = 'imagecreatefromjpeg';
						$image_save_func = 'imagejpeg';
						break;
				}
				$img = $image_create_func($originalFile);
				list($width, $height) = getimagesize($originalFile);
				//$newHeight = ($height / $width) * $newWidth;
				$tmp = imagecreatetruecolor($newWidth, $newHeight);
				imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
				$name="thumb_".$this->newname($file_ob)['res'];
				$targetFile=$thumb_loc.$name;
				$r=$image_save_func($tmp,$targetFile);
				if($r && $r1['status']){
					$ret['status']=true;
					$ret['mess']="thumbnail created and image compressed successfully";
					$ret['res']=array("original"=>$r1['res'],"thumbnail"=>$name);
				}else{
					$ret['status']=false;
					$ret['mess']="Can not upload thumbnail";
				}
			}else{
				$ret['status']=false;
				$ret['mess']="Empty Image";
			}
			return $ret;
		}
		public function upload_image($file_ob,$folder_loc)
		{
			if(!empty($file_ob['name'])){
				$sol=$this->newname($file_ob);
				if($sol['status']==true){
					$path=$folder_loc.$sol['res'];
					$r=move_uploaded_file($file_ob['tmp_name'],$path);
					if($r==true){
						$ret['status']=true;
						$ret['res']=$sol['res'];
						$ret['mess']="File Uploaded successfully.";
					}else{
						$ret['status']=false;
						$ret['mess']="Problem in file uploadation.";
					}
				}
				else{
					$ret['status']=false;
					$ret['mess']=$sol['mess']." That's why problem in file uploadation.";
				}
			}else{
				$ret['status']=false;
				$ret['mess']="Empty Image";
			}
			return $ret;
		}
		public function upload_multi_image($file_ob,$folder_loc)
		{
			$c=count($file_ob['name']);
			if($c>0)
			{
				$num=0;
				$dnum=0;
				for($i=0;$i<$c;$i++)
				{
					$name=$file_ob['name'][$i];
					$typeimg=array("jpeg","jpg","png","gif","bmp");
					$file=explode(".",$name);
					if(in_array($file[1],$typeimg)){
						$new=uniqid().".".$file[1];
						$path=$folder_loc.$new;
						$r=move_uploaded_file($file_ob['tmp_name'][$i],$path);
						if($r==true){
							$ret['status']=true;
							$name_arr[$num++]=$new;
							$ret['mess']="File Uploaded successfully ";
						}else{
							$ret['status']=false;
							$dnum++;
							$ret['mess']="Problem in file uploading file.";
						}
					}else{
						$ret['status']=false;
						$ret['mess']="This is an unsupported file type.";
					}
				}
				if($num>0)
				{
					$ret['res']=$name_arr;
					$ret['success']=$num;
					$ret['fail']=$dnum;
					$ret['total']=$c;
				}
			}else{
				$ret['status']=false;
				$ret['mess']="No Images";
			}
			return $ret;
		}
		public function unlink_img($old_img,$file_ob,$folder_loc)
		{
			if(!empty($file_ob['name'])){
				unlink($folder_loc.$old_img);
				$sol=$this->upload_image($file_ob,$folder_loc);
				if($sol['status']==true){
					$ret['status']=true;
					$ret['res']=$sol['res'];
					$ret['mess']="File Unlinked successfully and New".$sol['mess'];
				}else{
					$ret['status']=false;
					$ret['mess']=$sol['mess'];
				}
			}else{
				$ret['status']=false;
				$ret['mess']="Empty Image";
			}
			return $ret;
		}
		public function captcha(){
			
		}
	}
	class database extends img
	{
		public $ret;
		public $conn;
		public function __construct(){
			$this->conn=mysqli_connect(HOST,USER,PASS,DB) or die("error in connectivity");
		}
		private function fire(){
			$qry=$this->createquery();
			$res=mysqli_query($this->conn,$qry);
			$_SESSION['fq']=$qry;
			return $res;
		}
		
		private function createquery(){
			$fqry="";
			if(isset($_SESSION['query']))
				$fqry.=$_SESSION['query'];
			if(isset($_SESSION['where']))
				$fqry.=$_SESSION['where'];
			if(isset($_SESSION['order']))
				$fqry.=$_SESSION['order'];
			unset($_SESSION['query']);
			unset($_SESSION['where']);
			unset($_SESSION['order']);
			return $fqry;
		}
		
		private function makestring($condi,$sym,$cop)
		{
			if(!isset($sym) || empty($sym))
				$sym=',';
			if(!isset($cop) || empty($cop))
				$cop='=';
			if(is_array($condi))
			{
				$qstr="";
				$i=0;
				foreach($condi as $k=>$v)
				{
					if($i==count($condi)-1)
					{
						if(is_int($v) || is_float($v))
							$qstr.=" ".$k.$cop.mysqli_real_escape_string($this->conn,$v)."";
						else
							$qstr.=" ".$k.$cop."'".mysqli_real_escape_string($this->conn,$v)."'";
					}
					else
					{
						if(is_int($v) || is_float($v))
							$qstr.=" ".$k.$cop.mysqli_real_escape_string($this->conn,$v)." ".$sym;
						else
							$qstr.=" ".$k.$cop."'".mysqli_real_escape_string($this->conn,$v)."' ".$sym;
					}
					$i++;
				}
				if(!isset($_SESSION['where']))
					$_SESSION['where']=$qstr;
				else
					$_SESSION['where'].=$qstr;
			}
			else
			{
				$qstr=$condi;
			}
			return $qstr;
		}
		public function query($qry){
			$_SESSION['query']=$qry;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=$r;
				$ret['msg']="successfully executed query";
				if(preg_match('/select/',$qry) && preg_match('/from/',$qry))
					$ret['num_rec']=mysqli_num_rows($r);
				$ret['status']=true;
				$ret['err']=0;
			}else if($af==0){
				$ret['data']=0;
				$ret['msg']="query has no affect";
				$ret['status']=false;
				$ret['err']=0;
				$ret['num_rec']=0;
			}else{
				$ret['data']=0;
				$ret['msg']="failed to get data";
				$ret['status']=false;
				$ret['err']=mysqli_error($this->conn);
				$ret['num_rec']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		private function convert(){
			echo extract($this->ret);
			ob_start();
			$buffer = ob_get_contents();
			@ob_end_clean();
			echo $buffer;
			return $buffer;
		}
		public function col_list($cols,$tab){
			$_SESSION['query']="select ".$cols." from ".$tab;
			$this->fire();
		}
		public function condition($arr,$sign,$op){
			$_SESSION['where']=" where ";
			$this->makestring($arr,$sign,$op);
		}
		public function create_table($tab,$data){
			$_SESSION['query']="create table ".$tab."(";
			$i=0;
			$qstr="";
			foreach($data as $k=>$v)
			{
				if($i==count($data)-1)
					$qstr.=" ".$k." ".$v."";
				else
					$qstr.=" ".$k." ".$v.",";
				$i++;
			}
			$qstr.=");";
			$_SESSION['query'].=$qstr;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if(mysqli_errno($this->conn)==0){
				$ret['msg']="successfully created table";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="failed to create table";
				$ret['status']=false;
			}
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function getall($tab){
			$_SESSION['query']="select * from ".$tab;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=$r;
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="successfully got all the data";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['data']=0;
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="failed to get data";
				$ret['status']=false;
				$ret['num_rec']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function get_where($tab,$data,$sym="",$op=""){
			$_SESSION['query']="select * from ".$tab." where ";
			$this->makestring($data,$sym,$op);
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=$r;
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="successfully got all the data";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['data']=0;
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="failed to get data";
				$ret['status']=false;
				$ret['num_rec']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function limit_where($tab,$data,$sym,$op,$s,$e){
			$_SESSION['query']="select * from ".$tab." where ";
			$this->makestring($data,$sym,$op);
			$_SESSION['query']=$this->createquery()." limit ".$s.",".$e;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=$r;
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="successfully got all the data";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['data']=0;
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="failed to get data";
				$ret['status']=false;
				$ret['num_rec']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function get_orderlim($tab,$data,$sym,$op,$ord_query,$s,$e){
			$_SESSION['query']="select * from ".$tab." where ";
			$this->makestring($data,$sym,$op);
			$_SESSION['query']=$this->createquery()." order by ".$ord_query." limit ".$s.",".$e;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=$r;
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="successfully got all the data";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['data']=0;
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="failed to get data";
				$ret['status']=false;
				$ret['num_rec']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function countall($tab){
			$qry="select * from ".$tab;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="counting successful";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="counting failed";
				$ret['status']=false;
				$ret['num_rec']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function count_where($tab,$data,$sym="",$op=""){
			$qry="select * from ".$tab." where ";
			$this->makestring($data,$sym,$op);
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="counting successful";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="counting failed";
				$ret['status']=false;
				$ret['num_rec']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function insert($tab,$data){
			$_SESSION['query']="insert into ".$tab." set ";
			$this->makestring($data,"","");
			$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=mysqli_insert_id($this->conn);
				$ret['msg']="Insert Successful";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['data']=0;
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="Insert failed";
				$ret['status']=false;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function set_order($col,$ord)
		{
			$qry=" order by ".$col." ".$ord;
			$_SESSION['order']=$qry;
		}
		public function execute_query($qry){
			$_SESSION['query']=$qry;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=$r;
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="successfully executed query";
				$ret['status']=true;
				$ret['err']=0;
			}else if($af==0){
				$ret['data']=0;
				$ret['num_rec']=0;
				$ret['msg']="query has no affect";
				$ret['status']=false;
				$ret['err']=0;
			}else{
				$ret['data']=0;
				$ret['num_rec']=0;
				$ret['msg']="failed to get data";
				$ret['status']=false;
				$ret['err']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function trunc($tab){
			$_SESSION['query']="truncate ".$tab;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				
			}else if($af==0){
				
			}else{
				
			}
		}
		public function delete_where($tab,$data,$sym,$op){
			$_SESSION['query']="delete from ".$tab." where ";
			$this->makestring($data,$sym,$op);
			$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['err']=0;
				$ret['msg']="Delete successful";
				$ret['status']=true;
			}else if($af==0){
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="query has no effect";
				$ret['status']=true;
			}else{
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="delete failed";
				$ret['status']=false;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function update($tab,$data,$cond,$sym,$op){
			$_SESSION['query']="update ".$tab." set ";
			$this->makestring($data,"","");
			$_SESSION['query']=$this->createquery()." where ";
			$this->makestring($cond,$sym,$op);
			$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['err']=0;
				$ret['msg']="update successful";
				$ret['status']=true;
			}else if($af==0){
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="query has no effect";
				$ret['status']=true;
			}else{
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="update failed";
				$ret['status']=false;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function order($tab,$col,$ord){
			$_SESSION['query']="select * from ".$tab." order by ".$col." ".$ord;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=$r;
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="successfully got ordered data";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="order failed";
				$ret['status']=false;
				$ret['num_rec']=0;
				$ret['data']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function order_where($tab,$cond,$sym,$op,$col,$ord){
			$_SESSION['query']="select * from ".$tab." where ";
			$this->makestring($cond,$sym,$op);
			$_SESSION['where'].=" order by ".$col." ".$ord;
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=$r;
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="successfully got ordered data";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="order failed";
				$ret['status']=false;
				$ret['num_rec']=0;
				$ret['data']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function join_tab($tab,$col,$arr,$sym,$op){
			if(empty($col) || !isset($col))
				$col="*";
			$_SESSION['query']="select ".$col." from ".$tab." where ";
			$this->makestring($arr,$sym,$op);
			$r=$this->fire();
			$af=mysqli_affected_rows($this->conn);
			if($af>0){
				$ret['data']=$r;
				$ret['num_rec']=mysqli_num_rows($r);
				$ret['msg']="successfully got joined data";
				$ret['status']=true;
				$ret['err']=0;
			}
			else{
				$ret['err']=mysqli_error($this->conn);
				$ret['msg']="join failed";
				$ret['status']=false;
				$ret['num_rec']=0;
				$ret['data']=0;
			}
			$ret['aff_rows']=$af;
			$ret['query']=$_SESSION['fq'];
			unset($_SESSION['fq']);
			return $ret;
		}
		public function __destruct(){
			mysqli_close($this->conn);
		}
	}
?>