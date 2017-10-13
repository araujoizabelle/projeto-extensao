<?php

	session_start();

    if($_SESSION['usuarioId']== null){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('location:index.html');
    }

	$evento_id = $_GET["id"];

?>
<!-- Essa página será preenchida com dados de cada evento! -->
<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8" />
	<title>Eventos</title>
	
	<link rel="stylesheet" type="text/css" href="./css/tipo_evento/evento.css">
	<link rel="stylesheet" type="text/css" href="./css/tipo_evento/#.css"><!-- Aqui será colocada a folha de estilo do evento específico-->
	<link rel="stylesheet" href="./css/font-awesome-4.7.0/css/font-awesome.min.css">
	<script src="./js/jquery.min.js"></script>
	<script>
		$(function(){
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

			var vars = getUrlVars();

			if (vars["act"]=="get") {
				var evento_id = vars["id"];
				$.get("./controller/evento_ctrl.php?act=get&id="+evento_id).done(function(data){
					var evento = JSON.parse(data);
					console.log(evento);
					$(".evento h3:first-child").text(evento.tipo);
					$(".evento h2").text(evento.nome);
					$(".evento h3:last-child").text(evento.horarios[0].sala);
					$(".description p").text(evento.descricao);

					$.each(evento.autores, function(ind, autor){
						var foto = (autor.foto!=null)?autor.foto:"./img/perfilpadrao.jpg";
						$("main")
							.append($("<section />")
								.addClass("palestrante")
								.append($("<img />")
									.attr({"src": foto, "alt": "Foto do participante "+autor.nome}))
								.append($("<article />").addClass("bioPalestrante")
									.append($("<h3/>").text(autor.nome))
									.append($("<p/>").text(autor.bio))
									.append($("<h4/>").text(autor.lattes))
								)
							);
					});
				});	
			} 
		})
	</script>
</head>
<body>
	<header class="cabecalho">
		<h1>CEFET/RJ Nova Friburgo</h1>
		<h1>Semana de Extensão 2017</h1>
		<p><?php echo $_SESSION["nome"];?></p>
		<button class="logout">Sair</button>
	</header>
	<main class="main">
		<section class="evento">
			<h3></h3>
			<h2></h2>
			<h3>Sala 19</h3>
		</section>
		<div class="description">
			<p></p>
			<div class="buttonInscrever"><p>Inscrever-se</p></div>
		</div>
<!--
		<section class="palestrante">
			<img src="./img/perfilpadrao.jpg" alt="Foto do palestrante">
			<article class="bioPalestrante">
				<h3>Ciclano</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat.</p><br/>
				<h4><i class="fa fa-envelope-open-o" aria-hidden="true"></i> palestrante@email.com</h4>
				<i class="fa fa-phone" aria-hidden="true"></i> (00) 0 0000-0000</h4>
			</article>
		</section>
		<section class="palestrante">
			<img src="./img/perfilpadrao.jpg" alt="Foto do palestrante">
			<article class="bioPalestrante">
				<h3>Ciclano</h3>
				<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
				tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
				quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
				consequat.</p><br/>
				<h4><i class="fa fa-envelope-open-o" aria-hidden="true"></i> palestrante@email.com</h4>
				<i class="fa fa-phone" aria-hidden="true"></i> (00) 0 0000-0000</h4>
			</article>
		</section>
-->
	</main>
</body>
</html>
