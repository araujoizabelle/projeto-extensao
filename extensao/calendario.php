<?php
/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode simplesmente não fazer o login e digitar na barra de endereço do seu navegador o caminho para a página principal do site (sistema), burlando assim a obrigação de fazer um login, com isso se ele não estiver feito o login não será criado a session, então ao verificar que a session não existe a página redireciona o mesmo para a index.php.
*/

header('Content-type: text/html; charset=utf-8'); 
/*
session_start();

if(isset($_SESSION['usuarioId'])== null){
  unset($_SESSION['login']);
  unset($_SESSION['senha']);
  header('location:index.html');
}
*/
?>

<!doctype html>
<html>
<head>
  <meta charset="utf-8"/>
  <link rel="stylesheet" type="text/css" href="./js/plugins/calendar-plugin.css" />
  <script src="./js/jquery.min.js"></script>
  
  <script src="./js/plugins/calendar-plugin.js"></script>

  <script>
    $(function(){
        var url = "./controller/evento_ctrl.php";
        var params = {"act": "listMyEvents"};
        var $xhr = $.get(url, params);

        $xhr.done(function(data) {
          var dataEventosArray = JSON.parse(data);
          console.log(dataEventosArray);
          var opcoes = {qtdLinhas: 14
                    , horaInicial: 8
                    , salas: dataEventosArray};
          $(".calendar").calendar(opcoes);            
        });

        
    });

  </script>
</head>
<body>

  <div class="calendar"></div>
  <div class="message"></div>
  <button>Fazer aparecer o plugin!</button>
</body>
</html>
<!--

   	<script>
   		$(function() {
   			var url = "./controller/calendario_ctrl.php";
        var params = {"act": "list"};
   			var $xhr = $.get(url, params);

   			$xhr.done(function(data) {
   				var dataEventosArray = JSON.parse(data);
          
   				var dia = null;
          $.each(dataEventosArray, function(index, dataEvento){
            
   					var $horario = $("<tr/>");
            var $evento = $("<td />");
            $.each(dataEvento.eventos, function(index, evento){
              $evento
                .append($("<div/>")
                  .append($("<a/>")
                    .attr("href","evento.php?act=get&evento_id="+evento.evento_id)
                    .text(evento.evento_nome))
                  .append($("<span/>").text(evento.evento_tipo))
                  .append($("<div />").addClass("detalhes").text("+"))
                  );
            });

            $horario
              .append($("<th/>").text(dataEvento.hora_inicio + " - " + dataEvento.hora_termino))
              .append($evento);
            if(dia == null || dia != dataEvento.data) {
              dia = dataEvento.data;
              $(".eventos")
                .append($("<tr />")
                  .append($("<th />").attr("colspan", "4")
                    .text(dataEvento.data)
                  )
                );
            }
            $(".eventos").append($horario);	
   				});
   				
          
   			});

   			$xhr.fail(function(data){
   				console.log(data);
   			})
   			
   		})
   		
   	</script>
    
  </head>
  <body class="fadeIn">
    <table class="eventos">
    	<tr>
    		<th>Horário</th>
    		<th>Evento</th>
    		<th colspan="2"></th>
    	</tr>
    </table>
  </body>
</html>

-->