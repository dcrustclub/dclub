<?php  
	require_once 'pdo.php';
	session_start();
	//Checking the get parameter
	if(!isset($_SESSION['e_id'])){
		$_SESSION['error'] = 'You are not allowed to access that page';
		header('Location: index.php');
		return;
	}

	//First saving the information in login.php
	//getting infromtation from register table
	$sql_reg_detail = 'Select * from register where email=:e_id';
	$stmt_reg_detail = $pdo->prepare($sql_reg_detail);
	$stmt_reg_detail->execute(array(
		':e_id'=>$_SESSION['e_id']
	));

	
	$row_reg_detail = $stmt_reg_detail->fetch(PDO::FETCH_ASSOC);
	//Now, saving the registration information
	$sql_login_save = 'Insert into login(email, password, name, register_id) values (:em, :pd, :nm, :r_id)';
	$stmt_login_save = $pdo->prepare($sql_login_save);
	$stmt_login_save->execute(array(
		':em'=> $row_reg_detail['email'],
		':pd'=> $row_reg_detail['pwd'],
		':nm'=> $row_reg_detail['name'],
		':r_id'=> $row_reg_detail['register_id']
	));		

	$_SESSION['message']="You are now successfully registered, You may<a href='#' class='alert-link' data-toggle='modal' data-target='#loginModal' data-dismiss='modal'> Login</a> Now!!";
	header('Location: index.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>Regestering you up!!, please wait | Dcrust Club</title>
</head>
<body>

	<div>
		<center>
			<img src = './img/spinner.gif' alt="spinner">
			<h6>Loading... Please wait</h6>
		</center>
	</div>

</body>
</html>
