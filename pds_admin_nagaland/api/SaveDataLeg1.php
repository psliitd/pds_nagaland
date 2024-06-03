<?php
require('../util/Connection.php');
require('../util/SessionCheck.php');
require('Header.php');

$query = "SELECT * FROM optimised_table_leg1 ORDER BY last_updated DESC LIMIT 1";
$result = mysqli_query($con,$query);
$response = array();
$id = "";
while($row = mysqli_fetch_array($result))
{
	$id= $row["id"];
}


$tablename = "optimiseddata_leg1_".$id;


foreach ($_POST as $key => $value) {	
	if (substr($key, -8) === '_approve'){
		if($value=="yes"){
			$query = "UPDATE " . $tablename . " SET district_change_approve='yes' WHERE from_id='$fromid' AND to_id='$toid'";
		}
		else if($value=="no"){
			$query = "UPDATE " . $tablename . " SET district_change_approve='no' WHERE from_id='$fromid' AND to_id='$toid'";
		}
		mysqli_query($con,$query);
		echo $query;
	}	
	if (substr($key, -11) === '_iddistance' or substr($key, -9) === '_idreason' or substr($key, -8) === '_approve' or $value===""){
		continue;
	}
	$parts = explode("_", $key,3);
	$fromid = $parts[0];
	$toid = $parts[1];
	$toid = str_replace('_', '.', $toid);
	if($value=="yes"){
		$query = "UPDATE " . $tablename . " SET approve_admin='yes' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	else if($value=="same"){
		$query = "UPDATE " . $tablename . " SET approve_admin='no' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	else if($value=="no"){
		// this case will not fall as we have check for this in js
		$query = "UPDATE " . $tablename . " SET approve_admin='', new_id_admin='' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	else{
		$query_name = "SELECT name FROM warehouse_leg1_".$id." WHERE id='$value'";
		$result_name = mysqli_query($con,$query_name);
		$row_name = mysqli_fetch_assoc($result_name);
		$name = $row_name['name'];
		$reason = $_POST[$key."_idreason"];
		$distance = $_POST[$key."_iddistance"];
		$query = "UPDATE " . $tablename . " SET new_id_admin='$value', new_name_admin='$name', approve_admin='yes', new_distance_admin='$distance', reason_admin='$reason' WHERE from_id='$fromid' AND to_id='$toid'";
	}
	//echo $query;
	mysqli_query($con,$query);
}
mysqli_close($con);

echo "<script>window.location.href = '../OptimisedDataLeg1.php';</script>";

?>
<?php require('Fullui.php');  ?>