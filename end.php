<html>
	<head>
		<script src='starts.js'></script>
		<script src="../js/jquery-3.0.0.js"></script>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<link rel="shortcut icon" href="ico.ico">
		<title>Конец игры</title>
		<link rel="shortcut icon" href="//yastatic.net/morda-logo/i/ya_favicon_ru.png">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width"/>
	</head>
	<body class="game">
		<center>
			<h1>Конец игры</h1>
			<h2>
				Конечный текст:
			</h2>
			<div id='end'>
				Тут будет конечный текст.
			</div>
			<button class='red' onclick="go('index.html')">
				Выход
			</button>
		</center>
	<script>
				getAllText(<?php echo $_GET['game_id']; ?>);
				
				function getAllText(game_id){
					var params={game_id: game_id};
					callAPI('getAllText', params, function(result){
						console.log("4 result from getAllText", result);
						var html="<p>"+result.join("</p><p>")+"</p>";
						$('#end').html(html);			
					});
					
				}
		</script>
	</body>
</html>