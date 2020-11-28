<?php
$host = "mysql_running";
$user = "user";
$pass = "pass";
$db = "USERDATA";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn){
	die("Unable to connect to database [" . mysqli_connect_error() . "]");
}

