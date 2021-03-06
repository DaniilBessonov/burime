<?php
include_once "connection.php";
$mysqli = null;

function b_register($login, $password){	
	global $mysqli;
	$query = "INSERT INTO `users`(`login`, `password`) VALUES ('$login', '$password')";
	$result = select_query($query);
	$id = mysqli_insert_id($mysqli);
	return $id;
}

function b_login($login, $password){
	$query="SELECT id FROM `users` WHERE login='$login' and password='$password'";
	$result = select_query($query);
	$num_rows = mysqli_num_rows($result);
	if($num_rows==0) {			
		return 0;
	} else {
		while ($row = mysqli_fetch_assoc($result)) {
			return $row["id"];				
		}	
		return 0;
	}
}

function disconnectDB(){
	global $mysqli;
	mysqli_close($mysqli);
}

function select_query($query){
	global $mysqli;
	return $mysqli->query($query);
}

function mysql_query_single($query){
	$result = select_query($query);
	while ($row = mysqli_fetch_array($result, MYSQLI_NUM)) {
		return $row[0];
	}
	return null;
}

function b_getUserNameById($id){
	$query="SELECT login FROM `users` WHERE id=$id";
	connectDB();
	$result = mysql_query_single($query);
	disconnectDB();
	return $result;
}

function getActiveUserName(){
	$id=getUserIdFromSession();
	$name=b_getUserNameById($id);
	return $name;
}

function b_addGame($topic, $players_count, $turns_count) {
	global $mysqli;
	$admin_id=getUserIdFromSession();
	$query="INSERT INTO `games`(`topic`, `admin_id`, `players_count`, `turns_count`) VALUES ('$topic', $admin_id, $players_count, $turns_count)";
	$result = select_query($query);
	$id = mysqli_insert_id($mysqli);
	return $id;
}

function b_addText($game_id, $text) {
	$user=getUserIdFromSession();
	$order_number=mysql_query_single("SELECT IFNULL(max(order_number),0)+1 FROM `stories` WHERE game_id=$game_id");
	$query="INSERT INTO `stories`(`game_id`, `text`,`user_id`,	`order_number`) VALUES ($game_id, '$text', $user, $order_number)";
	$result = select_query($query);	
}

function b_isUserInGame($game_id, $user_id) {
	$query="SELECT id FROM `orders` WHERE game_id=$game_id and user_id=$user_id";
	$result = mysql_query_single($query);
	return $result;
}

function b_getAdmin($game_id) {
	$query="SELECT admin_id FROM `games` WHERE id=$game_id";
	$result = mysql_query_single($query);
	$admin_name=b_getUserNameById($result);
	return $admin_name;
}

function b_getAdminId($game_id) {
	$query="SELECT admin_id FROM `games` WHERE id=$game_id";
	$result = mysql_query_single($query);
	return $result;
}

function b_isMeAdmin($game_id){
	$user_id=getUserIdFromSession();
	$admin_id=b_getAdminId($game_id);
	return $user_id==$admin_id;
}

function b_getMyGames($user_id) {
	error_log("b_getMyGames start", 0);
	$query="SELECT topic, id FROM `games` WHERE id in ( SELECT game_id FROM `orders` WHERE user_id=$user_id ) and finished=0";
	error_log("query=".$query, 0);
	$result = select_query($query);
	error_log("result ready", 0);
	$text=array();
	while($row = mysqli_fetch_assoc($result)) {
		array_push($text, array("id"=>$row["id"], "topic"=>$row["topic"]));
	}
	error_log("b_getMyGames finish", 0);
	return $text;
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
	$result = select_query($query);
}

function b_removePlayer($game_id, $user_id){
	$query="DELETE FROM `orders` WHERE user_id=$user_id and game_id=$game_id";
	$result = select_query($query);
	$query2="UPDATE `games` SET `players_count`=`players_count`-1  WHERE id=$game_id";
	$result2 = select_query($query2);
}

function b_getActiveUser($game_id) {
	$query="SELECT user_id FROM `orders` WHERE game_id=$game_id and turn_now=1";
	$result = mysql_query_single($query);
	return $result;
}

function b_getAllText($game_id){
	$query="SELECT text FROM `stories` WHERE game_id=$game_id order by order_number";
	$result = select_query($query);
	$text=array();
	while($res = mysqli_fetch_assoc($result)) {
		$text[] = $res['text'];
	}
	return $text;
}

function b_setGameFinished($game_id) {
	$query="UPDATE `games` SET `finished`= 1 WHERE id=$game_id";
	$result = select_query($query);
}

function b_setPlayersReady($game_id){
	$query="UPDATE `games` SET `players_ready`=1 WHERE id=$game_id";
	$result = select_query($query);
}

function b_isPlayersReady($game_id){
	$query="SELECT `players_ready` FROM `games` WHERE id=$game_id";
	$result = mysql_query_single($query);
	return $result==1;
}

function b_getActiveGames() {
	$games=array();
	$query="SELECT `games`.id, topic, login FROM `games` join `users` on admin_id=`users`.id WHERE finished=0 and players_ready=0";
	$result = select_query($query);
	while ($row = mysqli_fetch_assoc($result)) {
		 array_push($games, array("id"=>$row["id"], "topic"=>$row["topic"], "login"=>$row["login"]));				
	}
	return $games;
}

function b_getLastText($game_id) {
	$query="SELECT text FROM `stories` WHERE game_id=$game_id and order_number=(SELECT max(order_number) FROM `stories` Where game_id=$game_id)";
	$result = mysql_query_single($query);
	return $result;
}

function b_getOrder($game_id) {
	$query="SELECT login, turn_now, user_id FROM `orders` JOIN users AS u ON u.id=user_id WHERE game_id=$game_id ORDER BY order_number";
	$result = select_query($query);
	
	$table=array();
	while($row = mysqli_fetch_assoc($result)) {
		array_push( $table, array("login"=>$row["login"], "turn_now"=>$row["turn_now"], "user_id"=>$row["user_id"]) );
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
	$result1 = select_query($query1);
	
	$query="SELECT made_turns, user_id FROM `orders` WHERE game_id=$game_id ORDER BY order_number";
	$result = select_query($query);
	$min=1000;
	$user_id=0;
	while ($row = mysqli_fetch_assoc($result)) {
		$turn=$row["made_turns"];	
		if($turn<$min){
			$min=$turn;
			$user_id=$row["user_id"];
		}
	}
	
	$query2="UPDATE `orders` SET `turn_now`=1 WHERE game_id=$game_id and user_id=$user_id";
	$result2 = select_query($query2);
	
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