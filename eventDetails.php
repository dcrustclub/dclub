<?php

	//Add a delete button to delete events which would be shown only to the user who created it  
	require_once 'pdo.php';
	session_start();
	//Checking that user has visited after logging in
	if(!isset($_SESSION['name'])){
		$_SESSION['error'] = "Please <a href='#' class='alert-link' data-toggle='modal' data-target='#loginModal' data-dismiss='modal'> Login first</a>";
		header('Location: index.php');
		return;
	}

	//Checking whether the user has completed his/her profile or not
	
	$sql_check_full_register = "Select * from fullregister where register_id=:id";
	$stmt_check_full_register = $pdo->prepare($sql_check_full_register);
	$stmt_check_full_register->execute(array(
		':id'=> $_SESSION['login_register_id']
	));
	
	$row_check_full_register = $stmt_check_full_register->fetch(PDO::FETCH_ASSOC);

	if(!$row_check_full_register){
		$_SESSION['full_register_register_id'] = $_SESSION['login_register_id'];
		$_SESSION['full_register_error_message'] = "Please complete your registration first <i class='fas fa-hand-point-down'></i>";
		header('Location:fullRegister.php');
		return;	
	}

	if(isset($_GET['e_id'])){
	
		$sql_get_event_details = "Select * from events where event_id=:e_id";
		$stmt_get_event_details = $pdo->prepare($sql_get_event_details);
		$stmt_get_event_details->execute(array(
			':e_id'=>$_GET['e_id']
		));
		$row_get_event_details = $stmt_get_event_details->fetch(PDO::FETCH_ASSOC);
		//Now, getting the user details
		$sql_get_organiser_details = 'SELECT * from register where register_id = :r_id';
		$stmt_get_organiser_details = $pdo->prepare($sql_get_organiser_details);
		$stmt_get_organiser_details->execute(array(
			':r_id' => $row_get_event_details['user_register_id']
		));
		$row_get_organiser_details = $stmt_get_organiser_details->fetch(PDO::FETCH_ASSOC);

		$sql_get_organiser_pno = "Select * from fullregister where register_id=:r_id";
		$stmt_get_organiser_pno = $pdo->prepare($sql_get_organiser_pno);
		$stmt_get_organiser_pno->execute(array(
			':r_id'=>$row_get_event_details['user_register_id']
		));
		$row_get_organiser_pno = $stmt_get_organiser_pno->fetch(PDO::FETCH_ASSOC);
		//Now, getting a date and time
		$dt = new DateTime($row_get_event_details['v_date_time']);
		$e_date = $dt->format('d-m-y');
		$e_time = $dt->format('h:i:s');


		
	}
	else{
		$_SESSION['error_events'] = "Please click on the detail button of the event whose details you want to view";
		header('Location: events.php');
		return;
	}
	

?>

<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Events | Dcrust Club | Register for events in and around Dcrust</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- Custom style sheet -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="img/title_image.png">


