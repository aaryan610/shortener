<?php
error_reporting(0);
include('panel/functions.php');
$server="localhost";
$user="clinger610";
$pass="Caption*123";
$db="youtube";
$con=mysqli_connect($server,$user,$pass,$db);

if(isset($_GET['l'])){
	$l=sanitize_data($con,$_GET['l']);
	$res=mysqli_query($con,"select * from shorturl where short_link='$l' and status='1'");
	$count=mysqli_num_rows($res);
	if($count>0){
		$row=mysqli_fetch_assoc($res);
		$link=$row['link'];
		$user_tname=$row['user'];
		mysqli_query($con,"update shorturl set hit_count=hit_count+1 where short_link='$l'");
		if($user_tname!="users") {
			mysqli_query($con,"update $user_tname set hit_count=hit_count+1 where short_link='$l'");
		}
		header('location:'.$link);
		die();
	}
	else {
		?>
		<script type="text/javascript">
			window.location="panel/form.php";
		</script>
		<?php 
	}
}
?>