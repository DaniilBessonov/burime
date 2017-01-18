<?php
$db_link = null;

function b_register($login, $password){	
	$query = "INSERT INTO `users`(`login`, `password`) VALUES ('$login', '$password')";
	$result = mysql_query($query);
	$id = mysql_insert_id();
	return $id;
}

function b_login($login, $password){
	$query="SELECT id FROM `users` WHERE login='$login' and password='$password'";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if($num_rows==0) {			
		return 0;
	} else {
		while ($row = mysql_fetch_assoc($result)) {
			return $row["id"];				
		}	
		return 0;
	}
}

function connectDB() {
	global $db_link;
	$db_link = mysql_connect('localhost', 'root', '');
	mysql_select_db('burime', $db_link);	
}

function disconnectDB(){
	global $db_link;
	mysql_close($db_link);
}

function mysql_query_single($query){
	$result = mysql_query($query);
	while ($row = mysql_fetch_array($result, MYSQL_NUM)) {
		return $row[0];
	}
	return null;
}

function b_addGame($topic, $players_count, $turns_count) {
	$admin_id=getUserIdFromSession();
	$query="INSERT INTO `games`(`topic`, `admin_id`, `players_count`, `turns_count`) VALUES ('$topic', $admin_id, $players_count, $turns_count)";
	$result = mysql_query($query);
	$id = mysql_insert_id();
	return $id;
}

function b_addText($game_id, $text) {
	$user=getUserIdFromSession();
	$order_number=mysql_query_single("SELECT IFNULL(max(order_number),0)+1 FROM `stories` WHERE game_id=$game_id");
	$query="INSERT INTO `stories`(`game_id`, `text`,`user_id`, `order_number`) VALUES ($game_id, '$text', $user, $order_number)";
	$result = mysql_query($query);	
}

function getUserIdFromSession(){	
	$userId=$_SESSION['userId'];
	return $userId; 
}

function b_addPlayer($game_id, $user_id){
	$order_number=mysql_query_single("SELECT IFNULL(max(order_number),0)+1 FROM `orders` WHERE game_id=$game_id");
	$turn_now=0;
	if($order_number==1) $turn_now=1;
	$query="INSERT INTO `orders`(`game_id`, `user_id`, `turn_now`, `order_number`) VALUES ($game_id, $user_id, $turn_now, $order_number)";
	$result = mysql_query($query);
}

function b_removePlayer($game_id, $user_id){
	$query="DELETE FROM `orders` WHERE user_id=$user_id and game_id=$game_id";
	$result = mysql_query($query);
}

function b_getActiveUser($game_id) {
	$query="SELECT user_id FROM `orders` WHERE game_id=$game_id and turn_now=1";
	$result = mysql_query_single($query);
	return $result;
}

function b_getAllText($game_id){
	$query="SELECT text FROM `stories` WHERE game_id=$game_id order by order_number";
	$result = mysql_query($query);
	$text=array();
	while($res = mysql_fetch_assoc($result)) {
		$text[] = $res['text'];
	}
	return $text;
}

function b_setGameFinished($game_id) {
	$query="UPDATE `games` SET `finished`= 1 WHERE id=$game_id";
	$result = mysql_query($query);
}

function b_setPlayersReady($game_id){
	$query="UPDATE `games` SET `players_ready`=1 WHERE id=$game_id";
	$result = mysql_query($query);
}

function b_isPlayersReady($game_id){
	$query="SELECT `players_ready` FROM `games` WHERE id=$game_id";
	$result = mysql_query_single($query);
	return $result==1;
}

function b_getActiveGames() {
	$games=array();
	$query="SELECT id, topic FROM `games` WHERE finished=0 and players_ready=0";
	$result = mysql_query($query);
	while ($row = mysql_fetch_assoc($result)) {
		 array_push($games, array("id"=>$row["id"], "topic"=>$row["topic"]));				
	}
	return $games;
}

function b_getLastText($game_id) {
	$query="SELECT text FROM `stories` WHERE game_id=$game_id and order_number=(SELECT max(order_number) FROM `stories` Where game_id=$game_id)";
	$result = mysql_query_single($query);
	return $result;
}

function b_getOrder($game_id) {
	$query="SELECT login, turn_now FROM `orders` JOIN users AS u ON u.id=user_id WHERE game_id=$game_id ORDER BY order_number";
	$result = mysql_query($query);
	
	$table=array();
	while($row = mysql_fetch_assoc($result)) {
		array_push( $table, array("login"=>$row["login"], "turn_now"=>$row["turn_now"]) );
	}
	
	return $table;
}

function b_isUserActive($game_id, $user_id) {
	$query="SELECT turn_now FROM `orders` WHERE game_id=$game_id and user_id=$user_id";
	$result = mysql_query_single($query);
	if ($result==0){
		return false;
	} else {
		return true;
	}
}

function b_isGameFinished($game_id) {
	$query="SELECT finished FROM `games` WHERE id=$game_id";
	$result = mysql_query_single($query);
	return $result!=0;
}

function b_getGameTurnCount($game_id) {
	$query="SELECT `turns_count` FROM `games` WHERE id=$game_id";
	return mysql_query_single($query);
}

function b_makeTurn($game_id) {
	$query1="UPDATE `orders` SET `made_turns`=made_turns+1,`turn_now`=0 WHERE game_id=$game_id and `turn_now`=1";
	$result1 = mysql_query($query1);
	
	$query="SELECT made_turns, user_id FROM `orders` WHERE game_id=$game_id ORDER BY order_number";
	$result = mysql_query($query);
	$min=999; // TODO поставить ограничение на максимальное кол-во ходов
	$user_id=0;
	while ($row = mysql_fetch_assoc($result)) {
		$turn=$row["made_turns"];	
		if($turn<$min){
			$min=$turn;
			$user_id=$row["user_id"];
		}
	}
	
	$query2="UPDATE `orders` SET `turn_now`=1 WHERE game_id=$game_id and user_id=$user_id";
	$result2 = mysql_query($query2);
	
	return $min;
}

function b_isQuorum($game_id){
	$query="SELECT`players_count` FROM `games` WHERE id=$game_id";
	$players_count = mysql_query_single($query);	
	
	$query2="SELECT count(`id`) FROM `orders` WHERE game_id=$game_id";
	$players_ready = mysql_query_single($query2);
	
	return $players_count==$players_ready;	
}
?>