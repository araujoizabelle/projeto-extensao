<?php

    session_start();

    if((!isset ($_SESSION['login']) == true) &&($_SESSION['usuarioId']== null)){
        unset($_SESSION['login']);
        unset($_SESSION['nome']);
        header('location:index.html');
    }

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
	<script src="./js/bootstrap.min.js"></script>
    <script src="./js/plugins/message-plugin.js"></script>
    <script src="./js/main.js"></script>
    <script src="./js/controller/grid.js"></script>
	<script src="./js/controller/evento.js"></script>
	
	<script>
		$(function(){
			var vars = getUrlVars();
            var evento_id = vars["id"];
			var usuario_id = $("#usuario_id").val();

            if (vars["act"]=="get") {
                carregaEvento(evento_id); 
			} 
                 
			$(".buttonInscrever").click(function(){
                var eventoId = $(this).attr("data-evento-id");
                var servico = "./controller/evento_ctrl.php";
                var params = { "act": "inscricao"
                        , "evento_id": evento_id
                        , "usuario_id": usuario_id };

                $.get(servico, params)
                    .done(geraMensagem)
                    .fail(geraMensagem);
            });

            $(".buttonDesistir").click(function(){
                var servico = "./controller/evento_ctrl.php";
                var params = {act:"removeInscricao"
                            , evento_id: evento_id
                            , usuario_id: usuario_id };
                $.get(servico, params)
                    .done(function(data){
                        window.location.href="evento.php?act=get&id="+evento_id;
                });
            });

            $(".logout_but").click(function(){
                $.get("./controller/usuario_ctrl.php?act=logout")
                    .done(function(data){
                    window.location.href = "index.html";
                });
            });

            configuraBotaoInscricao(evento_id,usuario_id);
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
  <input type="hidden" id="usuario_id" value="<?php echo $_SESSION['usuarioId'];?>"/>
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
		<section class="evento">
            <div class="tipo_evento">
                <h3><!---tipo do evento--></h3>
            </div>
		  <div class="info_evento">
			<h2>NOME</h2>
			<h3>SALA</h3>

			<button id="inscricao" type="button" > </button>

            
		  </div>
    </section>
    <div class="horarios">
        <div class="message"></div>
		<ul></ul>
    </div>	
    <div class="description">
			<p></p>
    </div>	
	</main>

<div id="modalInscricao" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-info">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Semana de Extensão 2017</h4>
      </div>
      <div class="modal-body">
        <p>Confirma a inscrição no evento "<span></span>" ?</p>
      </div>
      <div class="modal-footer">
      	<button type="button" class="buttonInscrever btn btn-primary" data-dismiss="modal">Inscrever-se</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
</div>
<div id="modalCancelamento" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-info">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Semana de Extensão 2017 - Confirmação de Desistência</h4>
      </div>
      <div class="modal-body">
        <p>Deseja desistir de sua inscrição no evento "<span></span>"?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="buttonDesistir btn btn-danger" data-dismiss="modal" >Confirmar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
      </div>
    </div>

  </div>
<div id="modalSucesso" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header modal-info">
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
