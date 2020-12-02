<?php
function get_users(){
	require_once("./connection.php");
	
	$select_statement = "SELECT * FROM users";
	$query = $select_statement;
	
	$result = mysqli_query($conn, $query);
	mysqli_close($conn);
	return $result;
}
function display_json($result){
	// output data of each row
	$data = array();
	while($row = mysqli_fetch_assoc($result)) {
		array_push($data, ["id" => $row["ukey"], "name" => $row["uname"], "pass" => $row["upass"]]);
	}
	echo json_encode($data);
}
function display_table($result){
	echo "<table id=\"users\" border=\"1\">";
	echo "	<tr>";
	echo "		<th>Id</th>";
	echo "		<th>Username</th>";
	echo "		<th>Password</th>";
	echo "	</tr>";
	while($row = mysqli_fetch_assoc($result)){
		echo "<tr>";
		echo "<th>" . $row["ukey"] . "</th>";
		echo "<th>" . $row["uname"] . "</th>";
		echo "<th>" . $row["upass"] . "</th>";
		echo "</tr>";
	}
	echo "</table>";
}
function main(){
	$result = get_users();
	if(mysqli_num_rows($result) > 0){
		display_json($result);
		mysqli_data_seek($result, 0);
		display_table($result);
	} else { echo "0 results"; }
}

main();
