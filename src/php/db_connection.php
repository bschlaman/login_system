<?php

require_once("./helper.php");

$config_file_contents = file_get_contents("./config.json");

$config = json_decode($config_file_contents);

$host = $config->host;
$user = $config->user;
$pass = $config->pass;
$db = $config->db;

$conn = mysqli_connect($host, $user, $pass, $db) or die("ERROR: cant connect to db");

if(!$conn){
	$msg = "Unable to connect to database [" . mysqli_connect_error() . "]";
	bslog($msg);
	die($msg);
}

