<?php
require('../util/Connection.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');

if(!SessionCheck()){
	return;
}

$query = "SELECT * FROM optimised_table_leg1 ORDER BY last_updated DESC LIMIT 1";
$result = mysqli_query($con,$query);
$response = array();
$id = "";
while($row = mysqli_fetch_array($result))
{
	$id = $row["id"];
}


$tablename = "optimiseddata_leg1_".$id;
$reviewed = "";
$approved = "";
$fromid = "";
$toid = "";

if(isset($_POST['approved'])){
	$approved = $_POST['approved'];
}

if(isset($_POST['reviewed'])){
	$reviewed = $_POST['reviewed'];
}


$query = "SELECT * FROM " . $tablename . " WHERE 1";

if (isset($_POST['fromid']) && !empty($_POST['fromid'])) {
    $fromid = $_POST['fromid'];
    $query .= " AND from_id = '$fromid'";
}

if (isset($_POST['toid']) && !empty($_POST['toid'])) {
    $toid = $_POST['toid'];
    $query .= " AND toid = '$toid'";
}

if ($reviewed == "reviewed") {
    $query .= " AND reviewed='yes'";
} else if ($reviewed == "notreviewed") {
    $query .= " AND reviewed<>'yes'";
}

if ($approved == "approved") {
    $query .= " AND approve='yes'";
} else if ($approved == "notapproved") {
    $query .= " AND approve<>'yes'";
}

$result = mysqli_query($con,$query);
while($row = mysqli_fetch_assoc($result))
{
	$data[] = $row;
}

$query_warehouse = "SELECT * from warehouse_leg1_".$id." WHERE 1";
$result_warehouse = mysqli_query($con,$query_warehouse);
while($row_warehouse = mysqli_fetch_assoc($result_warehouse)){
	$warehouse[] = $row_warehouse;
}
$resultarray = [];
if($data==null){
	$data = array();
}
$resultarray["data"] = $data;
$resultarray["warehouse"] = $warehouse;
echo json_encode($resultarray);

?>