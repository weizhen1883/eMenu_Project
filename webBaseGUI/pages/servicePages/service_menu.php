<!DOCTYPE html>
<?php
    session_start();
    if(!isset($_SESSION['username'])){
		header("location:../login.php");
    }else if($_SESSION['permission']<1||$_SESSION['permission']>2){
    	header("location:../login.php?no_permission");
    }
?>
<html>
	<head>
		<title>Service Menu</title>
    	<style type="text/css"></style>
	</head>

	<body>
		<table width="100%" height="100%">
            <tr>
                <td></td>
                <td width="1024px" height="650px" >
                    <table border="1" width="100%" height="100%" background="../../sources/pictures/background.jpg">
                        <tr height="217px"><td width="342px"></td><td width="342px"></td><td width="342px"></td></tr>
                        <tr height="217px"><td width="342px"></td><td width="342px"></td><td width="342px"></td></tr>
                        <tr height="217px"><td width="342px"></td><td width="342px"></td><td width="342px"></td></tr>
                    </table>
                </td>
                <td></td>
            </tr>
        </table>
	</body>
</html>