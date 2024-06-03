<?php
require('../util/Connection.php');
require('../structures/Login.php');

require('Header.php');

$person = new Login;
$person->setUsername($_POST["username"]);
$person->setPassword($_POST["password"]);

$query = "SELECT * FROM login WHERE username='".$person->getUsername()."' AND password='".$person->getPassword()."'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);

if($numrows == 0){
	echo "Error : Password is incorrect";
}
else if($numrows > 0){
	$row = mysqli_fetch_assoc($result);
	$count = 1 + $row['count'];
	if($row["verified"]==0){
		echo "Error : Your account needs to be verified please contact admin";
	}
	else{
		$uniqueId = uniqid();
		$authToken = md5($uniqueId);
		$currentLoginTime = date("Y-m-d H:i:s");
		$queryUpdate = "UPDATE login SET token='$authToken',lastlogin='$currentLoginTime',count='$count' WHERE username='".$person->getUsername()."'";
		mysqli_query($con,$queryUpdate);
		
		$_SESSION['district_user'] = $person->getUsername();
		$_SESSION['district_password'] = $person->getPassword();
		$_SESSION['district_district'] = $row["role"];
		$_SESSION['district_token'] = $authToken;
		mysqli_close($con);
		echo "<script>window.location.href = '../Home.php';</script>";
	}
}

?>
<?php require('Fullui.php');  ?>