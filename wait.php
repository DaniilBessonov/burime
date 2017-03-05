<html>
	<?php
	include_once "validations.php";
	session_start();
	
	if(isset($_GET['game_id'])) { 
		$game_id = $_GET['game_id']; 
	} else {
		header('Location: index.html');
	}
	?>
	<head>
		<script src='starts.js'></script>
		<script src="../js/jquery-3.0.0.js"></script>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width"/>
		<title>Ожидание</title>
		<?php 
			connectDB();
			if(b_isMeAdmin($game_id)){
			 echo "<style>	.forAdmin { display: block; } </style>";
			}
			disconnectDB();
		?>
	</head>
	<body class="game">
		<!-- Версия для любого экрана -->
		<center>
			<h1>Ожидание</h1>
			<h2>
				Ожидайте своего хода...
			</h2>
			<table id="order"></table>
			<div id="interaction">
				<?php
				
				// TODO не добавляет надпись "Вы уже в игре" при заходе на страницу
				
				//$game_id=$_GET['game_id'];
				$user_id=getUserIdFromSession();
				
				connectDB();
				
				if(b_isUserInGame($game_id, $user_id)==NULL) {
					echo '<button id="intoGame" class="green" class="goAway" onclick="addPlayer(game_id)">Вступить в игру</button>';
				} else {
					echo '<p class="small" style="color:#9ACD32">Вы в игре</p><br /><button class="exitFromGame" onclick="removePlayerHimself()">Покинуть игру</button>'; //Почему не рабоатет?
				}
				
				disconnectDB();
				
				?>
				<!--<button id="intoGame" class='green' class='goAway' onclick="addPlayer(game_id)">
					Вступить в игру
				</button> -->
			</div>
			<br /><button class="red small" onclick="if(confirm('Сейчас идет игра. Вы действительно хотите выйти в главное меню?')){go('index.html')}">
				В главное меню
			</button>
			
		</center>
		<script>
			var game_id=<?php echo $game_id; ?>;					
			time();
			
			function getOrder(game_id) {
				console.log("game_id=", game_id);
				var params={game_id:game_id};
				callAPI('getOrder', params, function(result){
							console.log("result from getOrder", result);
							//преобразование result в массив
							$('#order').children().remove();
							for (var i=0; i<result.length; i++){
								var html = result[i].login;
								if(result[i].turn_now==1) {
									html = '<b>'+html+'</b>';
								} 
								$('#order').append('<tr><td>'+html+'</td><td><button class="deletePlayer red forAdmin" onclick="deletePlayer('+result[i].user_id+')">Удалить игрока</button></td></tr>');
							}	
				});
			}
			
			function time() {				
				getOrder(game_id);
				setTimeout(time, 5000);
			}
			
			function addPlayer(game_id){
				console.log("game_id=", game_id);
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