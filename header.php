<?php 
include_once "validations.php";
session_start(); 
?>
<div id="error" onclick="$(this).hide(300)" style="display:none">
			<center>
				<h2>Ошибка!</h2>
				<p id="errorText">Ля ля ля. Все очень плохо</p>
				<p class="small">Нажмите на сообщение, чтобы скрыть его</p>
			</center>
		</div>
		<div id="loginPassword">
			<center>								
				<?php 
				if(isset($_SESSION['isAuthorized']) && $_SESSION['isAuthorized']==1){
					echo '<p>'.getActiveUserName().'</p>';
					echo '<button class="button logOrReg" onclick="logout()">Выйти</button>';
				} else {
					echo '<button class="button logOrReg" onclick="go(\'register.html\')">Зарегестрироваться</button>';
					echo '<button class="button logOrReg" onclick="go(\'login.html\')">Войти</button>';
				}
				?>
			</center>
		</div>