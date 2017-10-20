<?php

	session_start();

    if($_SESSION['usuarioId']== null){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        unset($_SESSION['nome']);
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
	<link rel="stylesheet" type="text/css" id="folha"/> <!--Aqui será colocada a folha de estilo do evento específico-->
    <link rel="icon" type="image/png" href="./img/favicon.png">
	<link rel="stylesheet" href="./css/font-awesome-4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="./js/plugins/message-plugin.css" />
	<link rel="stylesheet" type="text/css" href="./js/bootstrap.min.css"/>

   <link href="https://fonts.googleapis.com/css?family=Monda:700" rel="stylesheet">
	<link rel="stylesheet" href="./css/grid/desktop.css">

	<script src="./js/jquery.min.js"></script>
	<script src="./js/controller/grid.js"></script>
	<script src="./js/controller/evento.js"></script>
	<script src="./js/plugins/message-plugin.js"></script>
	<script src="./js/bootstrap.min.js"></script>
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
console.log("evento ");
console.log(evento);
					//configurando folha de estilo
					setFolha(evento.tipo);
					$(".tipo_evento h3").text(evento.tipo);
					$(".info_evento h2").text(evento.nome);
					$(".modal-body span").text(evento.nome);
					$(".info_evento h3").text(evento.horarios[0].sala);
					$(".description p").html(evento.descricao);
					$(".buttonInscrever").attr("data-evento-id", evento_id);

          $.each(evento.horarios, function(index, horario){
            var dataStr = horario.data_inicio.split(" ")[0];
            var horaInicioArray = horario.data_inicio.split(" ")[1].split(":");
            var horaInicioStr = horaInicioArray[0]+":"+horaInicioArray[1];
            var dataFormatada = dataStr.split("-")[2]+"/"+dataStr.split("-")[1]; 
            var horaFimArray = horario.data_termino.split(" ")[1].split(":");
            var horaFimStr = horaFimArray[0]+":"+horaFimArray[1];
            //<li>Dia 23/10, 8:00 às 12:00</li>
            $(".horarios ul")
              .append($("<li />")
                .text("Dia "+dataFormatada+", de "+horaInicioStr+" às "+horaFimStr));
console.log(horario);

          });

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

			$(".logout_but").click(function(){
	          $.get("./controller/usuario_ctrl.php?act=logout")
	            .done(function(data){
	              window.location.href = "index.html";
	          });
	        });

			$(".buttonInscrever").click(function(){
				var eventoId = $(this).attr("data-evento-id");
				var servico = "./controller/evento_ctrl.php";
				var params = { "act": "inscricao"
							, "evento_id": eventoId
							, "usuario_id": <?php echo $_SESSION['usuarioId'];?> };
						
				$.get(servico, params)
					.done(geraMensagem)
					.fail(geraMensagem);
			
			});

			posicionarHeader();
        
	        $('.slide').click(function() {
	            $doc.animate({
	                scrollTop: $( $.attr(this, 'href') ).offset().top
	            }, 750);
	        });
		})
	</script>
</head>
<body class="fadeIn">
	<header class="header">
        <form class="header-form" method="post">
            <input type="hidden" name="logout" value="ok">
            <a class="escricoes_but" href="grid.php">Início</a>
            <br />
            <br />
            <a class="escricoes_but" href="calendario.php">Minha Programação</a>
            <button class="logout_but">Logout</button>
        </form>
        <div class="header-texts">
            <h1 class="header-school">CEFET/RJ - Campus Nova Friburgo</h1>
            <p class="usuario_name">
                <?php echo substr($_SESSION["nome"],0,27);?>
            </p>
        </div>
        <div class="header-logo">
            <img class="header-logo-img" src="./img/logo_extensao.png" alt="logo">
        </div>
    </header>
<!--
    <div class="partition">
        <ul class="partition-nav">
            <h1 class="partition-h1">Programação Do Evento</h1>
            <li><a class="slide" href="grid.php#segunda-feira">Segunda-feira</a></li>
            <li><a class="slide" href="grid.php#terça-feira">Terça-feira</a></li>
            <li><a class="slide" href="grid.php#quarta-feira">Quarta-feira</a></li>
            <li><a class="slide" href="grid.php#todos-os-dias">Todos os dias</a></li>
        </ul>
    </div>
-->
	<main class="main">
		<div class="message"></div>
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
    <div class="horarios">
			<ul></ul>
    </div>	
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
<div id="modalSucesso" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Semana de Extensão 2017</h4>
      </div>
      <div class="modal-body">
        <p>Inscrição efetuada com sucesso!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>

  </div>
</div>
<div id="modalErroLimite" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Semana de Extensão 2017 - ERRO</h4>
      </div>
      <div class="modal-body">
        <p>Limite de vagas atingido.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
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
        <p>Não foi possível completar a inscrição. Por favor, cheque seus horários.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
      </div>
    </div>

  </div>
</div>
</body>
</html>
