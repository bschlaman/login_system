<?php

// logging functions
function bslog($msg){
	$fp = fopen("./logs/output.log", "a") or die("ERROR: cant write to logs");
	$msg = "[ " . date("h:i:sa") . " ] " . $msg . "\n";
	fwrite($fp, $msg);
	fclose($fp);
}

function request_debug(){
	// log request params
	$msg = "";
	foreach($_POST as $key => $value){
		$msg .= "POST param key: $key ";
		$msg .= "value: $value \n";
	}
	foreach($_GET as $key => $value){
		$msg .= "GET param key: $key ";
		$msg .= "value: $value \n";
	}
	bslog($msg);
}

function check_valid_request($method, $submit_name, $required_params){
	$valid = true;
	// check method
	$valid = $valid && ($_SERVER["REQUEST_METHOD"] == strtoupper($method));
	$method_placeholder = $_SERVER["REQUEST_METHOD"] == "POST" ? $_POST : $_GET;
	// check submit
	$valid = $valid && isset($method_placeholder[$submit_name]);
	// check required params
	foreach($required_params as $param){
		$valid = $valid && isset($method_placeholder[$param]);
	}
	return $valid;
}
