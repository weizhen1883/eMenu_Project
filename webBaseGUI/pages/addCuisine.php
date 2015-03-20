<?php
  header('Content-Type: text/html; charset=utf-8');
  define("Upload_DIR", "/var/www/sources/cuisines/photos/");
  define("Intro_DIR", "/var/www/sources/cuisines/intros/");
  session_start();

  $descriptionPath="../sources/cuisines/intros/";

  $host="localhost";
  $mysql_username="root";
  $mysql_password="1qaz2wsx";
  $db_name="cuisineDB_v2";

  $conn=mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
  mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);
  mysql_select_db("$db_name")or die("cannot select DB");

  $cuisineName_ch=$_POST['cuisine_name_ch'];
  $cuisineName_en=$_POST['cuisine_name_en'];
  $cuisineTypeID=$_POST['cuisine_typeID'];
  $retailPrice=$_POST['cuisine_retailPrice'];
  $description_ch=$_POST['cuisine_description_ch'];
  $description_en=$_POST['cuisine_description_en'];

  //echo $cuisineName_ch." | ".$cuisineName_en." | ".$cuisineTypeID." | ".$retailPrice." | ".$description_ch." | ".$description_en;
  
  //check the least available id
  $first_available_id=mysql_result(mysql_query("SELECT cuisineID+1 FROM cuisineList list WHERE NOT EXISTS (SELECT * FROM cuisineList WHERE cuisineID=list.cuisineID+1) ORDER BY cuisineID ASC LIMIT 1"), 0);
  $max_id=mysql_result(mysql_query("SELECT MAX(cuisineID) FROM cuisineList"), 0);
  //insert the new cuisine row into the list
  if ($max_id > $first_available_id) {
    $sql="INSERT INTO cuisineList (cuisineID,cuisineName_en,cuisineName_ch,typeID,dailySpecial,retailPrice) VALUES ($first_available_id, '$cuisineName_en', '$cuisineName_ch', '$cuisineTypeID', 0, $retailPrice)";
  } else {
    $sql="INSERT INTO cuisineList (cuisineName_en,cuisineName_ch,typeID,dailySpecial,retailPrice) VALUES ('$cuisineName_en', '$cuisineName_ch', '$cuisineTypeID', 0, $retailPrice)";
  }
  mysql_query($sql);

  $sql="SELECT * FROM cuisineList WHERE cuisineName_en='$cuisineName_en' OR cuisineName_ch='$cuisineName_ch'";
  $result=mysql_query($sql);
  $row=mysql_fetch_array($result,MYSQL_ASSOC);
  $cuisineID=$row['cuisineID'];
  //echo $cuisineID;
  $descriptionName_en="enIntro".$cuisineID.".txt";
  $descriptionName_ch="chIntro".$cuisineID.".txt";

  $f = fopen(Intro_DIR.$descriptionName_en, "w");
  fwrite($f, $description_en);
  fclose($f);
  chmod(Intro_DIR.$descriptionName_en, 0644);

  $f = fopen(Intro_DIR.$descriptionName_ch, "w");
  fwrite($f, $description_ch);
  fclose($f);
  chmod(Intro_DIR.$descriptionName_ch, 0644);

  if (!empty($_FILES['imageFile'])) {
    $imageFile=$_FILES['imageFile'];
    $fileName=$imageFile['name'];

    $parts=pathinfo($fileName);
    $cuisineImage="image".$cuisineID.".".$parts['extension'];
    
    $upload=move_uploaded_file($imageFile['tmp_name'], Upload_DIR.$cuisineImage);
    chmod(Upload_DIR.$cuisineImage, 0644);
  }

  $sql="UPDATE cuisineList SET description_en='$descriptionName_en',description_ch='$descriptionName_ch',cuisineImage='$cuisineImage' WHERE cuisineID=$cuisineID";
  mysql_query($sql);

  header("location:emenu.php");
?>