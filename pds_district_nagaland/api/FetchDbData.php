<?php
require('../util/Connection.php');
require('../util/SessionFunction.php');
require('../structures/Login.php');

if(!SessionCheck()){
	return;
}

$query = "SELECT * FROM optimised_table ORDER BY last_updated DESC LIMIT 1";
$result = mysqli_query($con,$query);
$response = array();
$id = "";
while($row = mysqli_fetch_array($result))
{
	$id= $row["id"];
}


$tablename = "optimiseddata_".$id;

$district = $_SESSION['district_district'];
$reviewed = "";
$approved = "";

if(isset($_POST['approved'])){
	$approved = $_POST['approved'];
}

if(isset($_POST['reviewed'])){
	$reviewed = $_POST['reviewed'];
}

$data = array();

$query = "SELECT * FROM " . $tablename . " WHERE to_district='$district'";
if($reviewed=="reviewed"){
	$query = "SELECT * FROM " . $tablename . " WHERE to_district='$district' AND approve_district='yes'";
}
else if($reviewed=="notreviewed"){
	$query = "SELECT * FROM " . $tablename . " WHERE to_district='$district' AND approve_district<>'yes'";
}

if($approved=="approved"){
	$query = "SELECT * FROM " . $tablename . " WHERE to_district='$district' AND approve_admin='yes'";
}
else if($approved=="notapproved"){
	$query = "SELECT * FROM " . $tablename . " WHERE to_district='$district' AND approve_admin<>'yes'";
}

$result = mysqli_query($con,$query);
while($row = mysqli_fetch_array($result))
{
	$data[] = $row;
}

$query_warehouse = "SELECT * from warehouse WHERE district='$district' ";
$result_warehouse = mysqli_query($con,$query_warehouse);
while($row_warehouse = mysqli_fetch_array($result_warehouse)){
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