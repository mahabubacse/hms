<?php
	session_start();
	//error_reporting(0);
	include('include/config.php');
	include('include/checklogin.php');
	include('include/sms_sender_api.php');
	check_login();
	
	if(isset($_POST['submit']))
	{
		$bloodGroup=$_POST['bloodGroup'];
		$location=$_POST['location'];
		$userid=$_SESSION['id'];
		
		$need_date=$_POST['need_date'];
		$need_time=$_POST['need_time'];
		$userstatus=1;
		$docstatus=1;
		
		
		$result = mysqli_query($con, "SELECT * FROM `users` WHERE `id`='$userid'");
		
		if (mysqli_num_rows($result) > 0) {
			
			while($row = mysqli_fetch_assoc($result)) {
				$patientName =  $row["fullName"];
				$mobileNo =  $row["mobileNo"];
			}
		} else {
				$patientName =  null;
				$mobileNo =  null;
		}
		
		
		// $result = mysqli_query($con, "SELECT * FROM `doctors` WHERE `id`='$doctorid'");
		
		// if (mysqli_num_rows($result) > 0) {
			
			// while($row = mysqli_fetch_assoc($result)) {
				// $doctorName =  $row["doctorName"];
				
			// }
		// } else {
				// $doctorName =  null;
				
		// }
		
		
		
		
		
		
		$sql = "INSERT INTO `blood_bank` (`id`,`blood_group`, `patient_name`, `location`, `patient_mobile`, `need_time`, `need_date`, `patient_id`) VALUES (NULL,'$bloodGroup','$patientName', '$location', '$mobileNo', '$need_time', '$need_date', '$userid')";
		
		$query=mysqli_query($con,$sql);
		if($query)
		{
			//$msg = "Dear $patientName You have an appointment at Khan Hospital with Dr $doctorName on $appdate at $time .Please Call us at 01753563877 for reschedule.";
			//sendSms($mobileNo,$msg);
			echo "<script>alert('Your Request successfully posted');</script>";
			header('location:blood-request-history.php');
		}
		
	}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<title>User  | Book Appointment</title>
		
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet" media="screen">
		<link href="vendor/select2/select2.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-datepicker/bootstrap-datepicker3.standalone.min.css" rel="stylesheet" media="screen">
		<link href="vendor/bootstrap-timepicker/bootstrap-timepicker.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
		<script>
			function getdoctor(val) {
				$.ajax({
					type: "POST",
					url: "get_doctor.php",
					data:'specilizationid='+val,
					success: function(data){
						$("#doctor").html(data);
					}
				});
			}
		</script>	
		
		
		<script>
			function getfee(val) {
				$.ajax({
					type: "POST",
					url: "get_doctor.php",
					data:'doctor='+val,
					success: function(data){
						$("#fees").html(data);
					}
				});
			}
		</script>	
		
		
		
		
	</head>
	<body>
		<div id="app">		
			<?php include('include/sidebar.php');?>
			<div class="app-content">
				
				<?php include('include/header.php');?>
				
				<!-- end: TOP NAVBAR -->
				<div class="main-content" >
					<div class="wrap-content container" id="container">
						<!-- start: PAGE TITLE -->
						<section id="page-title">
							<div class="row">
								<div class="col-sm-8">
									<h1 class="mainTitle">User | Blood Request</h1>
								</div>
								<ol class="breadcrumb">
									<li>
										<span>User</span>
									</li>
									<li class="active">
										<span>Blood Request</span>
									</li>
								</ol>
							</section>
							<!-- end: PAGE TITLE -->
							<!-- start: BASIC EXAMPLE -->
							<div class="container-fluid container-fullw bg-white">
								<div class="row">
									<div class="col-md-12">
										
										<div class="row margin-top-30">
											<div class="col-lg-8 col-md-12">
												<div class="panel panel-white">
													<div class="panel-heading">
														<h5 class="panel-title">Blood Request</h5>
													</div>
													<div class="panel-body">
														<p style="color:red;"><?php echo htmlentities($_SESSION['msg1']);?>
														<?php echo htmlentities($_SESSION['msg1']="");?></p>	
														<form role="form" name="book" method="post" >
															
															
															
															<div class="form-group">
																<label for="DoctorSpecialization">
																	Blood Group
																</label>
																<select name="bloodGroup" class="form-control" required="required">
																	<option value="">Select Group</option>
																	<option value="A+">A+</option>
																	<option value="A-">A-</option>
																	<option value="B+">B+</option>
																	<option value="B-">B-</option>
																	<option value="O+">A-</option>
																	<option value="O-">O-</option>
																	<option value="AB+">AB+</option>
																	<option value="AB-">AB-</option>
																	
																	
																	
																	
																</select>
															</div>
															

															
															
															<div class="form-group">
																<label for="consultancyfees">
																	Location
																</label>
																<input name="location" type="text" class="form-control"  required>
																	
																</select>
															</div>
															
															
														
															
															<div class="form-group">
																<label for="AppointmentDate">
																	Date
																</label>
																<input class="form-control datepicker" name="need_date"  required="required" data-date-format="yyyy-mm-dd">
																
															</div>
															
															<div class="form-group">
																<label for="Appointmenttime">
																	
																	Time
																	
																</label>
																<input class="form-control" name="need_time" id="timepicker1" required="required">eg : 10:00 PM
															</div>														
															
															<button type="submit" name="submit" class="btn btn-o btn-primary">
																Submit
															</button>
														</form>
													</div>
												</div>
											</div>
											
										</div>
									</div>
									
								</div>
							</div>
							
							<!-- end: BASIC EXAMPLE -->
							
							
							
							
							
							
							<!-- end: SELECT BOXES -->
							
						</div>
					</div>
				</div>
				<!-- start: FOOTER -->
				<?php include('include/footer.php');?>
				<!-- end: FOOTER -->
				
				<!-- start: SETTINGS -->
				<?php include('include/setting.php');?>
				
				<!-- end: SETTINGS -->
			</div>
			<!-- start: MAIN JAVASCRIPTS -->
			<script src="vendor/jquery/jquery.min.js"></script>
			<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
			<script src="vendor/modernizr/modernizr.js"></script>
			<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
			<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
			<script src="vendor/switchery/switchery.min.js"></script>
			<!-- end: MAIN JAVASCRIPTS -->
			<!-- start: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
			<script src="vendor/maskedinput/jquery.maskedinput.min.js"></script>
			<script src="vendor/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js"></script>
			<script src="vendor/autosize/autosize.min.js"></script>
			<script src="vendor/selectFx/classie.js"></script>
			<script src="vendor/selectFx/selectFx.js"></script>
			<script src="vendor/select2/select2.min.js"></script>
			<script src="vendor/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
			<script src="vendor/bootstrap-timepicker/bootstrap-timepicker.min.js"></script>
			<!-- end: JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY -->
			<!-- start: CLIP-TWO JAVASCRIPTS -->
			<script src="assets/js/main.js"></script>
			<!-- start: JavaScript Event Handlers for this page -->
			<script src="assets/js/form-elements.js"></script>
			<script>
				jQuery(document).ready(function() {
					Main.init();
					FormElements.init();
				});
				
				$('.datepicker').datepicker({
					format: 'yyyy-mm-dd',
					startDate: '-3d'
				});
			</script>
			<script type="text/javascript">
				$('#timepicker1').timepicker();
			</script>
			<!-- end: JavaScript Event Handlers for this page -->
			<!-- end: CLIP-TWO JAVASCRIPTS -->
			
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.0/jquery.min.js"></script>
			
		</body>
	</html>
