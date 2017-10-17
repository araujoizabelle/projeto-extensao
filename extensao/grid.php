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

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Programação</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/grid/desktop.css">
    <link rel="stylesheet" href="./font/css/font-awesome.min.css">
    <script src="./js/jquery.min.js"></script>
    <style>
      .day-grid:nth-child(2n) {
        background-color: #ddd;
      }

      .event:hover{
        background-color: #ddf;
        transition: all 0.5s;
      }

    </style>
    <!--
    <script src="./js/grid/desktop.js"></script>
  -->
    <script>
      function getDiaSemana(dia) {
        var diaDaSemana = dia.getDay();
        switch (diaDaSemana){
          case 0: return "domingo";
          case 1: return "segunda-feira";
          case 2: return "terça-feira";
          case 3: return "quarta-feira";
          case 4: return "quinta-feira";
          case 5: return "sexta-feira";
          case 6: return "sábado";
        }
      }
      
      function carregarEventos($div, inicio, fim) {
        var servico = "./controller/evento_ctrl.php";
        var params = {"act": "listByDateTime", "begin": inicio, "end":fim};
        $.get(servico, params).done(function(data){
          var eventosArray = JSON.parse(data);
          $.each(eventosArray,function(index, evento){
            $div
              .append($("<div/>").addClass("event").attr("id", evento.id)
                .append($("<p/>").addClass("event-tipo").text(evento.tipo + " " +evento.inicio))
                //.append($("<p/>").addClass("event-inicio").text())
                .append($("<h1/>").addClass("evento-title").text(evento.nome))
                .append($("<p/>").addClass("event-local").text(evento.local))
                .append($("<span />").addClass("event-details")
                  .append($("<i/>").addClass("fa fa-paper-plane-o").attr("aria-hidden", "true")
                    )
                )
              );
          });
        });
      }

      function carregaGridDia(data, intervalo) {
        var dataArray = data.split("-");
        var ano = dataArray[0];
        var mes = parseInt(dataArray[1])-1;
        var diaDoMes = dataArray[2];
        var diaDate = new Date(ano, mes, diaDoMes);
        //passo 1 identificar até que horas haverá eventos iniciando
        var servico = "./controller/horario_ctrl.php?act=";
        var params = {"act": "getHourLastEvent", "date": data};
        $.get(servico, params).done(function(data){
          //retirando as aspas do data;
          var horarioTermino = parseInt(data.substring(1, data.length-1));
          $divDia = $("<div/>")
                      .addClass("day").attr("data-dia", diaDoMes)
                      .append($("<div />").addClass("day-date")
                        .append($("<h1/>").attr("id", getDiaSemana(diaDate))
                          .text(getDiaSemana(diaDate) +  "["+diaDoMes+"]")
                        )
                      );
          for(var i=8; i<horarioTermino; i+=intervalo) {
            var dataStr = ano+"-"+(mes+1)+"-"+diaDoMes;
            var seletor= dataStr+"_"+i;
            $divDia
              .append($("<div/>").addClass("day-grid")
                .append($("<div />").addClass("grid")
                  .append($("<div />").addClass("grid-hour")
                    .append($("<h1/>").text(i+":00"))
                  )
                  .append($("<div/>").addClass("grid-event")
                    .attr("data-inicio",seletor))
                )
              );
            $("main").append($divDia);
            carregarEventos($("div[data-inicio="+seletor+"]")
                          , dataStr+" "+i+":00"
                          , dataStr+" "+(i+intervalo)+":00");
            
          }
          
        });
        
      }
      $(function(){

        carregaGridDia("2017-10-16", 2);
        carregaGridDia("2017-10-17", 2);
        carregaGridDia("2017-10-18", 2);
        
        $("main").on("click", ".event", function(){
          var evento_id = $(this).attr("id");
          window.location.href = "evento.php?act=get&id="+evento_id;
        });

      });
    </script>
  </head>
  <body class="fadeIn">
    <header class="header">
      <p class="header-content">Cabeçalho</p>
    </header>
    <div class="partition">
      <ul class="nav">
        <h1 class="partition-h1">Programação Do Evento</h1>
        <li><a href="#">Segunda-feira</a></li>
        <li><a href="#">Terça-feira</a></li>
        <li><a href="#">Quarta-feira</a></li>
      </ul>
    </div>
    <main class="content">

    </main>
  </body>
</html>


<!--      
      <div class="day" data-dia="23">
        <div class="day-date">
          <h1 id="segunda-feira">segunda-feira [23]</h1>
        </div>
        <div class="day-grid">
          <div class="grid">
            <div class="grid-hour">
              <h1>8:00</h1>
            </div>
            <div class="grid-event" name="2017-10-23_8">
            </div>
          </div>

          <div class="grid">
            <div class="grid-hour">
              <h1>10:00</h1>
            </div>
            <div class="grid-event" name="2017-10-23_10">
            </div>
          </div>
          <div class="grid">
            <div class="grid-hour">
              <h1>12:00</h1>
            </div>
            <div class="grid-event" name="2017-10-23_12">
            </div>
          </div>
          <div class="grid">
            <div class="grid-hour">
              <h1>14:00</h1>
            </div>
            <div class="grid-event" name="2017-10-23_14">
            </div>
          </div>
          <div class="grid">
            <div class="grid-hour">
              <h1>16:00</h1>
            </div>
            <div class="grid-event" name="2017-10-23_16">
            </div>
          </div>
        </div>
      </div>
      <div class="day">
        <div class="day-date">
          <h1 id="terça-feira">terça-feira [24]</h1>
        </div>
        <div class="day-grid">
          <div class="grid">
            <div class="grid-hour">
              <h1>HORA</h1>
            </div>
            <div class="grid-event">
              <div class="event">
                <p class="event-tipo">TIPO</p>
                <h1 class="evento-title">TÍTULO</h1>
                <p class="event-local">LOCAL</p>
                <span class="event-details"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>
              </div>
              <div class="event">
                <p class="event-tipo">TIPO</p>
                <h1 class="evento-title">TÍTULO</h1>
                <p class="event-local">LOCAL</p>
                <span class="event-details"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>
              </div>
              <div class="event">
                <p class="event-tipo">TIPO</p>
                <h1 class="evento-title">TÍTULO</h1>
                <p class="event-local">LOCAL</p>
                <span class="event-details"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>
              </div>
              <div class="event">
                <p class="event-tipo">TIPO</p>
                <h1 class="evento-title">TÍTULO</h1>
                <p class="event-local">LOCAL</p>
                <span class="event-details"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>
              </div>
            </div>
          </div>
          <div class="grid">
            <div class="grid-hour">
              <h1>HORA</h1>
            </div>
            <div class="grid-event">
              <div class="event">
                <p class="event-tipo">TIPO</p>
                <h1 class="evento-title">TÍTULO</h1>
                <p class="event-local">LOCAL</p>
                <span class="event-details"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>
              </div>
              <div class="event">
                <p class="event-tipo">TIPO</p>
                <h1 class="evento-title">TÍTULO</h1>
                <p class="event-local">LOCAL</p>
                <span class="event-details"><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
-->