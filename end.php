<html>
	<head>
		<script src='starts.js'></script>
		<script src="../js/jquery-3.0.0.js"></script>
		<link rel="stylesheet" type="text/css" href="css/styles.css">
		<title>����� ����</title>
		<link rel="shortcut icon" href="//yastatic.net/morda-logo/i/ya_favicon_ru.png">
		<style>

		</style>
	</head>
	<body class="game">
		<center>
			<h1>����� ����</h1>
			<h2>
				�������� �����:
			</h2>
			<div id='end'>
				��� ����� �������� �����.
			</div>
			<button class='red' onclick="go('index.html')">
				�����
			</button>
		</center>
	<script>
				getAllText(<?php echo $_GET['game_id']; ?>);
				
				function getAllText(game_id){
					var params={game_id: game_id};
					callAPI('getAllText', params, function(result){
						console.log("4 result from getAllText", result);
						var html="<p>"+result.join("</p><p>")+"</p>";
						//console.log(html);
						$('#end').html(html);			
					});
					
				}
		</script>
	</body>
</html>