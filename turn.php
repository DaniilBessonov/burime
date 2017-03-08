<html>
	<head>
		<script src='starts.js'></script>
		<script src="../js/jquery-3.0.0.js"></script>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="shortcut icon" href="ico.ico">
		<title>Ход игрока</title>
	</head>
	<body class="game">
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
			<br /><button class='red small' onclick="if(confirm('Сейчас идет игра. Вы действительно хотите выйти в главное меню?')){go('index.html')}">
				В главное меню
			</button>
		</center>
		<script>
				var game_id=<?php echo $_GET['game_id']; ?>;					
				
				getLastText(game_id);
				
				function getLastText(game_id){
					var params={game_id:game_id};
					callAPI('getLastText', params, function(result){
						if(result==null){
							$('#lastText').html('Текст отсутствует, так как вы ходите первым.');
						} else {
							$('#lastText').html(result);
						}
					});
				}
				
				function addText(text) {
					var params={game_id:game_id, text:text};
					callAPI('addText', params, function(result){						
						go("wait.php?game_id="+game_id);						
					});
				}
		</script>
	</body>
</html>