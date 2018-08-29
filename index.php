<?php  
  session_start();
  
  
  if(isset($_SESSION['name'])){
    header('Location: dashboard.php');
    return;
  }
  


?>



<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home | Register to events happening in dcrust and other colleges nearby</title>

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
        <li class="nav-item">
          <a class="text-white nav-link" href="#" id="loginButton"data-target="#loginModal" data-toggle="modal"><i class="fas fa-sign-in-alt"></i> Log in <span class="sr-only">(Login)</span></a>
        </li>
        <li class="nav-item">
          <button type="button" class=" text-white btn btn-success" id="registerButton" data-target="#registerModal" data-toggle="modal" id="register" ><i class="fas fa-user-plus"></i> Register </button>
        </li>
      </ul>
    </div>
  </nav>


  <!-- Here comes the modal content -->
  

  <!-- this is for the login modal -->
  <div class="modal fade" id="loginModal" role="dialog">
    <div class="modal-dialog modal-md" role="content">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <div class="lead"><i class="fas fa-sign-in-alt"></i> Login Form</div>
          <button type="button" class="close" data-dismiss="modal" style="color:floralwhite;"><i class="fas fa-times-circle"></i> </button>
        </div>
        <div class="modal-body">
          <!-- Here we will make use of cards -->
          <div class="card">
            <div class="card-body">
              <div class="text-center h5 mb-3">Welcome back, <i class=" display-3 fas fa-smile-beam"></i>
                <p class="lead">Please fill out the details here <i class="fas fa-hand-point-down"></i></p>
              </div>

              <form class="mt-3" method="post" action="login.php">
                <div class="form-group form-inline mt-3">
                  <label for="email" class="h5 col-12 col-sm-3">Email</label>
                  <input type="email" name="email" class="col-12 col-sm-7 offset-sm-1 form-control" id="email" placeholder="Your email here" required>
                </div>
                <div class="form-group form-inline">
                  <label for="pass" class="h5 col-12 col-sm-3">Password</label>
                  <input type="Password" name="pass" class="col-12 col-sm-7 offset-sm-1 form-control" id="pass" name="pass" placeholder="Your P******d here" required>
                </div>

                <button class="col-4 col-sm-3 offset-sm-4 btn btn-success mt-3" role="button" type="submit" >Login <i class="fas fa-lock"></i></button>
                <button class="col-4 col-sm-3 btn btn-warning text-white mt-3" role="button" data-dismiss="modal">Cancel <i class="fas fa-times"></i></button>
                <div class="form-group mt-3 text-center">
                  <div class="col-12 col-sm-7 offset-sm-4">New user? <a href="#" data-toggle="modal" data-target="#registerModal" data-dismiss="modal">Register</a> instead!
                  </div>
                </div>
              </form>
            </div>
          </div>

        </div>

      </div>

    </div>
  </div>

  <!-- Now, comes the Register Modal content -->

  <div class="modal fade" id="registerModal" role="dialog">
    <div class="modal-dialog modal-md" role="content">
      <div class="modal-content">
        <div class="modal-header bg-dark text-white">
          <div class="lead"><i class="fas fa-user-plus"></i> Register Form</div>
          <button  type="button" class="close" data-dismiss="modal" style="color:floralwhite;"><i class="fas fa-times-circle"></i> </button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <div class="text-center h5 mb-3">Welcome, <i class=" display-3 fas fa-smile-beam"></i>
                <p class="lead">Please fill out the details here <i class="fas fa-hand-point-down"></i></p>
              </div>

              <form method="post" action="register.php">
                <div class="form-group form-inline">
                  <label for="name" class="col-12 col-sm-3">Username</label>
                  <input type="text" id="name" name="name" class="form-control col-10 col-sm-8 offset-1" required>
                </div>
                <div class="form-group form-inline">
                  <label for="emailRegister" class="col-12 col-sm-3">Email</label>
                  <input type="email" id="emailRegister" name="emailRegister" class="form-control col-10 col-sm-8 offset-1" required>
                </div>
                <div class="form-group form-inline">
                  <label for="passRegister" class="col-12 col-sm-3">Password</label>
                  <input type="password" id="passRegister" name="passRegister" class="form-control col-10 col-sm-8 offset-1" required>
                </div>
                <div class='form-group'>
                  <div class="col-12">By Registering, you agree to our <a href="#">Terms and Conditions</a> </div>
                </div>
                <button class="col-5 col-sm-3 offset-sm-4 offset-1 btn btn-success mt-3" type="submit" >Register <i class="fas fa-lock"></i></a>
                <button class="col-4 col-sm-3 btn btn-warning text-white mt-3" type="submit" data-dismiss="modal">Cancel <i class="fas fa-times"></i></button>
                <div class="form-group mt-3">
                  <div class="col-12 col-sm-7 offset-sm-4">Existing user? <a href="#" data-toggle="modal" data-target="#loginModal" data-dismiss="modal">Login</a> instead!
                  </div>
                </div>

              </form>



            </div>
          </div>

        </div>

      </div>

    </div>

  </div>





    <!-- Here are the body content -->

    <div class="container">
      

      <!-- Printing the message -->
      <?php  
        if(isset($_SESSION['message'])){
          echo "<div class='alert alert-success mt-4'>";
          echo $_SESSION['message'];
          echo "</div>";
          unset($_SESSION['message']);
        }
        if(isset($_SESSION['error'])){
          echo "<div class='alert alert-danger mt-4'>";
          echo $_SESSION['error'];
          echo "</div>";
          unset($_SESSION['error']);
        }

      ?>
        
      

        <div class="row">
          <div class="col-12 mt-4 col-md-7">
            <h4>Cultural Festivals</h4>
            <hr/>
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




  <footer class="container-fluid bg-secondary text-white mt-4">
    <div class="container ">
      <div class="row">
        <!-- Some important content here -->
        <div class="col-5 mt-3">
          <h6><i class="fas fa-external-link-alt"></i> Links: </h6>
          <hr>
          <ul class="list-unstyled">
            <li><a href="#" class="text-white" data-toggle="tooltip" data-html="true" title="Host an Event in Dcrust or Around" data-placement="right"><i class="fas fa-plus-square"></i> Event</a></li>
            <li><a href="#" class="text-white" data-toggle="tooltip" data-html="true" title="Know about us more" data-placement="right"><i class="fas fa-info"></i> About us</a></li>
            <li><a href="#" class="text-white" data-toggle="tooltip" data-html="true" title="Struck somewhere? Click here <i class='fas fa-hand-point-left'></i>" data-placement="right" ><i class="fas fa-question"></i> Help</a></li>
            <li><a href="#" class="text-white" data-toggle="tooltip" data-html="true" title="Click if you want to contribute to the project!" data-placement="right"  ><i class="fas fa-briefcase"></i> Careers</a></li>
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();

        });

        $('#loginButton').click(function(){
          console.log("Login Button clicked");
          $('#email').focus();
        });

        $('#email').focus(function(){
          console.log("Email is focussed");
        });




    </script>

  </body>
</html>



