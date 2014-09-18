<?php
	ob_start();
	$host="localhost";
	$mysql_username="eMenuDesigner";
	$mysql_password="1qaz2wsx";
	$db_name="eMenuDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");

	$username=$_POST['username'];
	$password=$_POST['psw'];

	$username=stripslashes($username);
	$password=stripslashes($password);
	$username=mysql_real_escape_string($username);
	$password=mysql_real_escape_string($password);
	$sql="SELECT * FROM users WHERE username='$username' and passhash='$password'";
	$result=mysql_query($sql);

	$count=mysql_num_rows($result);

	if($count==1){
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		$groups=$row['groups'];
		$sql="SELECT * FROM groups WHERE groupname='$groups'";
		$result=mysql_query($sql);
		$row=mysql_fetch_array($result,MYSQL_ASSOC);
		session_start();
		$_SESSION['username']=$username;
		$_SESSION['password']=$password;
		$_SESSION['permission']=$row['permission'];
		header("location:login_success.php");
	} else {
		header("location:login.php?Login_fail");
	}
	ob_end_flush();
?>