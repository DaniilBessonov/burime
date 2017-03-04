<?php 
include_once "validations.php";
session_start(); 
?>
		<div id="loginPassword">
			<center class="comp">								
				<?php 
				if(isset($_SESSION['isAuthorized']) && $_SESSION['isAuthorized']==1){
					echo '<button class="logOrReg">'.getActiveUserName().'</button>';
					echo '<button class="logOrReg" onclick="logout()">Выйти</button>';
				} else {
					echo '<button class="logOrReg" onclick="go(\'register.html\')">Зарегестрироваться</button>';
					echo '<button class="logOrReg" onclick="go(\'login.html\')">Войти</button>';
				}
				?>
			</center>
		</div>
		<div id="error" onclick="$(this).hide(300)" style="display:none">
			<center>
				<h2>Ошибка!</h2>
				<p id="errorText">Ля ля ля. Все очень плохо</p>
				<p class="small">Нажмите на сообщение, чтобы скрыть его</p>
			</center>
		</div>