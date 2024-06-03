<?php
require('util/Connection.php');
require('util/SessionCheck.php');
require('Header.php');
// require('header2.php');
?>

<head>
	<link href='https://fonts.googleapis.com/css?family=Roboto+Condensed:400,300' rel='stylesheet' type='text/css'>

</head>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
	.multiselect {
	  width: 200px;
	  z-index: 2;
	}

	.selectBox {
	  position: relative;
	  z-index: 3;
	}

	.selectBox select {
	  width: 100%;
	  font-weight: bold;
	  z-index: 4;
	}

	.overSelect {
	  position: absolute;
	  left: 0;
	  right: 0;
	  top: 0;
	  bottom: 0;
	  z-index: 5;
	}

	#checkboxes {
	  display: none;
	  border: 1px #dadada solid;
	  color:#000;
	  z-index: 6;
	}

	#checkboxes label {
	  display: block;
	  color:#000;
	  z-index: 7;
	}

	#checkboxes label:hover {
	  background-color: #1e90ff;
	  z-index: 7;
	}

	#processingPopup {
		display: none;
		position: fixed;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;
		background-color: rgba(255, 255, 255, 0.8);
		align-items: center;
		justify-content: center;
		z-index: 9999;
	}

	#processingPopup .spinner {
		border: 6px solid #3498db;
		border-top: 6px solid #f39c12;
		border-radius: 50%;
		width: 40px;
		height: 40px;
		animation: spin 1s linear infinite;
	}

	#optimisedtable {
		border-collapse: collapse;
		width: 100%;
		margin-top: 0px;
	}

	#optimisedtable th,
	#optimisedtable td {
		border: 1px solid #ddd;
		padding: 8px;
		text-align: center;
	}

	#optimisedtable th {
		background-color: #5E35B1;
		color: white;
	}

	#optimisedtable tbody tr:nth-child(even) {
		background-color: #f2f2f2;
	}

	#optimisedtable tbody tr:hover {
		background-color: #ddd;
	}

	.help-block b {
		font-weight: bold;
	}

	*,
	*:before,
	*:after {
		box-sizing: border-box;
	}

	/* html {
	  font-family: 'Roboto Condensed', sans-serif;
	  display: flex;
	  justify-content: center;
	  align-items: center;
	  text-align: center;
	  height: 100%;
	  color: #ECEFF1;
	  background-image: radial-gradient(lighten(#263238, 20%), #263238);
	} */

	.toggle {
		position: relative;
		display: block;
		margin: 0 auto;
		width: 140px;
		height: 40px;
		color: black;
		outline: 0;
		text-decoration: none;
		border-radius: 60px;
		border: 2px solid #546E7A;
		background-color: white;
		transition: all 500ms;
		cursor: pointer;
		/* Added cursor style */
	}

	.toggle:active {
		background-color: darken(red, 5%);
	}

	.toggle:hover:not(.toggle--moving):after {
		background-color: green;
	}

	.toggle:after {
		content: attr(data-content);
		/* Use content attribute to display On/Off */
		display: block;
		position: absolute;
		top: 0px;
		bottom: 1px;
		left: 1px;
		width: calc(50% - 4px);
		line-height: 52px;
		/* Adjust line-height for vertical centering */
		text-align: center;
		text-transform: uppercase;
		font-size: 20px;
		color: white;
		background-color: red;
		border: 2px solid;
		transition: all 500ms;
		border-radius: 50px;
	}

	.toggle--on:after {
		transform: translate(100%, 0);
		color: whitesmoke;
		background-color: green;
	}

	.toggle--off:after {
		color: whitesmoke;
		background-color: red;
	}

	.toggle--moving {
		background-color: darken(#263238, 5%);
	}

	.toggle--moving:after {
		color: transparent;
		border-color: darken(#546E7A, 8%);
		background-color: darken(white, 10%);
		transition: color 0s, transform 500ms, border-radius 500ms, background-color 500ms;
	}

	/* h1 {
	  font-size: 34px;
	  margin-top: 0;
	  margin-bottom: -12px;
	} */

	@keyframes spin {
		0% {
			transform: rotate(0deg);
		}

		100% {
			transform: rotate(360deg);
		}
	}

	.btn {
		border-radius: 20px;
		/* Set border radius */
		/* Add other button styles as needed */
	}

	.upload_button_class {
		background-color: #F2F3F5;
		border-radius: 30px;
		box-shadow: -10px -10px 15px 0 #f6f6f6, 10px 10px 15px 0 #cecece;
		color: #676767;
		height: 40px;
		margin: auto;
		padding: 0;
		/* Adjust padding as needed */
		text-align: center;
		transition: all .2s ease;
		width: 276px;
		border: none;
		/* Remove border for this button */
		cursor: pointer;
		/* Add cursor pointer to indicate interactivity */
		display: flex;
		/* Allow flexible layout */
		justify-content: center;
		/* Center content horizontally */
		align-items: center;
		/* Center content vertically */
		margin-left: 481px;

	}

	.panel-footer {
		padding: 0;
		/* Remove padding for the entire panel-footer */
	}

	.panel-footer .btn {
		padding: 2px 10px;
		/* Apply padding to the button */
	}
	#optimisedtable th {
    text-align: center; /* Center-align the text within table headers */
}
*{
      box-sizing: border-box;
    }

    button {
      outline: none;
      cursor: pointer;
    }

    .icon {
      display: inline-block;
      width: 1em;
      height: 1em;
      fill: currentColor;
    }

    body {
      font-family: 'Open Sans', sans-serif;
      font-size: 16px;
      color: #fff;
      background: linear-gradient(to right, #566a39 0%, #75986f 100%);
    }

	.button-wrapper {
  position: relative;
  display: inline-block;
  padding: 2px 3px; /* Adjust padding */
  min-width: 10px; /* Adjust minimum width */
  min-height: 40px; /* Adjust minimum height */
  border-radius: 15px; /* Adjust border-radius */
  box-shadow: 0px -1px 1px rgba(255, 255, 255, 0.22), inset 0px -1px 3px rgba(0, 0, 0, 0.2);
}

.button {
  position: relative;
  height: 40px; /* Adjust height */
  min-width: 5px; /* Adjust minimum width */
  padding: 0 5px; /* Adjust padding */
  border-radius: 15px; /* Adjust border-radius */
  background: #ff005a;
  background: linear-gradient(#ff4184 0%, #ff005a 100%, #ff005a);
  border: none;
  font-size: 10px; /* Adjust font size */
  color: white;
  line-height: 40px; /* Adjust line height */
  font-weight: 700;
}


    .button__text {
      position: relative;
      display: block;
      height: 114px;
      white-space: nowrap;
      opacity: 1;
    }

    .button__text--download {
      width: 150px;
      transition: opacity 0.5s ease, width 0.5s ease;

      &.is_animated {
        overflow: hidden;
        width: 0px;
        opacity: 0;
      }
    }

    .button__text--progress {
      margin-right: -35px;
      margin-left: -35px;
      width: 114px;
      font-size: 40px;
      opacity: 0;
      transition: opacity 0.5s ease;

      sub {
        font-size: .5em;
        font-weight: normal;
      }

      &.is_animated {
        opacity: 1;
      }
    }

    .button__text--complete {
      position: absolute;
      top: 0;
      left: 0;
      z-index: 999;
      border-radius: 50%;
      height: 114px;
      width: 114px;
      box-shadow: inset 0px -1px 6px 0px rgba(255, 255, 255, 0.73);
      background: #3acaff;
      transform: scale(1.5);
      transition: transform 0.5s ease;

      &.is_animated {
        transform: scale(1);
      }
    }

    .button__icon--cloud-download,
    .button__icon--checkmark {
      position: relative;
      top: 7px;
    }

    .pie-loader {
      position: absolute;
      top: 0;
      left: 0;
      z-index: -1;
      width: 160px;
      height: 160px;
      opacity: 1;
      transition: opacity 0.1s ease;

      svg {
        width: 100%;
        height: 100%;
      }

      circle {
        fill: #3acaff;
        stroke: #3acaff;
        stroke-width: 80px;
        stroke-dasharray: 0 252;
        transition: all 0.1s linear;
      }

      &.is_hidden {
        opacity: 0;
      } 
    }
.btn btn-success pull-right{
	
}
</style>

<!-- START BREADCRUMB -->
<ul class="breadcrumb">
	<li><a href="#">Home</a></li>
	<li class="active">Punjab Intra Route Optimization For PDS</li>
</ul>
<!-- END BREADCRUMB -->
<div>
	
</div>

<!-- PAGE CONTENT WRAPPER -->
<div class="page-content-wrap"
	style="background-image: url('img/1 (2).png'); background-repeat: no-repeat; background-size: cover;">

	<div class="row">
		<div class="col-md-12">

			<!-- START SIMPLE DATATABLE -->
			<div class="panel panel-default">
				<div class="panel-heading" style="text-align: center;">
					<h1 style="font-weight: bold; color: #335566;">Punjab Intra Route Optimization For PDS</h1>

				</div>
			</div>



			<div class="row">
				<div class="col-md-12">
					<div class="panel-body">

						<form action="" method="POST" class="form-horizontal" enctype="multipart/form-data" id="upload_button">
							
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<div class="col-md-2"></div>
											<div class="col-md-9">  
												<div class="input-group">
												<span class="input-group-addon"><span class="fa fa-info"></span></span>						
												<select class="form-control" id="type" name="type">
													<option value=''>Select</option>
													<option value='inter'>Inter</option>
													<option value='intra'>Intra</option>
												</select>
												</div>
												<span class="help-block">Selected Type</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<div class="col-md-2"></div>
											<div class="col-md-9">  
												<div class="input-group">
												<span class="input-group-addon"><span class="fa fa-calendar"></span></span>						
												<select class="form-control" id="year" name="year">
													<option value=''>Select</option>
													<option value='2024'>2024</option>
												</select>
												</div>
												<span class="help-block">Selected Year</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<div class="col-md-2"></div>
											<div class="col-md-9">
												<div class="input-group">
												<span class="input-group-addon"><span class="fa fa-calendar"></span></span>						
												<select class="form-control" id="month" name="month">
													<option value=''>Select</option>
													<option value='jan'>January</option>
													<option value='feb'>February</option>
													<option value='march'>March</option>
													<option value='april'>April</option>
													<option value='may'>May</option>
													<option value='june'>June</option>
													<option value='july'>July</option>
													<option value='aug'>August</option>
													<option value='sept'>September</option>
													<option value='oct'>October</option>
													<option value='nov'>November</option>
													<option value='dec'>December</option>
												</select>
												</div>
												<span class="help-block">Selected Month</span>
											</div>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<div class="col-md-2"></div>
											<div class="col-md-9">
												 <div class="multiselect">
													<div class="selectBox" onclick="showCheckboxes()">
													  <select class="form-control" >
														<option>Select an option</option>
													  </select>
													  <div class="overSelect"></div>
													</div>
													<div id="checkboxes"  style="z-index:999;background-color:#F9F9F9;position: absolute;width:100%;" >
														<label for="jan">
														&nbsp <input type="checkbox" id="jan" value="jan" style /> January</label>
														<label for="feb">
														&nbsp <input type="checkbox" id="feb" value="feb" /> February</label>
														<label for="march">
														&nbsp <input type="checkbox" id="march" value="march" /> March</label>
														<label for="april">
														&nbsp <input type="checkbox" id="april" value="april" /> April</label>
														<label for="may">
														&nbsp <input type="checkbox" id="may" value="may" /> May</label>
														<label for="june">
														&nbsp <input type="checkbox" id="june" value="june" /> June</label>
														<label for="july">
														&nbsp <input type="checkbox" id="july" value="july" /> July</label>
														<label for="aug">
														&nbsp <input type="checkbox" id="aug" value="aug" /> August</label>
														<label for="sept">
														&nbsp <input type="checkbox" id="sept" value="sept" /> September</label>
														<label for="oct">
														&nbsp <input type="checkbox" id="oct" value="oct" /> October</label>
														<label for="nov">
														&nbsp <input type="checkbox" id="nov" value="nov" /> November</label>
														<label for="dec">
														&nbsp <input type="checkbox" id="dec" value="dec" /> December</label>
													</div>
												  </div>
												<span class="help-block">Applicable Month</span>
											</div>
										</div>
									</div>
								</div>
							<!-- </div> -->
						</form>
						<div id="processingPopup">
							<div class="spinner"></div>
						</div>
						&nbsp
						<div class="row">
							<div
								style="font-size: 20px; font-weight: 700; margin-top: 0px; padding: 5px; margin-bottom: 20px;">
								<i class="fa fa-info-circle" aria-hidden="true"></i> Pre-Analysis
							</div>
							<div class="row">
								<div class="col-md-3 mb-4">
									<div class="card h-100"
										style="background-color:#56A5FF; color:white; padding:20px; font-weight: bold;">
										<div style="font-size:25px" id="total_warehouse">DEPOT </div>
										<div style="font-size:15px">Total Warehouse</div>
									</div>
								</div>
								<div class="col-md-3 mb-4">
									<div class="card h-100"
										style="background-color:#3FDBBC; color:white; padding:20px; font-weight: bold;">
										<div style="font-size:25px" id="total_supply"> Qt</div>
										<div style="font-size:15px">Total Capacity</div>
									</div>
								</div>
								<div class="col-md-3 mb-4">
									<div class="card h-100"
										style="background-color:#FFC167; color:white; padding:20px; font-weight: bold;">
										<div style="font-size:25px" id="total_fps">FPS </div>
										<div style="font-size:15px">Total FPS Counts</div>
									</div>
								</div>
								<div class="col-md-3 mb-4">
									<div class="card h-100"
										style="background-color:#F96981; color:white; padding:20px; font-weight: bold;">
										<div style="font-size:25px" id="total_demand">0 Qt</div>
										<div style="font-size:15px">Total FPS Demands</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					&nbsp
					</br></br></br>
					<center>
						<div style="width:80%"><canvas id="myChart" width="400" height="200"></canvas></div>
					</center>

				</div>
				<div class="col-md-12" id="sidebar" style="display:none; border-radius: 20px;">
					<div
						style="border: 2px solid #DC8686; padding: 15px; background-color: #DC8686; color: white; border-radius: 20px; margin-top:100px; margin-bottom: 10px;">
						<div class="card">
							<div class="row">
								<center style="margin-top:20px">
									<h2><b><span style="color: white">Progress Bar</span></b></h2>
								</center>
								<center style="margin-top:20px">
									<h2><b><span style="color: white;">File Upload Successfully</span></b></h2>
								</center>
								<center><img src="img\Analysis-icon-1.png" style="width:45%" /></center>
								<center style="margin-top:20px">
									<h2><b><span style="color: white;">Pre-Analysis</span></b></h2>
								</center>
								<center style="margin-top:20px">
									<h4><b><span style="color: white;">State-Wise &nbsp <input type="checkbox"
													id="statewiseCheckbox" onchange="handleStateCheckboxChange()" /></b>
									</h4>
								</center>
								<center style="margin-top: 20px; font-weight: 500; color: white;">
									<h4><b id="totalFciSupply"></b></h4>
								</center>


								<center style="margin-top:20px">
									<h4><b id="totalFciDemand"></b></h4>
								</center>
								<center style="margin-top:20px">
									<h4><b id="result"></b></h4>
								</center>
								<div id="districtcheckbox" style="display:none">
									<center style="margin-top:20px;">
										<h4><b><span style="color: white;">District-wise Supply and Demand &nbsp <input type="checkbox" id="districtwiseCheckbox" onchange="handleDistrictCheckboxChange()" /></b></h4>
									</center>
									<center style="margin-top:20px">
										<h4><b id="resultdistrict"></b></h4>
									</center>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			&nbsp
			</br></br></br>

			<div id="generateoptinizedplanbutton" style="display:none; overflow: hidden;">
				<div style="font-size: 20px; font-weight: 700; margin-top: 0px; padding: 5px; margin-bottom: 20px;">
					<i class="fa fa-info-circle" aria-hidden="true"></i> Optimization
				</div>
			
					<button class="upload_button_class" id="upload_button" name="submit">
						<span style="text-align: center; font-weight: bold;">Generate Optimized Plan</span>
						<a href="#" class="toggle toggle--off" data-content="Off" onclick="toggleState(this)"></a>
						<!-- <h3 style="display: inline-block; margin: 0;">Generate</h3> -->
					</button>
					<img id="level5Image" src="Backend/Level5.png" alt="Level5.png" style="width: 62vh; margin-left: 380px; padding: 58px; display: none;margin-bottom: -83px;">
					<div style="margin-top: 13px;margin-left: 1300px ;">
					<div class="pen-wrapper">
					<div class="button-wrapper">
					
					</div>

					</div>
					</div>
			

				
				

				<br><br>
				
				
					<table class="table" id="optimisedtable" style="display: none; width: 300vh; text-align: center;">
					
						<thead>
							<tr>
								<th>Scenario</th>
								<th>WH_Used</th>
								<th>FPS_Used</th>
								<th>Total_Allocation</th>
								<th>Total_QKM</th>
								<!-- <th>Total Cost</th>
								<th>Demand</th> -->
								<th>Average Distance</th>
								<!-- <th>quantity</th> -->
							</tr>
						</thead>
						<tbody id="table_body">
							<!-- Table body content -->
						</tbody>
					</table>
					
				
				
			</div>
			&nbsp;<br><br><br>

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
	function toggleState(element) {
		if (element.classList.contains('toggle--off')) {
			element.classList.remove('toggle--off');
			element.classList.add('toggle--on');
			element.setAttribute('data-content', 'On');
		} else {
			element.classList.remove('toggle--on');
			element.classList.add('toggle--off');
			element.setAttribute('data-content', 'Off');
		}
	}
	function post(params, file) {

		method = "post";
		path = file;

		var form = document.createElement("form");
		form.setAttribute("method", method);
		form.setAttribute("action", path);

		for (var key in params) {
			if (params.hasOwnProperty(key)) {
				var hiddenField = document.createElement("input");
				hiddenField.setAttribute("type", "hidden");
				hiddenField.setAttribute("name", key);
				hiddenField.setAttribute("value", params[key]);
				form.appendChild(hiddenField);
			}
		}

		document.body.appendChild(form);
		form.submit();
	}

	function edit_entry(temp_id) {
		post({ uid: temp_id }, "FPSEdit.php");
	}


	// Initial data for the chart
	var initialData = {
		labels: ['Amritsar', 'Jalandhar', 'Bathinda', 'Ludhiana', 'Fazilka'],
		datasets: [{
			label: 'Supply',
			backgroundColor: '#1640D6',
			data: [0, 0, 0, 0, 0]
		}, {
			label: 'Demand',
			backgroundColor: '#25E6A5',
			data: [0, 0, 0, 0, 0]
		}]
	};

	// Get the canvas element
	var ctx = document.getElementById('myChart').getContext('2d');

	// Create a bar chart with initial data
	var myChart = new Chart(ctx, {
		type: 'bar',
		data: initialData,
		options: {
			scales: {
				y: {
					beginAtZero: true
				}
			}
		}
	});
	
	function fetchFromDb(){
		document.getElementById("districtcheckbox").style.display = "none";
		document.getElementById("result").innerHTML = "";
		document.getElementById("totalFciDemand").innerHTML = "";
		document.getElementById("totalFciSupply").innerHTML = "";
		document.getElementById("districtwiseCheckbox").checked = false;
		document.getElementById("statewiseCheckbox").checked = false;
		document.getElementById("generateoptinizedplanbutton").style.display = "none";

		document.getElementById("processingPopup").style.display = "flex";
		document.getElementById("sidebar").style.display = "block";

		const formData = new FormData();

		fetch('http://localhost:5000/extract_db', {
			method: 'POST',
			body: formData
		})
			.then(response => response.json())
			.then(data => {
				const formData = new FormData();

				fetch('http://localhost:5000/getfcidata', {
					method: 'POST',
					body: formData
				})
					.then(response => response.json())
					.then(data => {
						console.log('Response from server:', data);
						document.getElementById("total_warehouse").innerHTML = "FCI " + data["Warehouse_No"];
						document.getElementById("total_demand").innerHTML = data["Total_Demand"] + " Qt";
						document.getElementById("total_fps").innerHTML = "FPS " + data["FPS_No"];
						document.getElementById("total_supply").innerHTML = data["Total_Supply"] + " Qt";
						document.getElementById("processingPopup").style.display = "none";
					})
					.catch(error => {
						console.error('Error:', error);
						document.getElementById("processingPopup").style.display = "none";
					});


			})
			.catch(error => {
				console.error('Error:', error);
				document.getElementById("processingPopup").style.display = "none";
			});
	}

	function uploadFile() {
		const fileInput = document.getElementById('fileInput');
		const file = fileInput.files[0];


		document.getElementById("districtcheckbox").style.display = "none";
		document.getElementById("result").innerHTML = "";
		document.getElementById("totalFciDemand").innerHTML = "";
		document.getElementById("totalFciSupply").innerHTML = "";
		document.getElementById("districtwiseCheckbox").checked = false;
		document.getElementById("statewiseCheckbox").checked = false;
		document.getElementById("generateoptinizedplanbutton").style.display = "none";

		if (!file) {
			alert('Please select a file.');
			return;
		}
		document.getElementById("processingPopup").style.display = "flex";
		document.getElementById("sidebar").style.display = "block";

		const formData = new FormData();
		formData.append('uploadFile', file);

		fetch('http://localhost:5000/uploadConfigExcel', {
			method: 'POST',
			body: formData
		})
			.then(response => response.json())
			.then(data => {
				const formData = new FormData();

				fetch('http://localhost:5000/getfcidata', {
					method: 'POST',
					body: formData
				})
					.then(response => response.json())
					.then(data => {
						console.log('Response from server:', data);
						document.getElementById("total_warehouse").innerHTML = "FCI " + data["Warehouse_No"];
						document.getElementById("total_demand").innerHTML = data["Total_Demand"] + " Qt";
						document.getElementById("total_fps").innerHTML = "FPS " + data["FPS_No"];
						document.getElementById("total_supply").innerHTML = data["Total_Supply"] + " Qt";
						document.getElementById("processingPopup").style.display = "none";
					})
					.catch(error => {
						console.error('Error:', error);
						document.getElementById("processingPopup").style.display = "none";
					});


			})
			.catch(error => {
				console.error('Error:', error);
				document.getElementById("processingPopup").style.display = "none";
			});

	}
	
	districtdata = [];
	function handleDistrictCheckboxChange() {
		var checkbox = document.getElementById("districtwiseCheckbox");
		if (checkbox.checked) {
			document.getElementById("generateoptinizedplanbutton").style.display = "";
			if (districtdata.length > 0) {
				document.getElementById("resultdistrict").innerHTML = "Intra scenario is not feasible in every district";
				document.getElementById("resultdistrict").style.color = "#ADFF2F"; 
			} else {
				document.getElementById("resultdistrict").innerHTML = "Intra scenario in every district is feasible";
				document.getElementById("resultdistrict").style.color = "#1111BB";
			}
			// Increase font size and make text bold
			document.getElementById("resultdistrict").style.fontSize = "18px";
			document.getElementById("resultdistrict").style.fontWeight = "bold";
		} else {
			document.getElementById("resultdistrict").innerHTML = "";
			document.getElementById("generateoptinizedplanbutton").style.display = "none";
		}
	}

	function generateoptimizedplan() {
		const formData = new FormData();
		formData.append('month', document.getElementById("month").value);
		formData.append('year', '2024');
		document.getElementById("processingPopup").style.display = "flex";
		fetch('http://localhost:5000/processFile', {
			method: 'POST',
			body: formData
		})
			.then(response => response.json())
			.then(data => {
				document.getElementById("optimisedtable").style.display = "";
				document.getElementById("processingPopup").style.display = "none";

				var table = document.getElementById("optimisedtable");
				var newRow = table.insertRow();

				var cell1 = newRow.insertCell(0);
				var cell2 = newRow.insertCell(1);
				var cell3 = newRow.insertCell(2);
				var cell4 = newRow.insertCell(3);
				var cell5 = newRow.insertCell(4);
				var cell6 = newRow.insertCell(5);
				

				cell1.innerHTML = data["Scenario"];
				cell2.innerHTML = data["WH_Used"];
				cell3.innerHTML = data["FPS_Used"];
				cell4.innerHTML = data["Demand"];
				cell5.innerHTML = data["Total_QKM"];
				cell6.innerHTML = data["Average_Distance"];
				
		table.style.width = "1000px";
        table.style.padding = "300px";
        table.style.marginBottom = "100px";
		table.style.fontSize = "20px"; 
		table.style.marginLeft = "200px"; // Add margin-left
		table.style.color = "black"; // Add margin-left
		table.style.textAlign = "center";

		var tableHeaders = table.getElementsByTagName('th');
        for (var i = 0; i < tableHeaders.length; i++) {
            tableHeaders[i].style.fontSize = "20px"; // Increase font size for headers
        }
		toggleImage(); // Call the toggleImage function after displaying the table
        var toggleButton = document.querySelector('.toggle');
        toggleButton.classList.remove('toggle--on');
        toggleButton.classList.add('toggle--off');
        toggleButton.setAttribute('data-content', 'Off');

        //toggleTableAndDownloadButton(); // Call the function to show/hide download button
    })
    .catch(error => {
        console.error('Error:', error);
    })
    .finally(() => {
        document.getElementById("processingPopup").style.display = "none";
    });
}


function toggleImage() {
    var img = document.getElementById('level5Image');
    img.style.display = (img.style.display === 'none' || img.style.display === '') ? 'block' : 'none';

    // Log the current display values for image and download button
    console.log('Image display:', img.style.display);
    var downloadButton = document.getElementById('downloadButtonText');
    if (downloadButton) {
        console.log('Download button display (before):', downloadButton.style.display);
        downloadButton.style.display = (img.style.display === 'block') ? 'inline-block' : 'none';
        console.log('Download button display (after):', downloadButton.style.display);
    }
}


function DownloadButton() {
    const downloadButton = document.getElementById('download_button');
    const table = document.getElementById('optimisedtable');

    if (table.innerHTML.trim() !== '') {
        downloadButton.style.display = '';
    } else {
        downloadButton.style.display = 'none';
    }
}

let workbook = null;

function readLocalExcelFile() {
    const filePath = 'Backend/Backend/SCO_Tagging_Sheet.xlsx';
    workbook = XLSX.readFile(filePath);
    DownloadButton(); // Call DownloadButton after reading the file
}

function downloadExcelFile() {
    if (!workbook) {
        console.error('Workbook not initialized.');
        return;
    }

    const wbout = XLSX.write(workbook, { bookType: 'xlsx', type: 'binary' });

    function s2ab(s) {
        const buf = new ArrayBuffer(s.length);
        const view = new Uint8Array(buf);
        for (let i = 0; i < s.length; i++) {
            view[i] = s.charCodeAt(i) & 0xFF;
        }
        return buf;
    }

    const blob = new Blob([s2ab(wbout)], { type: 'application/octet-stream' });
    const url = window.URL.createObjectURL(blob);

    const a = document.createElement('a');
    a.href = url;
    a.download = 'Template_SCO_IntraState_Punjab.xlsx';
    a.click();
    window.URL.revokeObjectURL(url);
}

function downloadFile(fileType) {
    let filePath = '';
    let fileName = '';

    if (fileType === 'xlsx') {
        filePath = 'template/Template_SCO_IntraState_Punjab.xlsx';
        fileName = 'Template_SCO_IntraState_Punjab.xlsx';
    } else if (fileType === 'pdf') {
        filePath = 'template/Template_SCO_IntraState_Punjab.pdf';
        fileName = 'Template_SCO_IntraState_Punjab.pdf';
    }

    fetch(filePath)
        .then(response => response.blob())
        .then(blob => {
            const url = window.URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = fileName;
            a.click();
            window.URL.revokeObjectURL(url);
        })
        .catch(error => {
            console.error('Error downloading file:', error);
        });
}


// function convertTableToCSV() {
//     const table = document.getElementById('optimisedtable');
//     let csv = [];
//     const rows = table.getElementsByTagName('tr');
//     for (let i = 0; i < rows.length; i++) {
//         const row = [], cols = rows[i].querySelectorAll('td, th');
//         for (let j = 0; j < cols.length; j++) {
//             row.push(cols[j].innerText);
//         }
//         csv.push(row.join(','));
//     }
//     return csv.join('\n');
// }

function toggleState(element) {
	if (element.classList.contains('toggle--off')) {
		element.classList.remove('toggle--off');
		element.classList.add('toggle--on');
		element.setAttribute('data-content', 'On');
		generateoptimizedplan();
	} else {
		element.classList.remove('toggle--on');
		element.classList.add('toggle--off');
		element.setAttribute('data-content', 'Off');
		var table = document.getElementById("optimisedtable");
		table.style.display = "none";
	}
}

function handleStateCheckboxChange() {
	var checkbox = document.getElementById("statewiseCheckbox");
	document.getElementById("districtwiseCheckbox").checked = false;

	if (checkbox.checked) {
		const formData = new FormData();
		document.getElementById("processingPopup").style.display = "flex";
		fetch('http://localhost:5000/getGraphData', {
			method: 'POST',
			body: formData
		})
			.then(response => response.json())
			.then(data => {
				console.log('Response from server:', data);
				var totalCapacity = Object.values(data.District_Capacity).reduce((acc, capacity) => acc + capacity, 0);
				var totalDemand = Object.values(data.District_Demand).reduce((acc, demand) => acc + demand, 0);

				document.getElementById("totalFciDemand").innerHTML = "<span style='color: white; font-size: 14px;'>" + "Total FCI Demand: " + totalDemand + "</span>";
				document.getElementById("totalFciSupply").innerHTML = "<span style='color: white; font-size: 14px;'>" + "Total FCI Supply: " + totalCapacity + "</span>";


				districtdata = data.District_Name;

				if (totalCapacity > 0 && totalDemand > 0) {
					if (totalCapacity >= totalDemand) {
						// document.getElementById("result").innerHTML = "Optimization can be done.";
						document.getElementById("result").innerHTML = "<span style='font-weight: bold; font-size: 20px; color: green;'>Optimization can be done.</span>";

						document.getElementById("districtcheckbox").style.display = "block";
					}
					else {
						// document.getElementById("result").innerHTML = "Optimiazation cannot be done infeasible solution";
						document.getElementById("result").innerHTML = "<span style='font-weight: bold; font-size: 20px; color: red;'>Optimiazation cannot be done infeasible solution.</span>";

						document.getElementById("districtcheckbox").style.display = "none";
						document.getElementById("generateoptinizedplanbutton").style.display = "none";
					}

					// Get district names from the JSON data
					var districtNames = Object.keys(data.District_Capacity);

					// Get capacities and demands for each district
					var capacities = districtNames.map(district => data.District_Capacity[district]);
					var demands = districtNames.map(district => data.District_Demand[district]);

					// Generate newData object
					var newData = {
						labels: districtNames,
						datasets: [
							{
								label: 'FRice Demand',
								backgroundColor: '#5383FF',
								data: demands
							},
							{
								label: 'Wheat Supply',
								backgroundColor: '#9085AE',
								data: capacities
							}
						]
					};


					// Update the chart with new data
					myChart.data = newData;
					myChart.update();
					document.getElementById("processingPopup").style.display = "none";
				}
				else {
					document.getElementById("result").innerHTML = "Optimization cannot be provided.";
					document.getElementById("result").style.color = "red";
					document.getElementById("districtcheckbox").style.display = "none";
					document.getElementById("processingPopup").style.display = "none";
					document.getElementById("generateoptinizedplanbutton").style.display = "none";
				}

			})
			.catch(error => {
				console.error('Error:', error);
				document.getElementById("processingPopup").style.display = "none";
			});

	} else {
		document.getElementById("result").innerHTML = "";
		document.getElementById("totalFciDemand").innerHTML = "";
		document.getElementById("totalFciSupply").innerHTML = "";
		document.getElementById("districtwiseCheckbox").checked = false;
		document.getElementById("districtcheckbox").style.display = "none";
		document.getElementById("processingPopup").style.display = "none";
		document.getElementById("generateoptinizedplanbutton").style.display = "none";
	}
}

var currentDate = new Date();
var currentMonth = currentDate.getMonth();
var currentYear = currentDate.getFullYear();
var monthNames = ['jan', 'feb', 'march', 'april', 'may', 'june', 'july', 'aug', 'sept', 'oct', 'nov', 'dec'];
var currentMonthValue = monthNames[currentMonth];

var dropdown = document.getElementById('month');
var removeIndices = [];
    
for (var i = 0; i < dropdown.options.length; i++) {
	if (dropdown.options[i].value === currentMonthValue) {
        dropdown.options[i].selected = true;
    }
	else{
		removeIndices.push(i);
	}
}


for (var j = removeIndices.length - 1; j >= 0; j--) {
    dropdown.remove(removeIndices[j]);
}

var dropdown = document.getElementById('year');

for (var i = 0; i < dropdown.options.length; i++) {
    if (dropdown.options[i].value == currentYear) {
        dropdown.options[i].selected = true;
        break;
    }
}

var dropdown = document.getElementById('type');
var currentType = "inter"

for (var i = 0; i < dropdown.options.length; i++) {
    if (dropdown.options[i].value === currentType) {
        dropdown.options[i].selected = true;
        break;
    }
}

var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}

function test(){
	console.log(document.getElementById("type").value);
	console.log(document.getElementById("month").value);
	console.log(document.getElementById("year").value);
	
	var checkboxes = document.querySelectorAll('#checkboxes input[type="checkbox"]');
    var selectedValues = [];

    checkboxes.forEach(function(checkbox) {
      if (checkbox.checked) {
        selectedValues.push(checkbox.value);
      }
    });
	
	
	console.log(selectedValues);
}
</script>
</body>

</html>