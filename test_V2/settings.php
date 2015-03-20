<?php
  header('Content-Type: text/html; charset=utf-8');
  session_start();

  $host="localhost";
  $mysql_username="root";
  $mysql_password="1qaz2wsx";
  $db_name="cuisineDB_v2";

  $conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
  mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
  mysql_select_db("$db_name")or die("cannot select DB");

  $systemLanguage=$_POST['language'];

  $sql="UPDATE systemSettings SET systemLanguage='$systemLanguage' WHERE user='admin'";
  $result=mysql_query($sql);

  header("location:emenu.php");
?>