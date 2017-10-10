
<!doctype html>
<html>
<head>
	<title>3</title>
	<meta charset="utf-8" />
    <title>Evento</title>
    <link rel="stylesheet" href="./css/reset.css" />
    <script src="./js/jquery.min.js"></script>
    <link rel="stylesheet" type="text/css" href="./js/plugins/message-plugin.css" />

    <script src="./js/jquery.min.js"></script>
    <script src="./js/plugins/message-plugin.js"></script>

    <script>
		function getUrlVars() {
		    var vars = [], hash;
		    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
		    for(var i = 0; i < hashes.length; i++) {
		      hash = hashes[i].split('=');
		      vars.push(hash[0]);
		      vars[hash[0]] = hash[1];
		    }
		    return vars;
		  }

		  
	    $(function(){
			var vars = getUrlVars();

			if (vars["msg"]=="conflitoHorario") {
				$(".message")
		      		.message({message:"Conflito de horários. Por favor, confira sua grade de horários.", class:"danger"});
		  	} 
	    });
	</script>
</head>
<body>
	<div class="message"></div>
</body>
</html>