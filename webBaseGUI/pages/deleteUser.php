<?php
	session_start();
	if(!isset($_SESSION['username']) || $_SESSION['userEditable'] == "N" || !isset($_GET['username'])) {
        header("location:login.php");
    }

	if (isset($_GET['username'])) {
		$host="localhost";
		$mysql_username="root";
		$mysql_password="1qaz2wsx";
		$db_name="userDB";

		mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
		mysql_select_db("$db_name")or die("cannot select DB");

		$username=$_GET['username'];
		$username=stripslashes($username);
		$username=mysql_real_escape_string($username);

		$sql="DELETE FROM userInfo WHERE username='$username'";
		$result=mysql_query($sql);

		if ($_GET['username']==$_SESSION['username']) {
			header("location:login.php");
		} else {
			header("location:editUsers.php");
		}
	}
?>