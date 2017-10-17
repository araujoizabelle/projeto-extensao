<?php
/*
	session_start();

    if($_SESSION['usuarioId']== null){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        unset($_SESSION['nome']);
        header('location:index.html');
    }

	$evento_id = $_GET["id"];
*/
?>
<!-- Essa página será preenchida com dados de cada evento! -->
<!doctype html>
<html lang="pt-BR">
<head>
	<meta charset="utf-8" />
	<title>Eventos</title>
	<link rel="stylesheet" type="text/css" href="./css/tipo_evento/evento.css">
	<link rel="stylesheet" type="text/css" id="folha"/> <!--Aqui será colocada a folha de estilo do evento específico-->
	<link rel="stylesheet" href="./css/font-awesome-4.7.0/css/font-awesome.min.css">
   <link href="https://fonts.googleapis.com/css?family=Monda:700" rel="stylesheet">

	<script src="./js/jquery.min.js"></script>
	<script>

		function setFolha(tipoEvento) {
			if(tipoEvento == "Palestras") 
				$("#folha").attr("href", "./css/tipo_evento/palestra.css");
			else if(tipoEvento == "Minicurso")
				$("#folha").attr("href", "./css/tipo_evento/minicurso.css");
			else if(tipoEvento == "Mesa Redonda")
				$("#folha").attr("href", "./css/tipo_evento/mesaredonda.css");
			else if(tipoEvento == "EXPOSUP")
				$("#folha").attr("href", "./css/tipo_evento/exposup.css");
			else if(tipoEvento == "EXPOTEC")
				$("#folha").attr("href", "./css/tipo_evento/expotec.css");
			else 
				$("#folha").attr("href", "./css/tipo_evento/outros.css");
		}

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
					//console.log(evento);
					//configurando folha de estilo
					//setFolha(evento.tipo);
					$(".tipo_evento h3").text(evento.tipo);
					$(".info_evento h2").text(evento.nome);
					$(".info_evento h3").text(evento.horarios[0].sala);
					$(".description p").text(evento.descricao);

					$.each(evento.autores, function(ind, autor){
						console.log("foto do autor: ");
						console.log(autor.foto);
						var foto = (autor.foto!="")?autor.foto:"./img/perfilpadrao.jpg";
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
		<img src="./img/logo_extensao.png" alt="Logo"/>
		<p><?php echo $_SESSION["nome"];?></p>
		<button class="logout">Sair</button>
	</header>
	<main class="main">
		<section class="evento">
            <div class="tipo_evento">
                <h3><!---tipo do evento--></h3>
            </div>
		  <div class="info_evento">
			<h2>NOME</h2>
			<h3>SALA</h3>
            <div class="buttonInscrever"><p>Inscrever-se</p></div>
		  </div>
        </section>

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
-->
	</main>
</body>
</html>
