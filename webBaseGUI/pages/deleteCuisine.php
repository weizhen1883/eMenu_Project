<?php
  header('Content-Type: text/html; charset=utf-8');
  define("Image_DIR", "/var/www/sources/cuisines/photos/");
  define("Intro_DIR", "/var/www/sources/cuisines/intros/");
  session_start();

  $host="localhost";
  $mysql_username="root";
  $mysql_password="1qaz2wsx";
  $db_name="cuisineDB_v2";

  $conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
  mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
  mysql_select_db("$db_name")or die("cannot select DB");

  $cuisineID=$_POST['cuisineID'];
  if (isset($_GET['type'])) {
    $typeID=$_GET['type'];
    $sql="UPDATE cuisineList SET typeID=NULL WHERE cuisineID=$cuisineID";
    mysql_query($sql);
    header("location:emenu.php?type=".$typeID);
  } elseif (isset($_GET['special'])) {
    $sql="UPDATE cuisineList SET dailySpecial=0 WHERE cuisineID=$cuisineID";
    mysql_query($sql);
    header("location:emenu.php?special");
  }else {
    //delete the cuisine files.
    $sql="SELECT * FROM cuisineList WHERE cuisineID=$cuisineID";
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result,MYSQL_ASSOC);
    unlink(Intro_DIR.$row['description_en']);
    unlink(Intro_DIR.$row['description_ch']);
    unlink(Image_DIR.$row['cuisineImage']);
    //delete the cuisine from the cuisineList
    $sql="DELETE FROM cuisineList WHERE cuisineID=$cuisineID";
    mysql_query($sql);
    //update the max id
    $max_id=mysql_result(mysql_query("SELECT MAX(cuisineID) FROM cuisineList"), 0);
    $auto_increment_id=$max_id+1;
    mysql_query("ALTER TABLE cuisineList AUTO_INCREMENT=$auto_increment_id");
    header("location:emenu.php");
  }
?>