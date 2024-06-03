<?php
require('../util/Connection.php');
require('../util/SessionCheck.php');

require('Header.php');

set_time_limit(300); // Set to 300 seconds (5 minutes), or 0 for no limit

//echo json_encode($_POST);
//exit();

$query = "SELECT * FROM optimised_table ORDER BY last_updated DESC LIMIT 1";
$result = mysqli_query($con,$query);
$response = array();
$id = "";
while($row = mysqli_fetch_array($result))
{
	$id= $row["id"];
}


$tablename = "optimiseddata_".$id;

foreach ($_POST as $key => $value) {
	if (substr($key, -11) === '_iddistance' or substr($key, -9) === '_idreason' or $value===""){
		continue;
	}
	$parts = explode("_", $key,3);
	$fromid = $parts[0];
	$toid = $parts[1];
	$toid = str_replace('_', '.', $toid);
	if($value=="yes"){
		$query = "UPDATE " . $tablename . " SET approve_district='yes' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	else if($value=="no"){
		$query = "UPDATE " . $tablename . " SET approve_district='', new_id_district='' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	else{
		$query_name = "SELECT name FROM warehouse WHERE id='$value'";
		$result_name = mysqli_query($con,$query_name);
		$row_name = mysqli_fetch_assoc($result_name);
		$name = $row_name['name'];
		$reason = $_POST[$key."_idreason"];
		$distance = $_POST[$key."_iddistance"];
		$query = "UPDATE " . $tablename . " SET new_id_district='$value', new_name_district='$name', approve_district='yes', new_distance_district='$distance', reason_district='$reason' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	mysqli_query($con,$query);
}
mysqli_close($con);
echo "<script>window.location.href = '../Home.php';</script>";
?>
<?php require('Fullui.php');  ?>