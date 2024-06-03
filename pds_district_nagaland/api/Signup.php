<?php
require('../util/Connection.php');
require('../structures/Login.php');

require('Header.php');

$password = $_POST['password'];
$confirmpassword = $_POST['confirmpassword'];

if($password=="" || $confirmpassword==""){
	echo "Error : Password is Empty";
	return;
}
if($password!=$confirmpassword){
	echo "Error : Both Password doesn't match";
	return;
}

$person = new Login;
$person->setUsername($_POST["username"]);
$person->setPassword($_POST["password"]);
$person->setRole($_POST["district"]);
$uid = uniqid();

if($_SESSION['district_user']!=$person->getUsername()){
	echo "User is logged in with different username and password";
	return;
}

$query = "SELECT * FROM login WHERE username='".$person->getUsername()."'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);

if($numrows == 1){
	echo "Error : Username already exist";
}
else if($numrows == 0){
	$query1 = "INSERT INTO login (username,password,uid,role,verified) VALUES ('".$person->getUsername()."','".$person->getPassword()."','$uid','".$person->getRole()."','0')";
	mysqli_query($con,$query1);

	mysqli_close($con);
	echo "<script>window.location.href = '../Login.html';</script>";
}
?>
<?php require('Fullui.php');  ?>