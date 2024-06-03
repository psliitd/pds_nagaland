<?php
require('../util/Connection.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');

if(!SessionCheck()){
	return;
}

require('Header.php');

$uid = $_POST["uid"];
$query = "DELETE FROM user_message WHERE id='$uid'";
mysqli_query($con,$query);
mysqli_close($con);

echo "<script>window.location.href = '../SendMessage.php';</script>";


?>
<?php require('Fullui.php');  ?>