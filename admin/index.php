<?php
include('panel/functions.php');
$server="localhost";
$user="root";
$pass="";
$db="youtube";
$con=mysqli_connect($server,$user,$pass,$db);
$tname="blog";
$per_page=6;
$start=0;
$current_page=1;
if(isset($_GET['start'])) {
	$start=sanitize_data($con,$_GET['start']);
	if($start<=0) {
		$start=0;
		$check=$start;
		$current_page=1;
	}
	else {
		$current_page=$start;
		$check=$start;
		$start--;
		$start=$start*$per_page;
	}
}
$record=mysqli_num_rows(mysqli_query($con,"select * from $tname"));
$pagi=ceil($record/$per_page);

if($check>$pagi) {
	$start=$pagi;
	$current_page=$start;
	$start--;
	$start=$start*$per_page;
}

$con=mysqli_connect($server,$user,$pass,$db);
$sql=mysqli_query($con,"select * from $tname where status='1' limit $start,$per_page");
?>
<!DOCTYPE html>
<html>
<head>
	<title>llity- Blog</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@800&display=swap" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/style_responsive.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	<script src="https://kit.fontawesome.com/2db302fe2c.js" crossorigin="anonymous"></script>
</head>
<body>

	<div class="contents">

		<div class="navbar">
			<h2><a href="https://blog.litty.tech">blog.llity.tech</a></h2>
		</div>

		<div class="container-fluid">
			<div class="heading">
				<h2>News, latest updates and information brought to you by <a href="https://llity.tech" target="_blank">llity.tech</a></h2>
			</div>
		</div>

		<div class="blogs">
			<div class="container-fluid">
				<?php $i=1; while($row=(mysqli_fetch_assoc($sql))) {
					if($i%2!=0) { ?>
					<div class="row_card">
					<?php } ?>
						<div class="column_card">
							<div class="card">
								<img class="card-img-top" src="images/choc.jpg" alt="Card image">
								<div class="card-body">
									<h4 class="card-title"><?php echo $row['title']; ?></h4>
									<p class="card-text"><?php echo $row['short_desc']; ?></p>
									<a href="post.php?id=<?php echo $row['id']; ?>&title=<?php echo $row['title']; ?>" class="btn btn-info" target="_blank">Read More&nbsp&nbsp</a>
								</div>
							</div>
						</div>
					<?php if($i%2==0) { ?>
					</div>
				<?php } $i++; } ?>
			</div>
			<div class="pagination_btn">
				<ul>
					<?php for($i=1;$i<=$pagi;$i++) { 
						if($current_page==$i) {
					?>
							<li class="active"><a href="javascript:void(0)"><button><?php echo $i; ?></button></a></li>
					<?php } else { ?>
							<li class="inactive"><a href="?start=<?php echo $i; ?>"><button><?php echo $i; ?></button></a></li>
					<?php } } ?>
				</ul>
			</div>
		</div>

	</div>

</body>
</html>
<?php
?>