<?php
session_start();
if(isset($_SESSION['key'])) {
unset($_SESSION['key']);
unset($_SESSION['id']);
unset($_SESSION['tname']);
session_destroy();
?>
<script type="text/javascript">
   window.location="login.php";
</script>
<?php
}
else {
?>
<script type="text/javascript">
   window.location="login.php";
</script>
<?php } ?>