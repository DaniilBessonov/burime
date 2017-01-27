//Функция для обращения к PHP

function go(page) {
	document.location.href = page;
}



function callAPI(method, params, func){
	console.log("callAPI start",params);
		$.get("service.php", {method: method, params: JSON.stringify(params)}, function(data){
			console.log(data);
			var d=JSON.parse(data);
			console.log("callAPI finished with result", d);
			if(d.result_type=='error'){
				alert(d.result);				
			} else {	
				console.log("3 result from callAPI", d.result);
				if(func!=undefined) func(d.result);
			}		

				if(d.scenario==1) {
					go("login.html");
				}
				if(d.scenario==2) {
					go("turn.html");
				}			
		});
}