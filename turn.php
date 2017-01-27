<html>
	<head>
		<script src='starts.js'></script>
		<script src="../js/jquery-3.0.0.js"></script>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<title>Ход игрока</title>
		<style>
		</style>
	</head>
	<body>
		<center>
			<h1>Сейчас ваш ход</h1>
			<h2>
				Последняя строка:
			</h2>
			<p id='lastText'>
				В этот уникальный абзац записывается последняя строка.
			</p>
			<input placeholder="Ваше продолжение..."></input>	
			<br /><button class='green' onclick="addText($('input').val())">
				Сделать ход
			</button>
			<button class='red' class='goAway' onclick="go('index.html')">
				Назад
			</button>
		</center>
		<script>
				var game_id=<?php $_GET['game_id'] ?>;					
				
				getLastText();
				
				function getLastText(game_id){
					var params={game_id:game_id};
					callAPI('getLastText', params, function(result){
						$('#lastText').html(result.text);
					});
				}
				
				function addText(text) {
					var params={game_id:game_id, text:text};
					callAPI('addText', params, function(result){
						console.log("addText: ", result);
						//go("wait.php?game_id="+game_id);
						// TODO Тут нужно перенаправить игрока обратно в зал ожидания, но мой вариант вряд ли правильный.
					});
				}
		</script>
	</body>
</html>