
<?php  
	require_once 'pdo.php';
	session_start();	
	
	//Things to do:
	//Add solid validation and add the suggestions to this list
	//Password validation
	//Email validation
	//
	//Add method to prevent duplicate email registration
	//

	
	if(isset($_POST['name'])&& isset($_POST['emailRegister'])&&isset($_POST['passRegister'])){
		
		

		//First checking whether the email is already in use or not
		$sql_check_duplicate = 'Select email from register where email=:mail_id';
		$stmt_check_duplicate = $pdo->prepare($sql_check_duplicate);
		$stmt_check_duplicate->execute(array(
			':mail_id'=> $_POST['emailRegister']
		));
		$row_email_check = $stmt_check_duplicate->fetch(PDO::FETCH_ASSOC);
		if($row_email_check){
			$_SESSION['error'] = "Email address you entered is already in use";
			header('Location: index.php');
			return;
		}
		echo "Check done";
		
		//Now, inserting the record in the 
		$sql = 'INSERT into register(name, email, pwd, date_time ) values(:name, :email, :pass, :dt)';
			
		date_default_timezone_set('Asia/Kolkata');
		$date = Date('Y-m-d');
		$time = Date('H:i:s');
		$get_r_id = 'Select register_id from register where email=:reg_mail';
		$stmt=$pdo->prepare($sql);
		$stmt->execute(array(
			':name'=>$_POST['name'],
			':email'=>$_POST['emailRegister'],
			':pass'=>password_hash($_POST['passRegister'], PASSWORD_BCRYPT),
			':dt' => $date." ".$time
		));
		
		$_SESSION['e_id'] = $_POST['emailRegister'];
		header('Location: loginSave.php');

	}	
	else{
		$_SESSION['error'] = "Please fill the <a href='#' class='alert-link' data-toggle='modal' data-target='#registerModal' data-dismiss='modal'>registeration form!</a>";
		header('Location: index.php');
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




