<?php
require('../util/Connection.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');

if(!SessionCheck()){
	return;
}

require('Header.php');

$uid = $_POST["uid"];
$query = "UPDATE user_message SET acknowledged='yes' WHERE id='$uid'";
mysqli_query($con,$query);
mysqli_close($con);

echo "<script>window.location.href = '../Message.php';</script>";


?>
<?php require('Fullui.php');  ?>