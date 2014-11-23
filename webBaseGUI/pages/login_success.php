<?php
	session_start();
	if(!isset($_SESSION['username'])) {
        header("location:login.php");
    }
?>
<html>
	<head>
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
                            User Menu
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