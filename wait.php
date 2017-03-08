<html>
	<?php
	include_once "validations.php";
	session_start();
	
	if(isset($_GET['game_id'])) { 
		$game_id = $_GET['game_id']; 
	} else {
		header('Location: index.html');
	}
	
	$user_id=getUserIdFromSession();
	connectDB();				
	$isUserInGame=b_isUserInGame($game_id, $user_id)==NULL;
	disconnectDB();
	?>
	<head>
		<script src='starts.js'></script>
		<script src="/js/jquery-3.0.0.js"></script>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width"/>
		<link rel="shortcut icon" href="ico.ico">
		<title>Ожидание</title>
		<?php 
			connectDB();
			if(b_isMeAdmin($game_id)){
			 echo "<style>	.forAdmin { display: block; } </style>";
			}
			disconnectDB();
		?>
	</head>
	<body>
		<center>
			<h1>Ожидание</h1>
			<!--<h2>
				Здесь игроки ожидают начала игры или своего хода...
			</h2>-->
				<?php				
				if(!$isUserInGame) {
					echo '<p id="userInGame" class="small" style="color:#9ACD32">Вы в игре</p><br />';
				}				
				?>
			<table id="order"></table>
			<div id="interaction">
				<?php				
				if($isUserInGame) {
					echo '<button id="intoGame" class="green" class="goAway" onclick="addPlayer(game_id)">Вступить в игру</button>';
				} else {
					echo '<button class="exitFromGame" style="margin-top:60px" onclick="removePlayerHimself()">Покинуть игру</button>'; 
				}				
				?>
			</div>
			<br /><button class="red small" onclick="if(confirm('Сейчас идет игра. Вы действительно хотите выйти в главное меню?')){go('index.html')}">
				В главное меню
			</button>
			
		</center>
		<script>
			var game_id=<?php echo $game_id; ?>;		
			time();
			
			function getOrder(game_id) {
				var params={game_id:game_id};
				callAPI('getOrder', params, function(result){
							console.log("result from getOrder", result);
							$('#order').children().remove();
							for (var i=0; i<result.length; i++){
								var html = result[i].login;
								if(result[i].turn_now==1) {
									html = '<b>'+html+'</b>';
								} 
								$('#order').append('<tr><td>'+html+'</td><td><button class="deletePlayer red forAdmin" onclick="deletePlayer('+result[i].user_id+')">Удалить игрока</button></td></tr>');
							}	
							
							isUserInGame(result);							
				});
			}
			
			function isUserInGame(result){
				var my_id=<?php echo getUserIdFromSession(); ?>;
				for(var i=0; i<result.length; i++) {
					if(my_id==result[i].user_id){
						return;
					}
				}
				
				$('#userInGame').remove();
				showError('Вы были удалены из игры администратором игры. Перейдите в главное меню.');
			}
			
			function time() {				
				getOrder(game_id);
				setTimeout(time, 5000);
			}
			
			function addPlayer(game_id){
				var params={game_id: game_id};
				callAPI('addPlayer', params, function(result){
					alert(result);
					$('#intoGame').css('display', 'none');
				});
				$('#interaction').html('<p class="small" style="color:#9ACD32">Вы в игре</p><br /><button class="exitFromGame" onclick="removePlayer(game_id)">Покинуть игру</button>');
			}
			
			function deletePlayer(user_id) {
				if(confirm('Вы действительно хотите удалить этого игрока из игры?')){
					var params={user_id:user_id, game_id:game_id};
					callAPI('removePlayer', params);
				}
			}
			
			function removePlayerHimself() {
				if(confirm('Вы действительно хотите выйти из игры?')){
					var params={game_id:game_id};
					callAPI('removePlayerHimself', params, function() {
						go('index.html');
					});
				}
			}
		</script>
	</body>
</html>