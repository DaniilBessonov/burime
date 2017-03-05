<?php

function connectDB() {
	global $mysqli;
	$mysqli = new mysqli('localhost', 'root', '', 'burime'); /* адрес, логи, пароль */
}

?>