<?php
	session_start();
    $host="localhost";
	$mysql_username="root";
	$mysql_password="1qaz2wsx";
	$db_name="cuisineDB";

	mysql_connect("$host","$mysql_username","$mysql_password")or die("cannot connect");
	mysql_select_db("$db_name")or die("cannot select DB");

	$sql="SELECT * FROM cuisineType ORDER BY typeID ASC";
	$result=mysql_query($sql);
	
?>