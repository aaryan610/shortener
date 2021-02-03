<?php
error_reporting(0);
$server="localhost";
$user="clinger610";
$pass="Caption*123";
$db="youtube";
$con=mysqli_connect($server,$user,$pass,$db);
if(isset($_GET['l']))
{
	 $l=mysqli_real_escape_string($con,$_GET['l']);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Redirecting...</title>
	<style type="text/css">
		span {
			font-size: 45px;
		}
	</style>
	<script type="text/javascript">
		function DelayedRedirect() {
			window.location = "redirect.php?l=<?php echo $l; ?>";
		}
	</script>
</head>
<body onload="setTimeout('DelayedRedirect()',5000)">
	<div style="margin-top: 30px; text-align: center;">
		<span id="countdown">5</span>&nbsp&nbsp&nbsp<span id="plural">seconds</span>
		<h1>Please wait while we redirect you!!</h1>
	</div>

	<script type="text/javascript">
		var seconds = document.getElementById("countdown").textContent;
		var countdown = setInterval(function() {
			seconds--;
			(seconds==1)?document.getElementById("plural").textContent="second":document.getElementById("plural").textContent="seconds";
			document.getElementById("countdown").textContent = seconds;
			if(seconds<=0) clearInterval(countdown);
		}, 1000);
	</script>
</body>
</html>
<?php
	}
	else {
		?>
		<script type="text/javascript">
			window.location = "panel/form.php";
		</script>
		<?php
	}
?>