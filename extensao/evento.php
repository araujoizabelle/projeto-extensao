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
	    		//var servicoId = ;
	    		var servico = "controller/evento_ctrl.php?act=get&id="+<?php echo $evento_id; ?>;
	    		
	    		//var params = {"act": "get", "id":+servicoId+"}";//
	    		$xhr = $.get(servico);
	    		$xhr.done(function(data){
	    			console.log(data);
	    			var evento = JSON.parse(data);
	    			console.log(evento);
	    			$(".evento")
	    				.append($("<h1 />").text(evento.nome))
	    				.append($("<p />").text("Tipo do evento: " + evento.tipo))
	    				.append($("<p />").text("Autor: " + evento.autor))
	    				.append($("<p />").text("Bio do autor: " + evento.autor_bio))
	    				.append($("<p />").text("Descrição: " + evento.descricao))
	    				.append($("<ul />")
	    					.append($("<li />").text(evento.horarios[0].data_inicio))
	    					.append($("<li />").text(evento.horarios[0].data_termino))
	    				)
	    				.append($("<img />").attr("src", evento.foto));
	    		});

	    	})
	    </script>
	</head>
	<body>
		<div class="evento">
		</div>
		
	</body>
</html>