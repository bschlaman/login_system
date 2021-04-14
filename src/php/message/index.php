<?php

require_once("./helper.php");

function insert_message(){
	require_once("./db_connection.php");

	$subject = mysqli_real_escape_string($conn, $_POST["subject"]);
	$message = mysqli_real_escape_string($conn, $_POST["message"]);
	$fname = mysqli_real_escape_string($conn, $_POST["fname"]);
	$lname = mysqli_real_escape_string($conn, $_POST["lname"]);
	$email = mysqli_real_escape_string($conn, $_POST["email"]);

	// build the query
	$insert_statement = "INSERT INTO messages
											(msg_datetime, msg_subject, msg_message, sender_fname, sender_lname, sender_email)
											VALUES
											(CURTIME(), '$subject', '$message', '$fname', '$lname', '$email')";

	$query = $insert_statement;
	$result = mysqli_query($conn, $query);
	mysqli_close($conn);

	return $result;
}

function main(){
	bslog("APPLICATION START");

	echo "Validating request...<br>";
	request_debug();
	$required_params = array("fname", "lname", "email", "subject", "message");
	$valid = check_valid_request("POST", "submit_form", $required_params);
	if($valid){
		insert_message();
		echo "Your message has been received.<br>";
	} else {
		echo "Something is wrong with your request.  Make sure all fields are present.<br>";
	}

	bslog("APPLICATION END");
}
main();
