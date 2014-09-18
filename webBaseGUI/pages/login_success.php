<?php
	session_start();
	if($_SESSION['permission']>=3){
		header("location:managerPages/manager_menu.php");
	}else if($_SESSION['permission']>1){
		header("location:servicePages/service_menu.php");
	}else if($_SESSION['permission']==0){
		header("location:customers_menu.php");
	}else{
		header("location:login.php?no_permission");
	}
?>