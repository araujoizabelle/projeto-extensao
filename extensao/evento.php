<?php

	session_start();

    if($_SESSION['usuarioId']== null){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('location:index.html');
    }

	$evento_id = $_GET["id"];

?>
<!doctype html>
<html>
<html>
	<head>
		<meta charset="utf-8" />
	    <title>Evento</title>
	    <link rel="stylesheet" href="./css/reset.css" />
	    <script src="./js/jquery.min.js"></script>
	    <script>

	    	$(function(){

  				var vars = getUrlVars();
				
				var servico = "controller/evento_ctrl.php";

  				if (vars["act"]=="get") {
  					var params = {act:"get", evento_id: vars["evento_id"]};
		    		var servico = "./controller/calendario_ctrl.php";

		    		var $xhr = $.get(servico, params);
		    		$xhr.done(function(data){
		    			console.log(data);
		    			var evento = JSON.parse(data);
		    			console.log(evento);
		    			$(".evento")
		    				.append($("<h1 />").text(evento.evento_nome))
		    				.append($("<p />").text("Tipo do evento: " + evento.evento_tipo))
		    				.append($("<p />").text("Autor: " + evento.evento_autores.toString()))
		    				//.append($("<p />").text("Bio do autor: " + evento.autor_bio))
		    				.append($("<p />").text("Descrição: " + evento.evento_descricao))
		    				.append($("<ul />") //@TODO substituir por um foreach
		    					.append($("<li />").text(evento.horarios[0].data_inicio))
		    					.append($("<li />").text(evento.horarios[0].data_termino))
		    				)
		    				.append($("<img />").attr("src", evento.foto));
		    		});
		    	} 

	    	});

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
	    </script>
	</head>
	<body>
		<div class="evento">
		</div>
		<a href="calendario.php">Voltar</a>
	</body>
</html>