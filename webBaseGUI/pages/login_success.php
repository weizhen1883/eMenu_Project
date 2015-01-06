<?php
    header('Content-Type: text/html; charset=utf-8');
	session_start();
	if(!isset($_SESSION['username'])) {
        if (isset($_SESSION['language'])&&$_SESSION['language']=="CN") {
            header("location:login.php?CN");
        } else {
            header("location:login.php?EN");
        }
    }
    if ($_SESSION['language']=="CN") {
        $title="编辑菜单";
    } else {
        $title="User Menu";
    }
?>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    	<title>eMenu System</title>
    	<style type="text/css"></style>
    </head>

    <body>
    	<table width="100%" height="650px">
            <tr>
                <td></td>
                <td width="1024px" height="650px" >
                    <table width="100%" height="650px" background="../sources/pictures/background.jpg">
                        <tr height="100px"><td width="42px"></td><td width="342px"></td><td width="642px"></td></tr>
                        <tr height="450px"><td width="42px"></td><td width="342px">
                            <?php echo $title; ?>
                            <hr />
                            <?php
                            	include("menu.php");
                            ?>
                        </td><td width="642px"></td></tr>
                        <tr height="100px"><td width="42px"></td><td width="342px"></td><td width="642px"></td></tr>
                    </table>
                </td>
                <td></td>
            </tr>
        </table>
    </body>
</html>