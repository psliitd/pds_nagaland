<?php

require('../util/Connection.php');
require('../structures/FPS.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');

if(!SessionCheck()){
	return;
}

require('Header.php');


$person = new Login;
$person->setUsername($_POST["username"]);
$person->setPassword($_POST["password"]);

if($_SESSION['user']!=$person->getUsername()){
	echo "User is logged in with different username and password";
	return;
}

$query = "SELECT * FROM login WHERE username='".$person->getUsername()."' AND password='".$person->getPassword()."'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);

if($numrows == 0){
	echo "Error : Password or Username is incorrect";
	return;
}

$FPS = new FPS;
$FPS->setUniqueid($_POST['uid']);

$query = $FPS->delete($FPS);

if($_POST['uid']=="all"){
	$query = $FPS->deleteall($FPS);
}

mysqli_query($con,$query);
mysqli_close($con);
echo "<script>window.location.href = '../FPS.php';</script>";


?>
<?php require('Fullui.php');  ?>