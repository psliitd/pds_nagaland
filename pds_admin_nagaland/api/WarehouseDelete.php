<?php

require('../util/Connection.php');
require('../structures/Warehouse.php');
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

$Warehouse = new Warehouse;
$Warehouse->setUniqueid($_POST['uid']);

$query = $Warehouse->delete($Warehouse);

if($_POST['uid']=="all"){
	$query = $Warehouse->deleteall($Warehouse);
}

mysqli_query($con,$query);
mysqli_close($con);
echo "<script>window.location.href = '../Warehouse.php';</script>";


?>
<?php require('Fullui.php');  ?>