<?php  
	//To do's
	//Add jquery code so that the report field will be updated automatically when the user reports
	 

	require_once "pdo.php";
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
          <div class="col-12 mt-4 col-md-7">
            <h4>Events Available <i class="fas fa-hand-point-down"></i></h4>
            <hr/>
            <?php  
            	//Getting the events details form events 
            	$sql_get_event_detail = "SELECT * from events order by name";
            	$stmt_get_event_detail = $pdo->prepare($sql_get_event_detail);
            	$stmt_get_event_detail->execute();
            	$row_get_event_detail = $stmt_get_event_detail->fetch(PDO::FETCH_ASSOC);
            	if (!$row_get_event_detail){
            		echo "<div class='lead mt-4' style='height: 50vh;'>Well, no events for now!! Check sometime later</div>";	
            	}
            	else{
            		//Getting the organiser details
            		$sql_get_organiser_detail = "SELECT * from register where register_id=:r_id";
            		$stmt_get_organiser_detail= $pdo->prepare($sql_get_organiser_detail);
            		$stmt_get_organiser_detail->execute(array(
            			':r_id'=>$row_get_event_detail['user_register_id']
            		));
            		$row_get_organiser_detail = $stmt_get_organiser_detail->fetch(PDO::FETCH_ASSOC);

            		//Now, browse through the events available to us

            		while($row_get_event_detail = $stmt_get_event_detail->fetch(PDO::FETCH_ASSOC)){
            			echo "<div class='card'>";
            			echo "<div class='card-body'>";
            			echo "<h4 class='card-title'>".$row_get_event_detail['name']."</h4>";
            			echo "<p class='card-text'>";
            			echo "Organised by ".$row_get_organiser_detail['name']." of ".$row_get_event_detail['organising_group'];
            			echo "</p>";
            			echo "<div class='btn-group'>";
            			echo "<a href='#' class='btn btn-success'>Enroll</a> ";
            			echo "<a href='#' class='btn btn-outline-primary'>Details</a>";
            			echo "</div>";
            			echo "</div>";
            			echo "</div>";
            		}
            	}

            ?>


          </div>
          <div class="col-12 offset-md-1 col-md-4 mt-4">
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