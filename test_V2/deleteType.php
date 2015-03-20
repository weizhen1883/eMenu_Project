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

  $typeID=$_POST['typeID'];
  //echo $typeID;

  //delete the type from the cuisineType table.
  $sql="DELETE FROM cuisineType WHERE typeID=$typeID";
  mysql_query($sql);
  //update the typeID to null in cuisineList.
  $sql="UPDATE cuisineList SET typeID=NULL WHERE typeID=$typeID";
  mysql_query($sql);
  //reset the typeID auto increment in cuisineType
  $sql="UPDATE cuisineType SET typeID=typeID-1,sortOrder=sortOrder-1 WHERE typeID>$typeID";
  mysql_query($sql);
  $sql="SELECT MAX(typeID) FROM cuisineType";
  $max=mysql_result(mysql_query($sql),0);
  $update_auto_increment=$max+1;
  //echo $update_auto_increment;
  $sql="ALTER TABLE cuisineType AUTO_INCREMENT=$update_auto_increment";
  mysql_query($sql);
  //update the typeID in cuisineList
  $sql="UPDATE cuisineList SET typeID=typeID-1 WHERE typeID>$typeID";
  mysql_query($sql);
  header("location:emenu.php");
?>