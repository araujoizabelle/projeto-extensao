<?php

	session_start();
/*
    if($_SESSION['usuarioId']== null){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        unset($_SESSION['nome']);
        header('location:index.html');
    }
*/
	$evento_id = $_GET["id"];

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

	<link rel="stylesheet" type="text/css" href="./js/bootstrap.min.css"/>

   <link href="https://fonts.googleapis.com/css?family=Monda:700" rel="stylesheet">

	<script src="./js/jquery.min.js"></script>
	<script src="./js/bootstrap.min.js"></script>
	<script>
		function setFolha(tipoEvento) {
			if(tipoEvento == "Palestra") 
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
					//configurando folha de estilo
					setFolha(evento.tipo);
					$(".tipo_evento h3").text(evento.tipo);
					$(".info_evento h2").text(evento.nome);
					$(".modal-body span").text(evento.nome);
					$(".info_evento h3").text(evento.horarios[0].sala);
					$(".description p").html(evento.descricao);
					$(".buttonInscrever").attr("data-evento-id", evento_id);
					$.each(evento.autores, function(ind, autor){
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

			$(".buttonInscrever").click(function(){
				var eventoId = $(this).attr("data-evento-id");
				var servico = "./controller/evento_ctrl.php";
				var params = { "act": "inscricao"
							, "evento_id": eventoId
							, "participante_id": <?php echo $_SESSION['usuarioId'];?> };
						
				$.get(servico, params)
					.done(function(data){
						console.log(data);
						if(data==-1){
							console.log("Limite de vagas atingido");
						} else if(data==0) {
							 console.log("Erro ao efetuar inscrição");
						} else{
							console.log("valor de data = " );
							console.log(data);
							console.log("Inscrição realizada com sucesso!");
						}
						
					}).fail(function(data){
						console.log("deu erro");
						console.log(data);
					});
			
			});
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
			<button type="button" class="btn btn-primary btn-custom" data-toggle="modal" data-target="#myModal">Inscreva-se!</button>

            
		  </div>
        </section>
        <div class="description">
			<p></p>
        </div>	
	</main>

<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Semana de Extensão 2017</h4>
      </div>
      <div class="modal-body">
        <p>Confirma a inscrição no evento "<span></span>" ?</p>
      </div>
      <div class="modal-footer">
      	<button class="buttonInscrever" data-dismiss="modal">Inscrever-se</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>

<div id="modalError" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Semana de Extensão 2017 - ERRO</h4>
      </div>
      <div class="modal-body">
        <p>Não foi possível completar a inscrição. Por favor, cheque seus horários</p>
      </div>
      <div class="modal-footer">
      	<button class="buttonInscrever" data-dismiss="modal">Inscrever-se</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>
</body>
</html>
