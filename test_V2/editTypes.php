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

  if (isset($_GET['systemLanguage'])) {
    $systemLanguage=$_GET['systemLanguage'];
  } else {
    $sql="SELECT * FROM systemSettings WHERE user='admin'";
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result,MYSQL_ASSOC);
    $systemLanguage = $row['systemLanguage'];
  }

  $typeID=$_POST['typeID'];
  $sortOrder=$_POST['sortOrder'];
  $typeName=$_POST['typeName'];

  //echo $typeID." ".$sortOrder." ".$typeName." ".$systemLanguage;

  if ($systemLanguage=="ch") {
    $sql="UPDATE cuisineType SET sortOrder=$sortOrder,typeName_ch='$typeName' WHERE typeID=$typeID";
  } elseif ($systemLanguage=="en") {
    $sql="UPDATE cuisineType SET sortOrder=$sortOrder,typeName_en='$typeName' WHERE typeID=$typeID";
  }
  mysql_query($sql);

  header("location:emenu.php?type=".$typeID);
?>