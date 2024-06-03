<?php
require('../util/Connection.php');
require('../structures/Login.php');
session_start();
require('Header.php');

$person = new Login;
$person->setUsername($_POST["username"]);
$person->setPassword($_POST["password"]);

$query = "SELECT * FROM login WHERE username='".$person->getUsername()."' AND password='".$person->getPassword()."'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);

if($numrows == 0){
	echo "Error : Password is incorrect";
	exit();
}
else{
	$row = mysqli_fetch_assoc($result);
	if($row['role']=="admin"){
		$count = 1 + $row['count'];
		$uniqueId = uniqid();
		$authToken = md5($uniqueId);
		$currentLoginTime = date("Y-m-d H:i:s");
		$queryUpdate = "UPDATE login SET token='$authToken',lastlogin='$currentLoginTime',count='$count' WHERE username='".$person->getUsername()."'";
		mysqli_query($con,$queryUpdate);
		
		$_SESSION['user'] = $person->getUsername();
		$_SESSION['token'] = $authToken;
		
		mysqli_close($con);
		echo "<script>window.location.href = '../Home.php';</script>";
	}else{
		echo "Error : You are not authorised to view this";
		exit();
	}
}

?>
<?php require('Fullui.php');  ?>