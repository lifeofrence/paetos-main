<?php
session_start(); // Resume session

// Check if user is logged in and session is active
if (!isset($_SESSION['user_id']) || !isset($_SESSION['timeout']) || $_SESSION['timeout'] < time()) {
    // Redirect to login page if not logged in or session expired
    header("Location: login.html");
    exit();
}

// Extend session timeout upon activity
$_SESSION['timeout'] = time() + 1800; // 30 minutes timeout extension

include 'php/fetch_user_details.php'; // Include the function file

// Fetch user details
$students_info = fetch_user_details();
$user_payments = fetch_user_payments();

// Determine button status
$button_text = "Book Room";
$button_link = "book-hostel.php";
$room_no= "You don’t have Room yet ";

if (!empty($user_payments)) {
    foreach ($user_payments as $payment) {
        if ($payment['status'] === 'assigned') {
            $button_text = "ROOM 503 bed 2";
			$room_no="Your Room Number is";
            $button_link = "#"; // Adjust this link as needed
            break;
        } elseif ($payment['status'] === 'confirmed') {
            $button_text = "Wait to be Assigned";
			$room_no= "You don’t have Room yet ";
            $button_link = "#"; // Adjust this link as needed
			
            break;
        }
         elseif ($payment['status'] === 'rejected') {
            $button_text = "Not Eligible";
			$room_no= "You don’t have Room yet ";
            $button_link = "#"; // Adjust this link as needed
            break;
        }
         elseif ($payment['status'] === 'Pending') {
            $button_text = "Wait to Verify";
			$room_no= "You don’t have Room yet ";
            $button_link = "#"; // Adjust this link as needed
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<!-- Meta -->
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">


	<!-- Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- PAGE TITLE HERE -->
	<title>Pa-etos Hostel Accommodation </title>

	<!-- Favicon icon -->
	<link rel="shortcut icon" type="image/png" href="images/paetoa.png">
	<link href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	<link class="main-css" href="css/style.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
	<!-- Globle CSS -->
	<link class="main-css" href="css/style.css" rel="stylesheet">

</head>

<body>

	<!--*******************
		Preloader start
	********************-->
	<div id="preloader">
		<div class="lds-ripple">
			<div></div>
			<div></div>
		</div>
	</div>
	<!--*******************
		Preloader end
	********************-->

	<!--**********************************
		Main wrapper start
	***********************************-->
	<div id="main-wrapper">

		<!--**********************************
			Nav header start
		***********************************-->
		<div class="nav-header">
			<a href="#" class="brand-logo">



				<img class="logo-abbr" src="images/paetoa.svg" width="134.01" height="48.365" viewBox="0 0 134.01 48.365">
				<g id="Group_38" data-name="Group 38" transform="translate(-133.99 -40.635)">


				</g>
				</svg>

			</a>
			<div class="nav-control">
				<div class="hamburger">
					<span class="line"></span><span class="line"></span><span class="line"></span>
				</div>
			</div>
		</div>
		<!--**********************************
			Nav header end
		***********************************-->

		<div class="header">
			<div class="header-content">
				<nav class="navbar navbar-expand">
					<div class="collapse navbar-collapse justify-content-between">
						<div class="header-left">
							<div class="dashboard_bar">
								<?php echo $students_info['firstName'] ?? 'Guest'; ?> Dashboard
							</div>

						</div>
						<ul class="navbar-nav header-right">

							<li class="nav-item dropdown notification_dropdown">
								<a class="nav-link bell dlab-theme-mode p-0" href="#;">
									<i id="icon-light" class="fas fa-sun"></i>
									<i id="icon-dark" class="fas fa-moon"></i>

								</a>
							</li>

							<li class="nav-item dropdown notification_dropdown">
								<a class="nav-link" href="#;" role="button" data-bs-toggle="dropdown">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
										<g data-name="Layer 2" transform="translate(-2 -2)">
											<path id="Path_20" data-name="Path 20" d="M22.571,15.8V13.066a8.5,8.5,0,0,0-7.714-8.455V2.857a.857.857,0,0,0-1.714,0V4.611a8.5,8.5,0,0,0-7.714,8.455V15.8A4.293,4.293,0,0,0,2,20a2.574,2.574,0,0,0,2.571,2.571H9.8a4.286,4.286,0,0,0,8.4,0h5.23A2.574,2.574,0,0,0,26,20,4.293,4.293,0,0,0,22.571,15.8ZM7.143,13.066a6.789,6.789,0,0,1,6.78-6.78h.154a6.789,6.789,0,0,1,6.78,6.78v2.649H7.143ZM14,24.286a2.567,2.567,0,0,1-2.413-1.714h4.827A2.567,2.567,0,0,1,14,24.286Zm9.429-3.429H4.571A.858.858,0,0,1,3.714,20a2.574,2.574,0,0,1,2.571-2.571H21.714A2.574,2.574,0,0,1,24.286,20a.858.858,0,0,1-.857.857Z" />
										</g>
									</svg>
									<span class="badge light text-white bg-primary rounded-circle">0</span>
								</a>

							</li>


							<li class="nav-item dropdown header-profile">
								<a class="nav-link" href="#;" role="button" data-bs-toggle="dropdown">
									<?php if (!empty($students_info['userImage'])) : ?>
										<img src="data:image/jpeg;base64,<?php echo base64_encode($students_info['userImage']); ?>" title="<?php echo $students_info['firstName'] ?? 'Guest'; ?> Image" alt="<?php echo $students_info['firstName'] ?? 'Guest'; ?> Image">
									<?php endif; ?>
								</a>
								<div class="dropdown-menu dropdown-menu-end">
									<a href="profile.php" class="dropdown-item ai-icon">
										<svg id="icon-user2" xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
											<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
											<circle cx="12" cy="7" r="4"></circle>
										</svg>
										<span class="ms-2">Profile </span>
									</a>

									<a href="php/logout.php" class="dropdown-item ai-icon">
										<svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
											<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
											<polyline points="16 17 21 12 16 7"></polyline>
											<line x1="21" y1="12" x2="9" y2="12"></line>
										</svg>
										<span class="ms-2">Logout </span>
									</a>
								</div>
							</li>
						</ul>
					</div>
				</nav>
			</div>
		</div>



		<!--**********************************
			Sidebar start
		***********************************-->
		<div class="dlabnav">
			<div class="dlabnav-scroll">
				<div class="dropdown header-profile2 ">
					<a class="nav-link " href="#;" role="button" data-bs-toggle="dropdown">
						<div class="header-info2 d-flex align-items-center">
							<!-- <img src="images/profile/pic1.jpg" alt=""> -->
							<?php if (!empty($students_info['userImage'])) : ?>
								<img src="data:image/jpeg;base64,<?php echo base64_encode($students_info['userImage']); ?>" title="<?php echo $students_info['firstName'] ?? 'Guest'; ?> Image" alt="<?php echo $students_info['firstName'] ?? 'Guest'; ?> Image">
							<?php endif; ?>
							<div class="d-flex align-items-center sidebar-info">
								<div>
									<span class="font-w400 d-block"><?php echo $students_info['firstName'] ?? 'Guest'; ?> <?php echo $students_info['middleName'] ?? 'Guest'; ?> <?php echo $students_info['lastName'] ?? 'Guest'; ?></span>
									<small class="text-end font-w400"><?php echo $students_info['email'] ?? 'Guest'; ?></small>
								</div>
								<i class="fas fa-chevron-down"></i>
							</div>

						</div>
					</a>
					<div class="dropdown-menu dropdown-menu-end">
						<a href="profile.php" class="dropdown-item ai-icon ">
							<svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
								<circle cx="12" cy="7" r="4"></circle>
							</svg>
							<span class="ms-2">Profile </span>
						</a>

						<a href="php/logout.php" class="dropdown-item ai-icon">
							<svg xmlns="http://www.w3.org/2000/svg" class="text-danger" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
								<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
								<polyline points="16 17 21 12 16 7"></polyline>
								<line x1="21" y1="12" x2="9" y2="12"></line>
							</svg>
							<span class="ms-2">Logout </span>
						</a>
					</div>
				</div>
				<ul class="metismenu" id="menu">
					<li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
							<i class="flaticon-025-dashboard"></i>
							<span class="nav-text">Dashboard</span>
						</a>
						<ul aria-expanded="false">
							<li><a href="book-hostel.php">Book Room</a></li>
							<li><a href="room_slip.php">Check Status</a></li>
							
                    
						</ul>

					</li>
					<li><a class="has-arrow " href="javascript:void()" aria-expanded="false">
							<i class="flaticon-093-waving"></i>
							<span class="nav-text">Complain</span>
						</a>
						<ul aria-expanded="false">
							<li><a href="#">Payment Issue</a></li>
							<li><a href="#">Repair Issues</a></li>

						</ul>
					</li>

				</ul>

			</div>
		</div>
		<!--**********************************
			Sidebar end
		***********************************-->

		<div class="content-body">
			<!-- row -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-6">
						<div class="row">

							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="row ">
											<div class="card">
												<div class="card-body text-center ai-icon  text-primary">
													<svg id="rocket-icon" class="my-2" viewBox="0 0 24 24" width="80" height="80" stroke="currentColor" stroke-width="1" fill="none" stroke-linecap="round" stroke-linejoin="round">
														<path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z">
														</path>
														<line x1="3" y1="6" x2="21" y2="6"></line>
														<!-- <path d="M16 10a4 4 0 0 1-8 0"></path> -->
													</svg>
													<!-- <h4 class="my-2">You don’t have Room yet</h4> -->
													<h4 class="my-2"><?php echo $room_no;  ?></h4>

													<a class="btn btn-danger dlabnav-buy" href=" <?php echo $button_link; ?>"><?php echo $button_text; ?></a>

												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-6">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<div class="row ">
											<div class="col-xl-8 col-xxl-7 col-sm-7">
												<div class="update-profile d-flex">
													<?php if (!empty($students_info['userImage'])) : ?>
														<img src="data:image/jpeg;base64,<?php echo base64_encode($students_info['userImage']); ?>" title="<?php echo $students_info['firstName'] ?? 'Guest'; ?> Image" alt="<?php echo $students_info['firstName'] ?? 'Guest'; ?> Image">
													<?php endif; ?>
													<div class="ms-4">
														<h3 class="mb-0">
															<?php echo $students_info['firstName'] ?? 'Guest'; ?>
															<?php echo $students_info['lastName'] ?? 'Guest'; ?></h3>
														<span class="text-primary d-block mb-xl-3 mb-1"><?php echo $students_info['regNo'] ?? 'Guest'; ?>
														</span>
														<span><i class="fas fa-map-marker-alt me-1"></i>No. 232 Alvan
															street Kuje</span>
													</div>
												</div>
											</div>
											<div class="col-xl-4 col-xxl-5 col-sm-5 sm-mt-auto mt-3 text-sm-end">
												<a href="edit-profile.php" class="btn btn-primary">Edit Profile</a>

											</div>
										</div>
										<div class="row mt-4 align-items-center">
											<div class="col-xl-6 col-sm-6">
												<h3 class="me-auto">Personal Contact</h3>
												<div>
													<a href="mailto:<?php echo $students_info['email'] ?? 'clintonfaze@outlook.com'; ?>" class="icon-btn me-3"> <i class="fas fa-envelope"></i></a>
													<a href="callto:+2348120212639;" class="icon-btn me-3"><i class="fas fa-phone-alt"></i></a>
													<a href="#;" class="icon-btn"><i class="fas fa-info"></i></a>
												</div>

											</div>


											<div class="col-xl-6 col-sm-6">

												<h3 class="me-auto">Emergency Contacts:</h3>
												<div>
													<a href="mailto:<?php echo $students_info['email'] ?? 'clintonfaze@outlook.com'; ?>" class="icon-btn me-3"> <i class="fas fa-envelope"></i></a>
													<a href="callto:+2348120212639;" class="icon-btn me-3"><i class="fas fa-phone-alt"></i></a>
													<a href="#;" class="icon-btn"><i class="fas fa-info"></i></a>
												</div>

											</div>


										</div>
										<div class="row mt-4 align-items-center">

											<h3 class="">Phone: <span><?php echo $students_info['contactNo']; ?></span></h3>
											<h3 class="">Email: <span><?php echo $students_info['email']; ?> </span></h3>
										</div>

									</div>
								</div>
							</div>

						</div>
					</div>

					<div class="col-xl-6">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">Payment Information</h5>
										<?php if (!empty($user_payments)) : ?>
											<ul class="list-group">
												<?php foreach ($user_payments as $payment) : ?>
													<li class="list-group-item">
														<strong>Status:</strong> <?php echo $payment['status']; ?><br>
														<strong>Bank Name:</strong> <?php echo $payment['bankName']; ?><br>
														<strong>Payer's Name:</strong> <?php echo $payment['payers_name']; ?><br>

													</li>
												<?php endforeach; ?>
											</ul>
										<?php else : ?>
											<p>No payments found.</p>
										<?php endif; ?>

									</div>
								</div>
							</div>

						</div>
					</div>
					<div class="col-xl-6">
						<div class="row">
							<div class="col-xl-12">
								<div class="card">
									<div class="card-body">
										<h5 class="card-title">Your Uploaded Receipt</h5>
										<?php if (!empty($user_payments)) : ?>
											<ul class="list-group">
												<?php foreach ($user_payments as $payment) : ?>
													<li class="list-group-item">

														<?php if ($payment['is_pdf']) : ?>

															<a class="btn btn-primary" href="data:application/pdf;base64,<?php echo base64_encode($payment['decoded_payment_info']); ?>" download="payment.pdf">Download PDF</a>
														<?php else : ?>

															<img src="data:image/jpeg;base64,<?php echo base64_encode($payment['decoded_payment_info']); ?>" alt="Payment Image" style="max-width: 100%; height: auto;">
														<?php endif; ?>
													</li>
												<?php endforeach; ?>
											</ul>
										<?php else : ?>
											<p>No payments found.</p>
										<?php endif; ?>
									</div>
								</div>
							</div>

						</div>
					</div>



				</div>

			</div>

		</div>

		<!--**********************************
			Content body end
		***********************************-->



		<!--**********************************
			Footer start
		***********************************-->
		<div class="footer">
			<div class="copyright">
				<p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">ClintonCode</a> 2024</p>
			</div>
		</div>



	</div>

	<!--**********************************
	Scripts
***********************************-->
	<!-- Required vendors -->
	<script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="vendor/bootstrap-datepicker-master/js/bootstrap-datepicker.min.js"></script>

	<!-- Apex Chart -->
	<script src="vendor/apexchart/apexchart.js"></script>
	<script src="vendor/chartjs/chart.bundle.min.js"></script>

	<!-- Chart piety plugin files -->
	<script src="vendor/peity/jquery.peity.min.js"></script>

	<!-- Dashboard 1 -->
	<script src="js/dashboard/dashboard-1.js"></script>

	<script src="vendor/owl-carousel/owl.carousel.js"></script>

	<script src="js/custom.min.js"></script>
	<script src="js/dlabnav-init.js"></script>
	<script src="js/demo.js"></script>
	<!-- <script src="js/styleSwitcher.js"></script> -->
	<script>
		jQuery(document).ready(function() {
			setTimeout(function() {
				dlabSettingsOptions.version = 'dark';
				new dlabSettings(dlabSettingsOptions);
			}, 1500)
		});

		function JobickCarousel() {
			/*  testimonial one function by = owl.carousel.js */
			jQuery('.front-view-slider').owlCarousel({
				loop: false,
				margin: 30,
				nav: false,
				autoplaySpeed: 3000,
				navSpeed: 3000,
				autoWidth: true,
				paginationSpeed: 3000,
				slideSpeed: 3000,
				smartSpeed: 3000,
				autoplay: false,
				animateOut: 'fadeOut',
				dots: false,
				navText: ['', ''],
				responsive: {
					0: {
						items: 1,

						margin: 10
					},

					480: {
						items: 1
					},

					767: {
						items: 3
					},
					1750: {
						items: 3
					}
				}
			})
		}
		jQuery(window).on('load', function() {
			setTimeout(function() {
				JobickCarousel();
			}, 1000);
		});
	</script>

<script>
        // Function to fetch the button status
        function fetchButtonStatus() {
            $.ajax({
                url: 'button_status.php', // Your PHP script URL
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    console.log('Button status fetched:', response); // Debugging line
                    $('#dynamic-button').text(response.button_text);
                    $('#dynamic-button').attr('href', response.button_link);
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching button status:', error); // Debugging line
                }
            });
        }

        // Function to start periodic checking
        function startPeriodicCheck() {
            fetchButtonStatus(); // Fetch immediately on load
            setInterval(fetchButtonStatus, 10000); // Fetch every 10 seconds
        }

        // Start periodic check when document is ready
        $(document).ready(function() {
            startPeriodicCheck();
        });
    </script>
</body>


</html>