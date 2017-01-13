<?php 
include_once "validations.php";
session_start();
$_SESSION['isAuthorized']=1;
$_SESSION['userId']=8;
connectDB();

/*
if(b_login('Petiy1','123')!=8) {echo 'Error in login function<br>';};

if(b_register('Dabe','1')!=0) {echo 'Error in register function<br>';};

if(b_addGame('Game1', 5, 5)==null) {echo 'Error in addGame function<br>';};

if(b_addText(2, 'Text')) {echo 'Error in addText function<br>';};
*/

b_makeTurn(2);

echo 'Tests finished';
disconnectDB();
?>