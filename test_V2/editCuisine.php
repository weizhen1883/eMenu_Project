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

  $cuisineID=$_POST['cuisineID'];
  //echo $cuisineID;

  if (isset($_GET['systemLanguage'])) {
    $systemLanguage=$_GET['systemLanguage'];
    //echo $systemLanguage;
  } else {
    $sql="SELECT * FROM systemSettings WHERE user='admin'";
    $result=mysql_query($sql);
    $row=mysql_fetch_array($result,MYSQL_ASSOC);
    $systemLanguage = $row['systemLanguage'];
  }

  if (isset($_GET['dailyspecial'])) {
    $specialPrice=$_POST['specialPrice'];
    //echo $specialPrice;
    $sql="UPDATE cuisineList SET specialPrice=$specialPrice WHERE cuisineID=$cuisineID";
    mysql_query($sql);
    header("location:emenu.php?special");
  } else {
    $cuisineName=$_POST['cuisineName'];
    //echo $cuisineName;
    $retailPrice=$_POST['retailPrice'];
    //echo $retailPrice;
    $description=$_POST['description'];
    //echo $description;
    if ($systemLanguage=="en") {
      $sql="UPDATE cuisineList SET cuisineName_en='$cuisineName',retailPrice=$retailPrice WHERE cuisineID=$cuisineID";
      mysql_query($sql);
      $sql="SELECT * FROM cuisineList WHERE cuisineID=$cuisineID";
      $result=mysql_query($sql);
      $row=mysql_fetch_array($result,MYSQL_ASSOC);
      $descFile=$row['description_en'];
      //echo $descFile;
      $f=fopen($descriptionPath.$descFile, "w") or die("Unable to open file!");
      fwrite($f, $description);
      fclose($f);
    } elseif ($systemLanguage=="ch") {
      $sql="UPDATE cuisineList SET cuisineName_ch='$cuisineName',retailPrice=$retailPrice WHERE cuisineID=$cuisineID";
      mysql_query($sql);
      $sql="SELECT * FROM cuisineList WHERE cuisineID=$cuisineID";
      $result=mysql_query($sql);
      $row=mysql_fetch_array($result,MYSQL_ASSOC);
      $descFile=$row['description_ch'];
      //echo $descFile;
      $f=fopen($descriptionPath.$descFile, "w") or die("Unable to open file!");
      fwrite($f, $description);
      fclose($f);
    }

    $cuisineTypeID=$_POST['cuisine_type'];
    //echo $cuisineTypeID;
    $sql="UPDATE cuisineList SET typeID=$cuisineTypeID WHERE cuisineID=$cuisineID";
    mysql_query($sql);

    if (isset($_GET['type'])) {
      $typeID=$_GET['type'];
      header("location:emenu.php?type=".$typeID);
    } else {
      header("location:emenu.php");
    }
  }
?>