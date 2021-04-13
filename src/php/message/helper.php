<?php

// logging functions
function bslog($msg){
	$fp = fopen("./logs/output.txt", "a");
	$msg = "[ " . date("h:i:sa") . " ]" . $msg;
	fwrite($fp, $msg);
	fclose($fp);
}

function request_debug(){
	// log request params
	$msg = "";
	foreach($_POST as $key => $value){
		$msg = $msg . "POST param key: $key \n";
		$msg = $msg . "value: $value \n";
	}
	foreach($_GET as $key => $value){
		$msg = $msg . "GET param key: $key \n";
		$msg = $msg . "value: $value \n";
	}
	bslog($msg);
}

function check_valid_request($method, $form_name, $required_params){
	$valid = true;
	// check method
	$valid = $valid && ($_SERVER["REQUEST_METHOD"] == strtoupper($method));
	// check form
	$valid = $valid && isset($_POST[$form_name]);
	// check required params
	foreach($required_params as $param){
		$valid = $valid && isset($_POST[$param]);
	}
	return $valid;
}
