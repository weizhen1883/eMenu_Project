<?php
  header('Content-Type: text/html; charset=utf-8');
  session_start();

  $descriptionPath="../sources/cuisines/intros/";

  $host="localhost";
  $mysql_username="root";
  $mysql_password="1qaz2wsx";
  $db_name="cuisineDB_v2";

  $conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
  mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
  mysql_select_db("$db_name")or die("cannot select DB");

  $lastSortOrder=$_POST['lastSortOrder'];
  $sortOrder=$lastSortOrder+1;
  $cuisine_type_ch=$_POST['cuisine_type_ch'];
  $cuisine_type_en=$_POST['cuisine_type_en'];

  $sql="INSERT INTO cuisineType (sortOrder,typeName_en,typeName_ch) VALUES ($sortOrder, '$cuisine_type_en', '$cuisine_type_ch')";
  mysql_query($sql);

  header("location:emenu.php");
?>