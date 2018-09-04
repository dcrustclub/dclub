
<?php

//Also keep a record how many times a person is redirected before he/she registered himself/herself fully
//take care of the form, it's not proper i.e. the courses etc.

	require_once 'pdo.php';
	session_start();
	
	if(!isset($_SESSION['login_register_id'])){
		$_SESSION['error'] = "You are not supposed to visit that page until directed!!";
		unset($_SESSION['message']);
		header('Location: index.php');
		return;
	}

	

?>


<!DOCTYPE html>
<html>
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Complete your registeration first | Dcrust Club</title>

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
				    <a class="dropdown-item" href="#"><i class="fas fa-home"></i> Dashboard</a>
				    <a class="dropdown-item" href="#"><i class="fas fa-list-ul"></i> Events</a>
				    <a class="dropdown-item" href="#"><i class="fas fa-cogs"></i> Settings</a>
				    <hr>
				    <a class="dropdown-item" href="organiseEvent.php"><i class="fas fa-plus-square"></i> Host Event</a>
				    
				    <a class="dropdown-item" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
				  </div>
				</div>

			  </li>
			</ul>
		</div>
	</nav>

	<!--Now, comes the body content -->
	<div class="container">

		<!-- Printing the message -->
	    <?php  
			if(isset($_SESSION['full_register_error_message'])){
			  echo "<div class='alert alert-danger mt-4'>";
			  echo $_SESSION['full_register_error_message'];
			  echo "</div>";
			  unset($_SESSION['full_register_error_message']);
			}
			
	    ?>

	    <div class="row">
	    	<div class="col-12 mt-4 h4">
	    		Registration Form
	    		<hr />
	    	</div>

	    	<!-- Now, the column for the form -->
	    	<div class="col-12 mt-3">
	    		<form method = "post" action="fullRegisterSave.php">
	    			<div class="row">
		    			<div class="form-group col-12 col-sm-5 mt-2">
		    				<label for="fullname" class="h6" >Complete Name</label>
		    				<input type="text" id="fullname" name="fullname" class="form-control" placeholder="Full Name Here" required>
		    			</div>
		    			<div class="form-group col-12 col-sm-5 offset-sm-1 mt-2">
		    				<label for="branch" class="h6">Branch</label>
		    				<select class="custom-select" id="branch" name="branch" >
		    					<option selected>--Select Course--</option>
		    					<option value="B.Tech">ECE</option>
								<option value="B.Arch">CSE</option>
								<option value="M.Tech">CHE</option>
								<option value="B.Sc">CE</option>
		    				</select>
		    			</div>
		    			<div class="form-group col-12 col-sm-5 mt-2">
		    				<label for="rollno" class="h6">Roll No</label>
		    				<input type="number" name="rollno" id="rollno" class="form-control" placeholder="Roll no here" required>
		    			</div>

						<div class="form-group col-12 col-sm-5 mt-2 offset-sm-1">
		    				<label for="sem" class="h6">Semester</label>
		    				<select class="custom-select" name="sem" id="sem">
		    					<option selected>--Select your Semester--</option>
		    					<option value="1">1st</option>
								<option value="2">2nd</option>
								<option value="3">3rd</option>
								<option value="4">4th</option>
								<option value="5">5th</option>
								<option value="6">6th</option>
								<option value="7">7th</option>
								<option value="8">8th</option>
								<option value="9">9th</option>
								<option value="10">10th</option>
		    				</select>
		    			</div>

		    			<div class="form-group col-12 col-sm-5 mt-2">
		    				<label for="dob" class="h6">Date of Birth</label>
		    				<input type="date" name="dob" id="dob" placeholder="YYYY-MM-DD" class="form-control" required>
		    			</div>

		    			<div class="form-group col-12 col-sm-5 mt-2 offset-sm-1">
		    				<label for="sex" class="h6">Gender</label>
		    				<select class="custom-select" name="sex" id="sex" >
		    					<option selected>--Select Your Gender--</option>
		    					<option value="M">Male</option>
		    					<option value="F">Female</option>
		    				</select>
		    			</div>
		    		
		    			<div class="form-group col-12 mt-2">
		    				<label class="h6" for="wpno">What's app No.</label>
		    				<input type="number" class="col-12 col-sm-5 form-control" id="wpno" name="wpno" placeholder="What's app no here" required>
		    				<small id="wpno_info" class=" col-12 col-sm-5 from-text text-muted">Enter Phone no. if not on whats app</small>
		    			</div>

		    			<div class="form-group form-inline col-12">
		    				<label for="sqno" class="h6 mt-2 col-12 col-sm-3 justify-content-start" >Security Question &nbsp; <a data-toggle="tooltip" data-html="true" title="This will be used if you forget your password.<br>So, <strong>Please select it carefully!!</strong>" data-placement="right"> <i class="fas fa-question-circle"></i></a></label>
		    				<select id="sqno" name="sqno" class="custom-select col-12 col-sm-7 offset-sm-1 mt-2 ">
		    					<option selected> -- Select Security Question -- </option>
		    					<option value="What was your childood nickname?">What was your childood nickname?</option>
								<option value="Who was your first school friend?">Who was your first school friend?</option>
								<option value="Which is your favourite sport?">Which is your favourite sport?</option>
								<option value="Who is your favourite university teacher?">Who is your favourite university teacher?</option>
								<option value="What is your Favourite food?">What is your Favourite food?</option>
		    				</select>
		    			</div>

		    			<div class="form-inline col-12">
		    				<label for="sqno_ans" class="col-12 col-sm-3 mt-2 h6 justify-content-start" >Security Question's Answer &nbsp;<a data-toggle="tooltip" data-html="true" title="This will be used if you forget your password.<br>So, <strong>Please Answer it carefully!!</strong>" data-placement="right"> <i class="fas fa-question-circle"></i></a></label>
		    				<input type="text" id="sqno_ans" name="sqno_ans" class="mt-2 form-control col-12 col-sm-7 offset-sm-1" placeholder="Answer to Selected Security Question" required>
		    			</div>

		    			<div class="col-3 mt-4">
		    				<button type="submit" class="btn btn-primary btn-block mt-4">Save</button>
		    			</div>

		    		</div>
		    			

		    		
	    		</form>


	    	</div>

	    </div>

	</div>


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