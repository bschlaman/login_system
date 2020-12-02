<?php

function logger($msg){
	$fp = fopen("./logs/output.txt", "a");
	fwrite($fp, $msg);
	fclose($fp);
}
function log_start(){
	$msg = "";
	$msg = $msg . "[ " . date("h:i:sa") . " ]" . ": Create account" . "\n";
	$msg = $msg . "uname: " . $_POST["uname"] . "\n";
	$msg = $msg . "upass: " . $_POST["upass"] . "\n";
	logger($msg);
}
function log_end(){
	$msg = "===END===\n";
	logger($msg);
}

function html_debug(){
	// Printing out API params
	$msg = "";
	foreach($_POST as $key => $value) {
		$msg = $msg . "The HTML name: $key \n";
		$msg = $msg . "The content of it: $value \n";
	}
	logger($msg);
}

function check_valid(){
	$valid = true;
	// check that data comes from create_account form
	$valid = isset($_POST["create_account"]);
	// check for missing data
	$data_missing = array();
	if(empty($_POST["uname"])){ array_push($data_missing, "uname");	}
	if(empty($_POST["upass"])){ array_push($data_missing, "upass"); }
	$valid = empty($data_missing);

	return $valid;
}

function enter_user($uname, $upass){
	require_once("./connection.php");
	// build the query
	$insert_statement = "INSERT INTO users (uname, upass, ctime) VALUES";
	$values = "(\"" . $uname . "\", \"" . $upass . "\", CURTIME())";
	$query = $insert_statement . $values;
	
	$result = mysqli_query($conn, $query);
	mysqli_close($conn);

	return $result;
}

function main(){
	log_start();
	$valid = check_valid();
	if($valid){
		$uname = $_POST["uname"];
		$upass = $_POST["upass"];
		$result = enter_user($uname, $upass);
		logger("Inserted: $result \n");
	} else { logger("ERROR: invalid request\n"); }
	if($result == 1){
		echo "Your account has been created.<br>";
		echo "Welcome, " . $uname . ".<br>";
	} else { logger("ERROR: db update failed\n"); }
	log_end();
}
main();
