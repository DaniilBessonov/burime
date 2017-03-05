<?php

function connectDB() {
	global $mysqli;
	$mysqli = new mysqli('mysql.hostinger.ru', 'u207447124_burim', 'd21c2lx7', 'u207447124_burim'); /* адрес, логи, пароль */
}

?>