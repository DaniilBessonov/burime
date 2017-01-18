<html>
	<head>
		<script src='starts.js'></script>
		<script src="../js/jquery-3.0.0.js"></script>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<title>Ожидание</title>
		<style>

		</style>
	</head>
	<body>
		<center>
			<h1>Ожидание</h1>
			<h2>
				Ожидайте своего хода...
			</h2>
			<table id="order"></table>
		
			<button id="intoGame" class='green' class='goAway' onclick="addPlayer(game_id)">
				Вступить в игру
			</button>
			<br /><button class='red' class='goAway' onclick="go('index.html')">
				В главное меню
			</button>
		</center>
		<script>
			var game_id=<?php if(isset($_GET['game_id'])) { 
								echo $_GET['game_id']; 
							} else {
								header('Location: index.html');
							}
				?>;					
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
								$('#order').append('<tr><td>'+html+'</td></tr>');
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
			}
		</script>
	</body>
</html>