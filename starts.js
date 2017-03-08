function go(page) {
	document.location.href = page;
}

function callAPI(method, params, func){
		console.log("["+method+"] start",params);
		$.get("service.php", {method: method, params: JSON.stringify(params)}, function(data){
			var d=JSON.parse(data);
			console.log(method+" finished with result", d);
			if(d.result_type=='error'){
				showError(d.result);				
			} else {	
				if(func!=undefined) func(d.result);
			}		

			if(d.scenario==1 && !$('body').hasClass('login-page')) {
				go("login.html");
			}
			if(d.scenario==2) {
				go("turn.php?game_id="+d.result);
			}
			if(d.scenario==3) {
				go("end.php?game_id="+d.result);
			}	
		});
}

function showError(error){
	$('#errorText').html(error);
	$('#error').show(300);
}

window.onload = function() {
    addHeader();
  };
  
function addHeader(){
	$.get("header.php", undefined, function(result){
		$('body').append(result);
	});
}

function logout(){
callAPI('logout', undefined, function(){
	go('login.html');
});
}

function removePlayer(game_id) {
	var params={game_id:game_id};
	callAPI('removePlayer', params, function(){
	go('index.html');
	});
}