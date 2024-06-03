<?php
require('util/Connection.php');
require('util/SessionCheck.php');
require('Header.php');

$id = $_POST['id'];
$tablename = "optimiseddata_".$id;
$tablename1 = "optimiseddata_".$id;
$leg = 0;
if(isset($_POST['step'])){
	if($_POST['step']=="leg1"){
		$leg = 1;
		$tablename = "optimiseddata_leg1_".$id;
		$tablename1 = "optimiseddata_leg1_".$id;
	}
	if($_POST['step']=="all"){
		$leg = 2;
		$leg_id = $_POST['legid'];
		$tablename1 = "optimiseddata_".$id;
		$tablename = "optimiseddata_leg1_".$leg_id;
	}
}

?>
<style>

		body {
            font-size: 15px; /* Set the base font size for the entire page */
        }

        /* Apply increased font size to specific elements */
        h3 {
            font-size: 24px; /* Increase font size for heading elements */
        }

        /* You can add similar styles for other elements as needed */
        /* For example: */
        th
        td {
            font-size: 18px; /* Increase font size for table headers and data cells */
        }

        .btn {
            font-size: 12px; /* Increase font size for buttons */
        }
		
		.table-container {
			width: 100%;
			overflow-x: auto;
		}
		
		table {
			width: 100%;
			border-collapse: collapse;
			background-color: #95b75d !important;
			color: black;
		}
		
        .thead tr th {
			background-color: #95b75d !important;
			color: black;
		}

		th,	td {
			border: 2px solid black;
			padding: 25px;
			text-align: center;
			color: black;
			border-color: black !important;
			
		}

		tr {
			border: 2px solid black; /* Set border for table rows */
		}
		.table > tfoot > tr > td {
			border-color: black !important;
			border-width: 2px !important;
		}


		/* Apply background color to even rows */
		#export_table tbody tr:nth-child(even) {
			background-color: #FFCF8B;
		}
    </style>

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="#">Home</a></li>
                    <li class="active">Optimised Data View</li>
                </ul>
                <!-- END BREADCRUMB -->


				<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="row">
                        <div class="col-md-12">

                            <!-- START SIMPLE DATATABLE -->
                            <div class="panel panel-default">
							<div class="panel-heading">
                                    <h3 class="panel-title">Optimised Data View</h3>
                                </div>
								<div style="float:right" style="margin:10px">
									<button id="downloadCSV" class="btn btn-warning" style="margin-bottom: 10px;" type="button">Download CSV</button>
									<button id="downloadXLSX" class="btn btn-success" style="margin-bottom: 10px;" type="button">Download XLSX</button>
								</div>
                                <div class="panel-body">
                                 <div class="table-responsive">
								 <div class="table-container">
                                    <table id="export_table" class="table">
                                        <thead>
                                            <tr>												
												<th style="font-size:16px">Scenario</th>
												<th style="font-size:16px">From</th>
												<th style="font-size:16px">From_State</th>
												<th style="font-size:16px">From_ID</th>
												<th style="font-size:16px">From_Name</th>
												<th style="font-size:16px">From_District</th>
												<th style="font-size:16px">From_Lat</th>
												<th style="font-size:16px">From_Long</th>
												<th style="font-size:16px">To</th>
												<th style="font-size:16px">To_State</th>
												<th style="font-size:16px">To_ID</th>
												<th style="font-size:16px">To_Name</th>
												<th style="font-size:16px">To_District</th>
												<th style="font-size:16px">To_Lat</th>
												<th style="font-size:16px">To_Long</th>
												<th style="font-size:16px">commodity</th>
												<th style="font-size:16px">quantity</th>
												<th style="font-size:16px">Distance</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
										if($leg==2){
											$query = "SELECT * FROM ".$tablename1." WHERE 1";
											$result = mysqli_query($con,$query);
											$numrows = mysqli_num_rows($result);
											while($row = mysqli_fetch_array($result))
											{
												
												if($row['new_id_admin']!=null or $row['new_id_admin']!=""){
													$id = $row['new_id_admin'];
													$query_warehouse = "SELECT latitude,longitude,district FROM warehouse WHERE id='$id'";
													$result_warehouse = mysqli_query($con,$query_warehouse);
													$numrows_warehouse = mysqli_num_rows($result_warehouse);
													if($numrows_warehouse!=0){
														$row_warehouse = mysqli_fetch_assoc($result_warehouse);
														$row["from_lat"] = $row_warehouse['latitude'];
														$row["from_long"] = $row_warehouse['longitude'];
														$row["from_district"] = $row_warehouse['district'];
													}
													$row["from_id"] = $row['new_id_admin'];
													$row["from_name"] = $row['new_name_admin'];
													$row["distance"] = $row['new_distance_admin'];
												}
												else if(($row['new_id_district']!=null or $row['new_id_district']!="") and $row['admin_approve']=="yes"){
													$id = $row['new_id_district'];
													$query_warehouse = "SELECT latitude,longitude,district FROM warehouse WHERE id='$id'";
													$result_warehouse = mysqli_query($con,$query_warehouse);
													$numrows_warehouse = mysqli_num_rows($result_warehouse);
													if($numrows_warehouse!=0){
														$row_warehouse = mysqli_fetch_assoc($result_warehouse);
														$row["from_lat"] = $row_warehouse['latitude'];
														$row["from_long"] = $row_warehouse['longitude'];
														$row["from_district"] = $row_warehouse['district'];
													}
													$row["from_id"] = $row['new_id_district'];
													$row["from_name"] = $row['new_name_district'];
													$row["distance"] = $row['new_distance_district'];
												}
												echo "<tr><td>{$row['scenario']}</td>".
													"<td>{$row['from']}</td>".
													"<td>{$row['from_state']}</td>".
													"<td>{$row['from_id']}</td>".
													"<td>{$row['from_name']}</td>".
													"<td>{$row['from_district']}</td>".
													"<td>{$row['from_lat']}</td>".
													"<td>{$row['from_long']}</td>".
													"<td>{$row['to']}</td>".
													"<td>{$row['to_state']}</td>".
													"<td>{$row['to_id']}</td>".
													"<td>{$row['to_name']}</td>".
													"<td>{$row['to_district']}</td>".
													"<td>{$row['to_lat']}</td>".
													"<td>{$row['to_long']}</td>".
													"<td>{$row['commodity']}</td>".
													"<td>{$row['quantity']}</td>".
													"<td>{$row['distance']}</td></tr>";
											}
										}
										
										$query = "SELECT * FROM ".$tablename." WHERE 1";
										$result = mysqli_query($con,$query);
										$numrows = mysqli_num_rows($result);
										while($row = mysqli_fetch_array($result))
										{
											
											if($row['new_id_admin']!=null or $row['new_id_admin']!=""){
												$id = $row['new_id_admin'];
												$query_warehouse = "SELECT latitude,longitude,district FROM warehouse WHERE id='$id'";
												$result_warehouse = mysqli_query($con,$query_warehouse);
												$numrows_warehouse = mysqli_num_rows($result_warehouse);
												if($numrows_warehouse!=0){
													$row_warehouse = mysqli_fetch_assoc($result_warehouse);
													$row["from_lat"] = $row_warehouse['latitude'];
													$row["from_long"] = $row_warehouse['longitude'];
													$row["from_district"] = $row_warehouse['district'];
												}
												$row["from_id"] = $row['new_id_admin'];
												$row["from_name"] = $row['new_name_admin'];
												$row["distance"] = $row['new_distance_admin'];
											}
											else if(($row['new_id_district']!=null or $row['new_id_district']!="") and $row['admin_approve']=="yes"){
												$id = $row['new_id_district'];
												$query_warehouse = "SELECT latitude,longitude,district FROM warehouse WHERE id='$id'";
												$result_warehouse = mysqli_query($con,$query_warehouse);
												$numrows_warehouse = mysqli_num_rows($result_warehouse);
												if($numrows_warehouse!=0){
													$row_warehouse = mysqli_fetch_assoc($result_warehouse);
													$row["from_lat"] = $row_warehouse['latitude'];
													$row["from_long"] = $row_warehouse['longitude'];
													$row["from_district"] = $row_warehouse['district'];
												}
												$row["from_id"] = $row['new_id_district'];
												$row["from_name"] = $row['new_name_district'];
												$row["distance"] = $row['new_distance_district'];
											}
											echo "<tr><td>{$row['scenario']}</td>".
												"<td>{$row['from']}</td>".
												"<td>{$row['from_state']}</td>".
												"<td>{$row['from_id']}</td>".
												"<td>{$row['from_name']}</td>".
												"<td>{$row['from_district']}</td>".
												"<td>{$row['from_lat']}</td>".
												"<td>{$row['from_long']}</td>".
												"<td>{$row['to']}</td>".
												"<td>{$row['to_state']}</td>".
												"<td>{$row['to_id']}</td>".
												"<td>{$row['to_name']}</td>".
												"<td>{$row['to_district']}</td>".
												"<td>{$row['to_lat']}</td>".
												"<td>{$row['to_long']}</td>".
												"<td>{$row['commodity']}</td>".
												"<td>{$row['quantity']}</td>".
												"<td>{$row['distance']}</td></tr>";
										}
										
										?>
                                        </tbody>
                                    </table>
									</div>
                                  </div>
                                </div>
                            </div>
                            <!-- END SIMPLE DATATABLE -->

                        </div>
                    </div>

                </div>
                <!-- PAGE CONTENT WRAPPER -->
            </div>
            <!-- END PAGE CONTENT -->
        </div>
        <!-- END PAGE CONTAINER -->



    <!-- START SCRIPTS -->
        <!-- START PLUGINS -->
        <script type="text/javascript" src="js/plugins/jquery/jquery.min.js"></script>
        <script type="text/javascript" src="js/plugins/jquery/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/plugins/bootstrap/bootstrap.min.js"></script>
        <!-- END PLUGINS -->

        <!-- THIS PAGE PLUGINS -->
        <script type='text/javascript' src='js/plugins/icheck/icheck.min.js'></script>
        <script type="text/javascript" src="js/plugins/mcustomscrollbar/jquery.mCustomScrollbar.min.js"></script>
        <script type="text/javascript" src="js/plugins/datatables/jquery.dataTables.min.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/tableExport.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/jquery.base64.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/html2canvas.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/sprintf.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/jspdf/jspdf.js"></script>
		<script type="text/javascript" src="js/plugins/tableexport/jspdf/libs/base64.js"></script>
        <script type="text/javascript" src="js/plugins.js"></script>
        <script type="text/javascript" src="js/actions.js"></script>
        <!-- END PAGE PLUGINS -->

        <script>
		function getDateString(){
			var currentDate = new Date();
			var year = currentDate.getFullYear();
			var month = currentDate.getMonth() + 1; // Month is zero-based, so we add 1
			var day = currentDate.getDate();
			var str = year + "-" + month + "-" + day;
			return str;
		}
		
		document.getElementById('downloadCSV').addEventListener('click', async function() {
			try {
				var tableName = '<?php echo $tablename ?>';
				var tableName1 = '<?php echo $tablename1 ?>';
				const csvResponse = await fetch('api/DownloadOptimalDataOptimised.php?format=csv&tableName='+tableName+'&tableName1='+tableName1);
				const csvBlob = await csvResponse.blob();
				downloadFile(csvBlob, 'Optimiseddata_' + getDateString() + '.csv');
			} catch (error) {
				console.error('Error downloading CSV file:', error);
			}
		});

		// Event listener for downloading XLSX
		document.getElementById('downloadXLSX').addEventListener('click', async function() {
			try {
				var tableName = '<?php echo $tablename ?>';
				var tableName1 = '<?php echo $tablename1 ?>';
				const excelResponse = await fetch('api/DownloadOptimalDataOptimised.php?format=xlsx&tableName='+tableName+'&tableName1='+tableName1);
				const excelBlob = await excelResponse.blob();
				downloadFile(excelBlob, 'Optimiseddata_' + getDateString() + '.xlsx');
			} catch (error) {
				console.error('Error downloading XLSX file:', error);
			}
		});
		
		// Functions for file download and PDF generation (similar to previous code)
		function downloadFile(blob, fileName) {
			const url = window.URL.createObjectURL(blob);
			const link = document.createElement('a');
			link.href = url;
			link.download = fileName;
			link.click();
			window.URL.revokeObjectURL(url);
		}


		</script>

    </body>
</html>
