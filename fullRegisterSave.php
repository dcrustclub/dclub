<?php  

	require_once "pdo.php";
	session_start();

	if(!isset($_POST['fullname'])){
		$_SESSION['error_dashboard'] = "You are not supposed to visit there!!";
		header('Location:dashboard.php');
		return;
	}

	date_default_timezone_set('Asia/Kolkata');
	$date = Date('Y-m-d');
	$time = Date('H:i:s');
		

	$sql_full_register = "Insert into fullregister(rno, pno, branch, security_qno, name, semester, dob, security_ans, gender, register_id, date_time) values (:rno, :pno, :br, :s_q, :name, :sem, :dob, :s_a, :gen, :r_id, :d_t)";
	$stmt_full_register = $pdo->prepare($sql_full_register);
	$stmt_full_register->execute(array(
		':rno'=>$_POST['rollno'],
		':pno'=>$_POST['wpno'],
		':br'=>$_POST['branch'],
		':s_q'=>$_POST['sqno'],
		':name'=>$_POST['fullname'],
		':sem'=>$_POST['sem'],
		':dob'=>$_POST['dob'],
		':s_a'=>$_POST['sqno_ans'],
		':gen'=>$_POST['sex'],
		':r_id'=>$_SESSION['login_register_id'],
		':d_t'=>$date." ".$time
	));

	$_SESSION['message'] = "You are fully Registered now, WELCOME TO THE FAMILY !!";
	header('Location: dashboard.php');


?>