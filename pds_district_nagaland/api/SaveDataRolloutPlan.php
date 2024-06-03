<?php
require('../util/Connection.php');
require('../util/SessionCheck.php');

require('Header.php');
set_time_limit(300); // Set to 300 seconds (5 minutes), or 0 for no limit

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
	$parts = explode("_", $key,3);
	$fromid = $parts[0];
	$toid = $parts[1];
	$toid = str_replace('_', '.', $toid);
	if($value=="yes"){
		$query = "SELECT * FROM " . $tablename . " WHERE from_id='$fromid' AND to_id='$toid'";
		$result = mysqli_query($con, $query);
		$numrows = mysqli_num_rows($result);
		if($numrows==0){
			$query = "SELECT * FROM " . $tablename . " WHERE new_id_admin='$fromid' AND to_id='$toid'";
			$result = mysqli_query($con, $query);
			$numrows = mysqli_num_rows($result);
			if($numrows==0){
				$query = "SELECT * FROM " . $tablename . " WHERE new_id_district='$fromid' AND to_id='$toid'";
				$result = mysqli_query($con, $query);
				$numrows = mysqli_num_rows($result);
				if($numrows!=0){
					$query = "UPDATE " . $tablename . " SET status='implemented' WHERE new_id_district='$fromid' AND to_id='$toid'";
					mysqli_query($con,$query);
				}
			}
			else{
				$query = "UPDATE " . $tablename . " SET status='implemented' WHERE new_id_admin='$fromid' AND to_id='$toid'";
				mysqli_query($con,$query);
			}
		}
		else{
			$query = "UPDATE " . $tablename . " SET status='implemented' WHERE from_id='$fromid' AND to_id='$toid'";
			mysqli_query($con,$query);
		}
	}
}
mysqli_close($con);
echo "<script>window.location.href = '../RolloutPlan.php';</script>";
?>
<?php require('Fullui.php');  ?>