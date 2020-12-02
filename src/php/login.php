<?php
function logger($msg){
	$fp = fopen("./logs/output.txt", "a");
	fwrite($fp, $msg);
	fclose($fp);
}
function get_user($uname){
	require_once("./connection.php");
	
	$select_statement = "SELECT * FROM users WHERE uname = \"" . $uname . "\"";
	$query = $select_statement;
	
	$result = mysqli_query($conn, $query);
	mysqli_close($conn);
	return $result;
}
function check_valid(){
	return true;
}
function main(){
	$valid = check_valid();
	if($valid){
		$uname = $_POST["uname"];
		$upass = $_POST["upass"];
		$result = get_user($uname);
		logger("Found user: $uname \n");
	} else { logger("ERROR: invalid request\n"); }
	if(mysqli_num_rows($result) >= 1){
		echo "Valid user: $uname";
	} else {
		echo "User does not exist: $uname";
	}
}
main();
