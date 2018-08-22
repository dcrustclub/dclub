<?php 
	session_start();
	require_once "pdo.php";
	date_default_timezone_set('Asia/Kolkata');
		$date = Date('Y-m-d');
		$time = Date('H:i:s');
		
	$sql_store_logout_log = "insert into logoutlog(login_id, date_time) values (:l_id, :dt)";
	$stmt_store_logout_log= $pdo->prepare($sql_store_logout_log);
	$stmt_store_logout_log->execute(array(
		':l_id'=>$_SESSION['login_id'],
		':dt'=>$date." ".$time
	));
	
	session_destroy();
	header('Location: index.php');
	
?>