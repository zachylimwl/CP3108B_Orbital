<?php
    $con = mysqli_connect("orbitalbombsquad.x10host.com", "orbital2", "h3llo world", "orbital2_bombsquad");
    
	$room_code = mysqli_real_escape_string($con, $_POST["room_code"]);
	$question_id = mysqli_real_escape_string($con, $_POST["question_id"]);
	$player_id = mysqli_real_escape_string($con, $_POST["player_id"]);
	$time_left = mysqli_real_escape_string($con, $_POST["time_left"]);
	$num_pass = mysqli_real_escape_string($con, $_POST["num_pass"]);
    
	$statement = mysqli_prepare($con, "UPDATE Room SET player_id = ?, time_left = ?, num_pass = ?, deploy_status = 1, question_status = 1 WHERE room_code = ? AND question_id = ?");
	mysqli_stmt_bind_param($statement, "sssss", $player_id, $time_left, $num_pass, $room_code, $question_id);
	mysqli_stmt_execute($statement);
	
	if($result == true) {
		echo '{"query_result":"SUCCESS"}';
	}
	else{
		echo '{"query_result":"FAILURE"}';
	}
	
	mysqli_close($con);	

?>