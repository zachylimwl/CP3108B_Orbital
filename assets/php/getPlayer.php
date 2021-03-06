<?php
    $con = mysqli_connect("orbitalbombsquad.x10host.com", "orbital2", "h3llo world", "orbital2_bombsquad");
    
    $room_code = mysqli_real_escape_string($con, $_POST["room_code"]);
    
    $statement = mysqli_prepare($con, "SELECT * FROM Game WHERE room_code = ?");
    mysqli_stmt_bind_param($statement, "s", $room_code);
    mysqli_stmt_execute($statement);
    
    mysqli_stmt_store_result($statement);
    mysqli_stmt_bind_result($statement, $game_id, $host, $room_status, $room_code, $player);
    
    $response = array(array(), array());
    $response["success"] = false;  
    
    $i = 0;
    while(mysqli_stmt_fetch($statement)){
        $response[$i]["success"] = true;
		$response[$i]["player"] = $player;
		$statement1 = mysqli_prepare($con, "SELECT * FROM user WHERE user_id = $player");
		mysqli_stmt_execute($statement1);
		mysqli_stmt_store_result($statement1);
		mysqli_stmt_bind_result($statement1, $user_id, $first_name, $last_name, $email, $mobile_no, $username, $password);
		mysqli_stmt_fetch($statement1);
		$response[$i]["first_name"] = $first_name;
		$response[$i]["last_name"] = $last_name;
		$i++;
    }
    mysqli_close($con);
	echo json_encode($response);
?>