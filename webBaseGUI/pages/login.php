<!DOCTYPE html>
<?php
    session_start();
    session_unset();
    session_destroy();
?>
<html>
	<head>
    	<title>eMenu System</title>
    	<style type="text/css"></style>
        <script type="text/javascript" src="../sources/js/util-functions.js"></script>
        <script type="text/javascript" src="../sources/js/clear-default-text.js"></script>
    </head>

    <body>
    	<table width="100%" height="650px">
            <tr>
                <td></td>
                <td width="1024px" height="650px" >
                    <table width="100%" height="100%" background="../sources/pictures/background.jpg">
                        <tr height="217px"><td width="42px"></td><td width="342px"></td><td width="642px" align="right" valign="top"><a href="customersMenu.php"><img src="../sources/pictures/menuLogo.jpg" width="100px"></a></td></tr>
                        <tr height="217px"><td width="42px"></td><td width="342px">
                            <form name="userLogin" action="checklogin.php" method="post">
                                <table width="342px" height="217px">
                                    <tr><td align="center">eMenu Restaurant Management System</td></tr>
                                    <tr><td align="center">User Login</td></tr>
                                    <tr><td align="center">username: <input type="text" name="username" id="username" value="Customers" class="cleardefault"></td></tr>
                                    <tr><td align="center">password: <input type="password" name="psw" id="psw" value="Customers" class="cleardefault"></td></tr>
                                    <tr><td align="center"><input type="submit" name="Login" value="Login"></td></tr>
                                    <tr><td align="center"><?php
                                        if(isset($_GET['Login_fail'])){
                                            echo '<span style="color:red; text-align:center;">wrong username or password!</span>';
                                        }else if(isset($_GET['no_permission'])){
                                            echo '<span style="color:red; text-align:center;">Current user do not have permission, please login again!</span>';
                                        }else{
                                            echo ' ';
                                        }
                                    ?></td></tr>
                                </table>
                            </form>
                        </td><td width="642px"></td></tr>
                        <tr height="216px"><td width="42px"></td><td width="342px"></td><td width="642px"></td></tr>
                    </table>
                </td>
                <td></td>
            </tr>
        </table>
    </body>
</html>