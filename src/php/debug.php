<?php

echo "Start of PHP script<br>";
echo shell_exec("whoami") . "<br>";
echo shell_exec("ls -ld /var/www/html") . "<br>";

// Messing with logging
$fp = fopen("./logs/output.txt", "a");
fwrite($fp, date("h:i:sa") . "\n");
fclose($fp);

// Printing out API params
foreach($_POST as $key => $value) {
	echo "The HTML name: $key <br>";
	echo "The content of it: $value <br>";
}

if(isset($_POST["create_account"])){
	echo "Inside isset <br>";

	$data_missing = array();

	if(empty($_POST["uname"])){
		$data_missing[] = "uname";
	} else {
		$uname = trim($_POST["uname"]);
	}
	if(empty($_POST["password"])){
		$data_missing[] = "password";
	}	else {
		$upass = trim($_POST["password"]);
	}

	if(empty($data_missing)){
		require_once("./connection.php");
		$insert_statement = "INSERT INTO users (uname, upass, ctime) VALUES";
		$values = "(\"" . $uname . "\", \"" . $upass . "\", CURTIME())";
		$query = $insert_statement . $values;
		
		$result = mysqli_query($conn, $query);
		mysqli_close($conn);

		echo "Result: " . $result;

	} else {
		echo "Missing:<br/>";
		foreach($data_missing as $missing){
			echo $missing . "<br/>";
		}
	}

}
