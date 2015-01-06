<?php
	header('Content-Type: text/html; charset=utf-8');
	ob_start();
	$host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="userDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");

	$username=$_POST['username'];
	$password=$_POST['psw'];

	$username=stripslashes($username);
	$password=stripslashes($password);
	$username=mysql_real_escape_string($username);
	$password=mysql_real_escape_string($password);
	$sql="SELECT * FROM userInfo WHERE username='$username' AND password='$password'";
	$result=mysql_query($sql);
	$count=mysql_num_rows($result);

	if($count==1){
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$position=$row['position'];
		$sql="SELECT * FROM positionPermission WHERE position_inEnglish='$position'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		session_start();
		if (isset($_GET['CN'])) {
			$_SESSION['language']="CN";
		} else {
			$_SESSION['language']="EN";
		}
		$_SESSION['username']=$username;
		$_SESSION['password']=$password;
		$_SESSION['userEditable']=$row['userEditable'];
		$_SESSION['positionEditable']=$row['positionEditable'];
		$_SESSION['menuEditable']=$row['menuEditable'];
		$_SESSION['cuisineEditable']=$row['cuisineEditable'];
		$_SESSION['orderSubmitable']=$row['orderSubmitable'];
		$_SESSION['orderChangeable']=$row['orderChangeable'];
		header("location:login_success.php");
	} else {
		if (isset($_GET['CN'])) {
			header("location:login.php?CN&Login_fail");
		} else {
			header("location:login.php?EN&Login_fail");
		}
	}
	ob_end_flush();
?>