<?php  
	require_once 'pdo.php';
	session_start();

	if(isset($_COOKIE['DCLID'])){

	}
	
	else{


			if(isset($_POST['email'])&&isset($_POST['pass'])){
				
				//Getting the credential from database
				$sql_get_credentials = "Select * from login where email=:mail_id";
				$stmt_get_credentials = $pdo->prepare($sql_get_credentials);
				$stmt_get_credentials->execute(array(
					':mail_id' => $_POST['email']
				));
				$row_get_credentials = $stmt_get_credentials->fetch(PDO::FETCH_ASSOC);
				date_default_timezone_set('Asia/Kolkata');
				$date = Date('Y-m-d');
				$time = Date('H:i:s');
				
				//If the credentials are not found
				if(!$row_get_credentials){
					$_SESSION['error'] = "No user registered with the given email, <a href='#' class='alert-link' data-toggle='modal' data-target='#registerModal' data-dismiss='modal'>Reigster Now</a>";
					//Now, storing the login_fail_log in the login fail table
					$sql_store_error_credentials = 'Insert into loginerroremail(error_email, error_pwd, date_time) values (:err_m, :err_p, :dt)';
					$stmt_store_error_credentials = $pdo->prepare($sql_store_error_credentials);
					$stmt_store_error_credentials->execute(array(
						':err_m'=>$_POST['email'],
						':err_p'=>$_POST['pass'],
						':dt'=> $date." ".$time
					));

					header('Location: index.php');
					return;

				}
			


			//Now checking if the password matches or not
			//if the password doesn't matched
			$pass = $row_get_credentials['password'];

			if(!password_verify($_POST['pass'], $pass)){
				$_SESSION['error'] = "The password you entered doesn't match the one you registered with. Please <a href='#' class='alert-link' data-toggle='modal' data-target='#loginModal' data-dismiss='modal'> try again</a>";
				//Now, storing the wrong password error
				$sql_store_error_pwd = "Insert into loginerrorpwd(login_id, error_pwd, date_time) values (:login_id, :e_pwd, :dt)";
				$stmt_store_error_pwd= $pdo->prepare($sql_store_error_pwd);
				$stmt_store_error_pwd->execute(array(
					':login_id'=>$row_get_credentials['login_id'],
					':e_pwd'=>$_POST['pass'],
					':dt'=>$date." ".$time
				));
				header('Location:index.php');
				return;
			}

			//Now, setting up the cookie
			if(isset($_POST['rememberme'])){
				$cstrong = True;
				$token = bin2hex(openssl_random_pseudo_bytes(64, $cstrong));
				//set second null to  True in case of ssl
				setcookie('DCLID', $token.".".$_POST['name'].".".$_POST['pass'], 60*60*24*7, '/', NULL, NULL, True);
			}

			//Now, since all the necessary conditions are satisfied, proceeding the user to dashboard
			$_SESSION['message'] = "You are successfully logged in!";
			$_SESSION['name'] = $row_get_credentials['name'];
			$_SESSION['login_id'] = $row_get_credentials['login_id'];
			$_SESSION['login_register_id'] = $row_get_credentials['register_id'];
			//Now, storing the login log in the database
			$sql_store_login_log = "Insert into loginsuccesslog (login_id, date_time) values (:login_id, :dt)";
			$stmt_store_login_log = $pdo->prepare($sql_store_login_log);
			$stmt_store_login_log -> execute(array(
				':login_id'=>$row_get_credentials['login_id'],
				':dt'=>$date." ".$time
			));
			//Heading to the dashboard
			
			header('Location: dashboard.php');
			

		}
		else{
			$_SESSION['error'] = "Please fill the <a href='#' class='alert-link' data-toggle='modal' data-target='#loginModal' data-dismiss='modal'>login form</a> first!";
			header('Location:index.php');
		}

	}


?>

<!DOCTYPE html>
<html>
<head>
	<title>Regestering you up!!, please wait | Dcrust Club</title>
</head>
<body>

	<div>
		<div style="height:40vh;">
		</div>
		<center>
			<img src = "img/spinner.gif" alt="Loading .." style="width: 50px;">
		</center>
	</div>
</body>
</html>