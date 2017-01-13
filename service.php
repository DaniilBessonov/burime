<?php 
include_once "validations.php";
$method = $_GET['method'];

session_start();
if ((isset($_SESSION['isAuthorized']) && $_SESSION['isAuthorized']==1) || $method=='login' || $method=='register') {
	connectDB();
	
	if(isset($_GET['params'])){
		$jsonParams = $_GET['params'];
		$params = json_decode($jsonParams);
		$result = $method($params);		
	} else {
		$result = $method();
	}
	
	disconnectDB();
} else {
	$result=wrong('Необходимо авторизоваться', 1);
  // redirect to login page header('Location: http://www.example.com/');
}
echo json_encode($result);


?>