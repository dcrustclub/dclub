<?php  
  //to do's
  // Add coursera like checkbox to the page using jquery so that, it will be enabled only when the checkbox is selected

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

  if(isset($_POST['eventDetails'])){
    date_default_timezone_set('Asia/Kolkata');
    $date = Date('Y-m-d');
    $time = Date('H:i:s');
    $sql_add_event = "Insert into events(name, organising_group, user_register_id, description, v_place, v_date_time, date_time, reports) values (:nm, :o_grp, :u_r_id, :des, :v_p, :v_d_t, :d_t, :rep)";
    $stmt_add_event = $pdo->prepare($sql_add_event);
    $stmt_add_event->execute(array(
      ':nm'=>$_POST['eventname'],
      ':o_grp'=>$_POST['org'],
      ':u_r_id'=>$_SESSION['login_register_id'],
      ':des'=>$_POST['des'],
      ':v_p'=>$_POST['venue'],
      ':d_t' => $date." ".$time,
      ':v_d_t'=>$_POST['edate']." ".$_POST['etime'],
      ':rep'=>0
    ));    

    $_SESSION['organiseSuccessMessage'] = "Congrats, your event is live now!!!";


  }


  	
?>


<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Organise Events | Dcrust Club | Register for events in and around Dcrust</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- Custom style sheet -->
    <link rel="stylesheet" href="css/styles.css">
    <link rel="icon" type="image/png" href="img/title_image.png">
    <!-- Using Parsely's CSS -->
    <link rel="stylesheet" href = "css/parsleys.css">


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
				    <a class="dropdown-item" href="settings"><i class="fas fa-cogs"></i> Settings</a>
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
    <!-- Row for any sort of message -->
    <div class="row">
      <div class="col=12">
        <?php  

          if(isset($_SESSION['organiseSuccessMessage'])){
            echo "<div class='alert alert-success mt-4'>";
            echo $_SESSION['organiseSuccessMessage'];
            echo "</div>";
            unset($_SESSION['organiseSuccessMessage']);
          }
          if(isset($_SESSION['error'])){
            echo "<div class='alert alert-danger mt-4'>";
            echo $_SESSION['error'];
            echo "</div>";
            unset($_SESSION['error']);
          }


        ?>
      </div>
    </div>
    <!-- Row for oganise form -->
    <div class="row">
      <div class="col-12 mt-4">
        <h4>Organise Events</h4>
        <hr/>
        <center>
          <h6 class='mb-4'>Please fill the form below:</h6>
        </center>
        <form method = "post" id="eventRegisterForm" data-parsley-length="[5, 100]">
          <div class="row">
            <div class="form-group col-12 col-md-5 mt-2">
              <label class="h6" for="eventname">Event Name</label>
              <input class="form-control" type="text" id="eventname" name="eventname" >
            </div>
          
            <div class="form-group col-md-5 offset-md-1 mt-2">
              <label class="h6" for="org">Organising Committee</label>
              <select class="custom-select" name="org" id="org">
                <option selected>--Select organising Group--</option>
                <option value="lisoc">Lisoc</option>
                <option value="ska">SKA</option>
                <option value="stepstormzz">StepStormzz</option>
                <option value="thinkbots">ThinkBots</option>
                <option value="code-it">Code-it</option>
              </select>
            </div>
            
            <div class="form-group col-12 col-md-5 mt-2">
              <label class="h6" for="venue">Venue</label>
              <input class="form-control" type="text" id="venue" name="venue" placeholder="Venue here..." data-parsley-length="[5, 100]">
              <small class="form-text text-muted">Enter value as: Room no. 216, MV Block </small>
            </div>

            <div class="form-group col-5 col-md-3 mt-2 offset-md-1">
              <label class="h6" for="edate">Date</label>
              <input class="form-control" type="date" id="edate" name="edate" >
              <small class="form-text text-muted">Enter value as: YYYY-MM-DD</small>
            </div>

            <div class="form-group col-5 col-md-2 mt-2">
              <label class="h6" for="etime">Time</label>
              <input class="form-control" type="time" id="etime" name="etime" >
              <small class="form-text text-muted">Enter value as: HH:MM AM/PM</small>
            </div>
          
            <div class="form-group col-12  col-sm-7 mt-2">
              <label for="des" class="h6">Description</label>
              <textarea class="form-control" rows=5 id="des" name="des"></textarea>            
            </div>

            <div class="form-check col-12 col-sm-10 m-2">
              <input type="checkbox" value="agree" id="agree" class="form-check-input">
              <label for="agree">I agree to <a href="#">event posting terms and conditions</a> and understand posting fraud events will result in blocking of my account</label>
            </div>

            <div class="form-group col-12 col-sm-3 mt-2">
              <button type="submit" class="btn btn-success btn-block" name="eventDetails">Post Event</button>
            </div>
            <div class="form-group col-6 col-sm-3 mt-2">
              <a class="btn btn-outline-danger" href="dashboard.php">Cancel</a>
            </div>
         
          </div>

        </form>
      </div>

      <!-- this should be shown as the msg on the dashboard when the user submits the event -->
      <div class="col-12">
        <div class="alert alert-success" role="alert">
          We are proud of you, for your devotion to the community by posting events to make the community better
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
    <!--Form validation JS -->
    <script type="text/javascript" src="./scripts/parsleys.js"></script>
    
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $('.dropdown-toggle').dropdown();
            $('#eventRegisterForm').parsley();
            

        });
    </script>



</body>
</html>