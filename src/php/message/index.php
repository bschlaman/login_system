<?php

require_once("./helper.php");
require_once("./db_connection.php");

function main(){
	bslog("APPLICATION START");

	echo "Validating request...<br>";
	request_debug();
	$required_params = array("fname", "lname", "email", "subject", "message");
	$valid = check_valid_request("POST", "submit_form", $required_params);
	if($valid){
		echo "Your message has been received.<br>";
	} else {
		echo "Something is wrong with your request.  Make sure all fields are present.<br>";
	}

	bslog("APPLICATION END");
}
main();
