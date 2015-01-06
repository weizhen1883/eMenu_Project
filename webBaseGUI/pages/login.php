<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    session_unset();
    session_destroy();
    if (isset($_GET['CN'])) {
        $title="eMenu 餐厅管理系统";
        $subTitle="用户登录";
        $subTitleUsername="用户名: ";
        $subTitlePassword="密  码: ";
        $language="CN";
    } else {
        $title="eMenu Restaurant Management System";
        $subTitle="User Login";
        $subTitleUsername="username:";
        $subTitlePassword="password:";
        $language="EN";
    }
?>
<html>
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
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
                            <form name="userLogin" action="checklogin.php?<?php echo $language; ?>" method="post">
                                <table width="342px" height="217px">
                                    <tr><td align="center"><?php echo $title; ?></td></tr>
                                    <tr><td align="center"><?php echo $subTitle; ?></td></tr>
                                    <tr><td align="center"><?php echo $subTitleUsername; ?><input type="text" name="username" id="username" value="Customers" class="cleardefault"></td></tr>
                                    <tr><td align="center"><?php echo $subTitlePassword; ?><input type="password" name="psw" id="psw" value="Customers" class="cleardefault"></td></tr>
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