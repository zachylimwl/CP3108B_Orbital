<?php
    $con = mysqli_connect("orbitalbombsquad.x10host.com", "orbital2", "h3llo world", "orbital2_bombsquad");
    
    $host = mysqli_real_escape_string($con, $_POST["user_id"]);
	$room_status = mysqli_real_escape_string($con, $_POST["room_status"]);
	$room_code = mysqli_real_escape_string($con, $_POST["room_code"]);
	$player = mysqli_real_escape_string($con, $_POST["player"]);
	
	$statement = mysqli_prepare($con, "UPDATE Room SET deploy_status = 0, time_left = 0, player_id = 0, num_pass = 0, question_status = 0 WHERE room_code = ?");
	mysqli_stmt_bind_param($statement, "s", $room_code);
	mysqli_stmt_execute($statement);
	
	$statement = mysqli_prepare($con, "DELETE FROM Game WHERE room_code = ?");
	mysqli_stmt_bind_param($statement, "s", $room_code);
	mysqli_stmt_execute($statement);
	
	$statement = mysqli_prepare($con, "DELETE FROM Score WHERE room_code = ?");
	mysqli_stmt_bind_param($statement, "s", $room_code);
	mysqli_stmt_execute($statement);
	
	
	$result = mysqli_query($con,"INSERT INTO Game (host, room_status, room_code, player) 
      VALUES ('$host', '$room_status', '$room_code', '$player')");
		  
	$statement = mysqli_prepare($con, "SELECT * FROM Room WHERE room_code = ?");
    mysqli_stmt_bind_param($statement, "s", $room_code);
    mysqli_stmt_execute($statement);
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $room_id, $room_name, $user_id, $room_code, $question_id, $deploy_status, $time_left, $player_id, $num_pass, $question_status);
    
	$response = array(array(), array());
    $response["success"] = false;
    $i = 0;
    while(mysqli_stmt_fetch($statement)){
        $response[$i]["success"] = true;
		$response[$i]["question_id"] = $question_id;
		$statement1 = mysqli_prepare($con, "SELECT * FROM Bomb_Depository WHERE question_id = $question_id");
		mysqli_stmt_execute($statement1);
		mysqli_stmt_store_result($statement1);
		mysqli_stmt_bind_result($statement1, $question_id, $bomb_name, $question_type, $question, 
		$option_one, $option_two, $option_three, $option_four, $answer, $time_limit, $points_awarded,
		$points_deducted, $num_pass, $user_id);
		mysqli_stmt_fetch($statement1);
		$response[$i]["question_id"] = $question_id;
		$response[$i]["bomb_name"] = $bomb_name;
		$response[$i]["question_type"] = $question_type;
		$response[$i]["question"] = $question;
		$response[$i]["option_one"] = $option_one;
		$response[$i]["option_two"] = $option_two;
		$response[$i]["option_three"] = $option_three;
		$response[$i]["option_four"] = $option_four;
		$response[$i]["answer"] = $answer;
		$response[$i]["time_limit"] = $time_limit;
		$response[$i]["points_awarded"] = $points_awarded;
		$response[$i]["points_deducted"] = $points_deducted;
		$response[$i]["num_pass"] = $num_pass;
		$response[$i]["user_id"] = $user_id;
		$i++;
    }
	mysqli_close($con);
    echo json_encode($response);
?>