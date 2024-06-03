<?php
require('util/Connection.php');
require('util/SessionCheck.php');
require('Header.php');

$id = $_POST['id'];
$tablename = "fps_".$id;
$tablename1 = "fps_".$id;

$leg = 0;
if(isset($_POST['step'])){
	if($_POST['step']=="leg1"){
		$leg = 1;
		$tablename = "fci_leg1_".$id;
		$tablename1 = "fci_leg1_".$id;
	}
	if($_POST['step']=="all"){
		$leg = 2;
		$leg_id = $_POST['legid'];
		$tablename1 = "fps_".$id;
		$tablename = "fci_leg1_".$leg_id;
	}
}
?>
<style>
    td {
            font-size: 15px; /* Increase font size for table headers and data cells */
        }
        .table thead tr th {
    background-color: #95b75d !important;
    /* border: 2px solid #777; */
    color: black;
    /* Optional: Font size for table header */
}
    </style>

                <!-- START BREADCRUMB -->
                <ul class="breadcrumb">
                    <li><a href="FPS.php">Home</a></li>
                    <li class="active">FPS View</li>
                </ul>
                <!-- END BREADCRUMB -->


				<!-- PAGE CONTENT WRAPPER -->
                <div class="page-content-wrap">

                    <div class="row">
                        <div class="col-md-12">

                            <!-- START SIMPLE DATATABLE -->
                            <div class="panel panel-default">
							<div class="panel-heading">
                                    <h3 class="panel-title">FPS</h3>
                                </div>
								<div style="float:right" style="margin:10px">
									<button id="downloadCSV" class="btn btn-warning" style="margin-bottom: 10px;" type="button">Download CSV</button>
									<button id="downloadXLSX" class="btn btn-success" style="margin-bottom: 10px;" type="button">Download XLSX</button>
								</div>
                                <div class="panel-body">
                                 <div class="table-responsive">
									<table id="export_table" class="table datatable">
                                        <thead>
                                            <tr>
												<th style="font-size:16px">District</th>
												<th style="font-size:16px">Name of FPS</th>
												<th style="font-size:16px">FPS ID</th>
												<th style="font-size:16px">Model FPS/Normal FPS</th>
												<th style="font-size:16px">Latitude</th>
												<th style="font-size:16px">Longitude</th>
												<th style="font-size:16px">Allocation Wheat</th>
												<th style="font-size:16px">Allocation Rice</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
											$query = "SELECT * FROM ".$tablename1." WHERE 1";
											$result = mysqli_query($con,$query);
											$numrows = mysqli_num_rows($result);
											while($row = mysqli_fetch_assoc($result))
											{
												echo "<tr><td>{$row['district']}</td>".
												"<td>{$row['name']}</td>".
												"<td>{$row['id']}</td>".
												"<td>{$row['type']}</td>".
												"<td>{$row['latitude']}</td>".
												"<td>{$row['longitude']}</td>".
												"<td>{$row['Allocation_Wheat']}</td>".
												"<td>{$row['Allocation_Rice']}</td></tr>";
											}
										?>
                                        </tbody>
                                    </table>
									<?php if($leg==2){ ?>
                                    
									<table id="export_table" class="table datatable">
                                        <thead>
                                            <tr>
												<th style="font-size:16px">District</th>
												<th style="font-size:16px">Name of FPS</th>
												<th style="font-size:16px">FPS ID</th>
												<th style="font-size:16px">Model FPS/Normal FPS</th>
												<th style="font-size:16px">Latitude</th>
												<th style="font-size:16px">Longitude</th>
												<th style="font-size:16px">Storage</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										<?php
										
										
										$query = "SELECT * FROM ".$tablename." WHERE 1";
										$result = mysqli_query($con,$query);
										$numrows = mysqli_num_rows($result);
										while($row = mysqli_fetch_assoc($result))
										{
											echo "<tr><td>{$row['district']}</td>".
											"<td>{$row['name']}</td>".
											"<td>{$row['id']}</td>".
											"<td>{$row['type']}</td>".
											"<td>{$row['latitude']}</td>".
											"<td>{$row['longitude']}</td>".
											"<td>{$row['storage']}</td></tr>";
										}
										
										?>
                                        </tbody>
                                    </table>
                                  <?php } ?>
									
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

        <!-- START TEMPLATE -->
        
        <!-- END TEMPLATE -->
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
				const csvResponse = await fetch('api/DownloadOptimalDataFPS.php?format=csv&tableName='+tableName+'&tableName1='+tableName1);
				const csvBlob = await csvResponse.blob();
				downloadFile(csvBlob, 'FPS_' + getDateString() + '.csv');
			} catch (error) {
				console.error('Error downloading CSV file:', error);
			}
		});

		// Event listener for downloading XLSX
		document.getElementById('downloadXLSX').addEventListener('click', async function() {
			try {
				var tableName = '<?php echo $tablename ?>';
				var tableName1 = '<?php echo $tablename1 ?>';
				const excelResponse = await fetch('api/DownloadOptimalDataFPS.php?format=xlsx&tableName='+tableName+'&tableName1='+tableName1);
				const excelBlob = await excelResponse.blob();
				downloadFile(excelBlob, 'FPS_' + getDateString() + '.xlsx');
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
