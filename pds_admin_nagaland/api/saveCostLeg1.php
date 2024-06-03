<?php
require('../util/Connection.php');
require('../util/SessionFunction.php');

if(!SessionCheck()){
	return;
}

require('Header.php');

foreach ($_POST as $key => $value) {
    // Check if the parameter starts with 'cost_' and is not empty
    if (substr($key, 0, 5) === 'cost_' && !empty($value)) {
        // Extract the ID from the parameter name
        $id = substr($key, 5);
		$value_temp = $value;
		$value = filter_var($value, FILTER_VALIDATE_FLOAT);
        if ($value === false) {
            // If $value is not a float, try casting it to int
            $value = filter_var($value, FILTER_VALIDATE_INT);
        }

        // If $value is not a valid float or int, skip this iteration
        if ($value === false) {
            echo "Error : Invalid value: $value_temp<br>";
			return;
        }
		else{
			// Update the optimised table where id equals the extracted ID
			$sql = "UPDATE optimised_table_leg1 SET cost = '$value' WHERE id = '$id'";

			if ($con->query($sql) === TRUE) {
				
			} else {
				echo "Error : updating record: " . $con->error;
				return;
			}
		}
    }
	echo "<script>window.location.href = '../PerformaLeg1.php';</script>";
}
?>

<?php require('Fullui.php');  ?>