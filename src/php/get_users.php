<?php
require_once("./connection.php");

$select_statement = "SELECT * FROM users";
$query = $select_statement;

header('Content-type:application/json;charset=utf-8');
$result = mysqli_query($conn, $query);
if (mysqli_num_rows($result) > 0) {
	// output data of each row
	$data = array();
	while($row = mysqli_fetch_assoc($result)) {
		// array_push($data, [$row["ukey"] => ["name" => $row["uname"], "pass" => $row["upass"]]]);
		array_push($data, ["id" => $row["ukey"], "name" => $row["uname"], "pass" => $row["upass"]]);
	}
	echo json_encode($data);
} else {
	echo "0 results";
}

mysqli_close($conn);
