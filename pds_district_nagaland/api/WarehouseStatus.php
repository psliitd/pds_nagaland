<?php

require('../util/Connection.php');
require('../util/SessionFunction.php');

if(!SessionCheck()){
	return;
}

require('Header.php');

$id = $_POST["uid"];

$query = "SELECT * FROM warehouse WHERE uniqueid='$id'";
$result = mysqli_query($con,$query);
$numrows = mysqli_num_rows($result);

if($numrows>0){
	$row = mysqli_fetch_assoc($result);
	$status = $row['active'];
	if($status==0){
		$query = "UPDATE warehouse SET active='1' WHERE uniqueid='$id'";
		mysqli_query($con,$query);
	}
	else{
		$query = "UPDATE warehouse SET active='0' WHERE uniqueid='$id'";
		mysqli_query($con,$query);
	}
}


mysqli_close($con);
echo "<script>window.location.href = '../Warehouse.php';</script>";

?>
<?php require('Fullui.php');  ?>