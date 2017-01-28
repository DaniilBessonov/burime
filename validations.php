<?php
include_once "burime.php";

function success($param, $scenario = 0){
	return array('result_type'=>'success', 'result'=>$param, 'scenario'=>$scenario);
}
function wrong($param, $scenario = 0){
	return array('result_type'=>'error', 'result'=>$param, 'scenario'=>$scenario);
}

function login($params){
	$login=$params->login;
	$password=$params->password;	
	$userId=b_login($login, $password);
	if( $userId==0){
		$_SESSION['isAuthorized']=0;
		$_SESSION['userId']=0;
		return wrong('Авторизация не удалась', 1);
	}else{		
		$_SESSION['isAuthorized']=1;
		$_SESSION['userId']=$userId;
		return success('Авторизация удалась');
	};
}



function register($params){
	$login=$params->login;
	$password=$params->password;
	
	if(isLoginExist($login)){
		return wrong('Логин занят. Регистрация не удалась.');
	} else {
		$userId=b_register($login, $password);
		$_SESSION['isAuthorized']=1;
		$_SESSION['userId']=$userId;
		return success($userId);		
	}
}

function logout(){
	$_SESSION['isAuthorized']=0;
	$_SESSION['userId']=0;
	return success('Вы вышли из аккаунта');
}

function isLoginExist($login){
	$query = "SELECT * FROM `users` WHERE login='$login'";	
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if($num_rows==0) {
		return false;
	} else{
		return true;
	}
}

function addGame($params) {
	$topic=$params->topic;
	$players_count=$params->players_count;
	$turns_count=$params->turns_count;
	$user_id=getUserIdFromSession();

	$game_id=b_addGame($topic, $players_count, $turns_count);
	b_addPlayer($game_id, $user_id);
	
	return success($game_id);
}

function addText($params) {
	$game_id=$params->game_id;
	$text=$params->text;
	$user_id=getUserIdFromSession();
	
	if(!b_isUserActive($game_id, $user_id)) {
		return wrong('Сейчас не ваш ход.');
	} 
	if(b_isGameFinished($game_id)) {
		return wrong('Данная игра уже закончалась.');
	}
	b_addText($game_id, $text);	
	
	$minMadeTurns=b_makeTurn($game_id);
	if($minMadeTurns==b_getGameTurnCount($game_id)) {
		b_setGameFinished($game_id);
		return success($game_id, 3);
	}	
	return success('Ход сделан');
}

function addPlayer($params) {
	$game_id=$params->game_id;
	$user_id=getUserIdFromSession();
	
	$query="SELECT `user_id` FROM `orders` WHERE game_id=$game_id and user_id=$user_id";
	$result = mysql_query($query);
	$num_rows = mysql_num_rows($result);
	if($num_rows==0 && !b_isPlayersReady($game_id)){	
		b_addPlayer ($game_id, $user_id);
		
		if(b_isQuorum($game_id)){
			b_setPlayersReady($game_id);
		}
		return success('Вы добавлены в игру');
	} else {
		return wrong('Пользователь уже в игре');
	}
}

function removePlayer($params) {
	$game_id=$params->game_id;
	$user_id=getUserIdFromSession();
	b_removePlayer($game_id, $user_id);
	return success('Пользователь удален из игры');
}

function getActiveUser($params) {
	$game_id=$params->game_id;		
	return success(b_getActiveUser($game_id));
}

function getAllText($params) {
	$game_id=$params->game_id;
	
	$query="SELECT finished FROM `games` WHERE id=$game_id";
	if(mysql_query_single($query)==1) {
		return success(b_getAllText($game_id));
	} else {
		return wrong('Игра еще не закончена');
	}
}

function getActiveGames() {
	return success(b_getActiveGames());
}

function getLastText($params) {
	$game_id=$params->game_id;
	$user_id=getUserIdFromSession();
	if(b_isUserActive($game_id, $user_id)) {	
		return success(b_getLastText($game_id));
	} else {
		return wrong('Вы можете посмотреть текст только во время своего хода.');
	}
}

function getOrder($params){
	$game_id=$params->game_id;
	if(is_numeric($game_id)){	
		$user_id=getUserIdFromSession();
		if(b_isGameFinished($game_id)){
			return success($game_id, 3);
		}
		if(b_isUserActive($game_id, $user_id) && b_isPlayersReady($game_id)){
			return success($game_id, 2);
		}	
		return success(b_getOrder($game_id));
	} else {
		return wrong('Неверный game_id');
	}
}

function isUserActive($params) {
	$game_id=$params->game_id;
	$user_id=$params->user_id;
	
	//validations
	
	return b_isUserActive($game_id, $user_id);
}

function isGameFinished($params){
	$game_id=$params->game_id;
	
	//validations
	
	return b_isGameFinished($game_id);
}

?>