</head>
<body>

	<nav class="navbar navbar-expand navbar-dark bg-dark sticky-top">
		<a class="navbar-brand ml-3" href="#"><i class="fab fa-dyalog"></i> <i class="fab fa-cuttlefish"></i></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
			  <li>
			  	<div class="btn-group text-white">
				  <button class="btn btn-outline-success text-white" onclick="location.href='dashboard.php';">
				  	Welcome <?php echo $_SESSION['name']; ?>,
				  </button>
				  <button class="btn btn-success dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				    <span class="sr-only">Menu </span>
				  </button>
				  <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
				    <a class="dropdown-item" href="dashboard.php"><i class="fas fa-home"></i> Dashboard</a>
				    <a class="dropdown-item" href="events.php"><i class="fas fa-list-ul"></i> Events</a>
				    <a class="dropdown-item" href="settings.php"><i class="fas fa-cogs"></i> Settings</a>
				    <hr>
				    <a class="dropdown-item" href="organiseEvent.php"><i class="fas fa-plus-square"></i> Host Event</a>
				    
				    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
				  </div>
				</div>

			  </li>


			</ul>
		</div>
	</nav>

	<!-- Now, dealing with the body -->

	<div class="container">

		<div class="row">
			<!-- User requested details -->
			<div class="col-12 col-md-8 mt-4">
				<h4>Event Details <i class='fas fa-hand-point-down'></i></h4>
				<hr>
				<div class="card">
					<div class="card-body">
						<h6 class="display-4"><?php echo $row_get_event_details['name']; ?></h6>
						<p class="lead"> 
							<?php echo "Organised by ".$row_get_organiser_details['name']." of ".$row_get_event_details['organising_group']; ?> 
						</p>
						<p class="row">
							<span class='col-2'>
							Description: 
							</span>
							<span class=" col-10">
							<?php echo $row_get_event_details['description']; ?>
							</span>
						</p>
						<p class="row">
							<span class="col-2">
								Venue:
							</span>
							<span class="col-10">
								Place: <span class="h6"><?php echo $row_get_event_details['v_place']; ?></span><br>
								Date: <span class="h6"><?php echo $e_date; ?></span><br/>
								Time: <span class="h6"><?php echo $e_time; ?></span>
							</span>
						</p>
						<p class="row">
							<span class="col-5 col-md-2">
								Organiser Details:
							</span>
							<span class="col-7 col-md-7">
								Name: <span class="h6"><?php echo $row_get_organiser_details['name']; ?></span><br/>
								Phone no. : <span class="h6"><?php echo $row_get_organiser_pno['pno']; ?></span>
							</span>
						</p>
						<p class="row">
							<span class="col-3 col-md-2">
								Your Actions: 	
							</span>
							<span class="col-7 col-md-9">
								<a class='btn btn-primary ' href="#">Enroll</a>
								<a class='btn btn-danger' href="#" data-toggle="tooltip" data-html="true" title="If you find the event absurd<br> And think that it's done for fun <strong>by some unwanted elements</strong>" data-placement="top">Report <i class="fas fa-question"></i></a>
							</span>


						</p>
					</div>
				</div>
			</div>
			<!-- Advertisement content -->
			<div class="col-12 col-md-4 mt-4">
            <h5>Featured Events</h5>
            <hr>
            <div class="card">
              
              <div class="card-header">
                {Event Name}
              </div>
              <div class="body p-4">
                {Event Details}
                <div>
                  <a href="#" class="btn btn-outline-primary btn-sm">Go to Events</a>
                </div>
              </div>
              
            </div>
          </div>




		</div>


	</div>




	<!-- Now, dealing with the footer -->

  <footer class="container-fluid bg-secondary text-white mt-4">
    <div class="container ">
      <div class="row">
        <!-- Some important content here -->
        <div class="col-5 mt-3">
          <h6><i class="fas fa-external-link-alt"></i> Links: </h6>
          <hr>
          <ul class="list-unstyled">
            <li><a href="organiseEvents.php" class="text-white" data-toggle="tooltip" data-html="true" title="Host an Event in Dcrust or Around" data-placement="right"><i class="fas fa-plus-square"></i> Event</a></li>
            <li><a href="aboutus.php" class="text-white" data-toggle="tooltip" data-html="true" title="Know about us more" data-placement="right"><i class="fas fa-info"></i> About us</a></li>
            <li><a href="help.php" class="text-white" data-toggle="tooltip" data-html="true" title="Struck somewhere? Click here <i class='fas fa-hand-point-left'></i>" data-placement="right" ><i class="fas fa-question"></i> Help</a></li>
            <li><a href="careers.php" class="text-white" data-toggle="tooltip" data-html="true" title="Click if you want to contribute to the project!" data-placement="right"  ><i class="fas fa-briefcase"></i> Careers</a></li>
          </ul>
        </div>
        <div class="col-5 mt-3 offset-1">
          <h6>Social Links</h6>
          <hr>
          <a href="#" class="text-white" target="_blank" data-toggle="tooltip" data-html="true" title="Connect on Facebook" data-placement="bottom" ><i class="col-12 col-sm-2 fab fa-facebook-f"></i></a>
          <a href="#" class="text-white" target="_blank" data-toggle="tooltip" data-html="true" title="Connect on Twitter" data-placement="bottom"  ><i class="col-12 col-sm-2 fab fa-twitter"></i></a>
          <a href="mailto:dcrust.club@outlook.com" class="text-white" target="_blank" data-toggle="tooltip" data-html="true" title="Connect through mail" data-placement="bottom"  ><i class="col-12 col-sm-2 fas fa-envelope-open"></i></a>
          <a href="#" class="text-white" target="_blank" data-toggle="tooltip" data-html="true" title="Connect on Instagram" data-placement="bottom" ><i class="col-12 col-sm-2 fab fa-instagram"></i></a>
        </div>

      </div>
      <hr>
      <div class="row justify-content-center">
          &copy; Dcrust Club | 2018
      </div>
      <div class="row justify-content-end mt-2">
          <button class="col-auto text-white btn btn-danger" onclick="location.href='mailto:dcrust.club@outlook.com'">Report a problem <i class="fas fa-bug"></i> </button>
        </div>
    </div>

  </footer>





	    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $('.dropdown-toggle').dropdown();
            
        });
    </script>



</body>
</html>