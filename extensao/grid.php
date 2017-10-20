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

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Programação</title>
   <link rel="icon" type="image/png" href="./img/logo_extensao.png">
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/grid/desktop.css">
    <link rel="stylesheet" href="./font/css/font-awesome.min.css">
    <script src="./js/jquery.min.js"></script>

    <script src="./js/controller/grid.js"></script>

    <script>
      
      $(function(){
        $.get("./controller/horario_ctrl.php?act=list")
          .done(function(data){
            var dataArray = JSON.parse(data);
            console.log(dataArray);
            $.each(dataArray, function(i, obj){
              carregaDiasEventos(obj, 2);
            })
          });
        
        $(".logout_but").click(function(){
          $.get("./controller/usuario_ctrl.php?act=logout")
            .done(function(data){
              window.location.href = "index.html";
          });
        });
        
        $("main").on("click", ".event", function(){
          var evento_id = $(this).attr("id");

          window.location.href = "evento.php?act=get&id="+evento_id;
        });
        
        $("main").on("mouseover",".event",onEventOver);

        $("main").on("mouseleave",".event",onEventLeave);
        
        posicionarHeader();
        
        $('.slide').click(function() {
            $doc.animate({
                scrollTop: $( $.attr(this, 'href') ).offset().top
            }, 750);
        });

      });
    </script>
  </head>
  <body class="fadeIn">
    <header class="header">
      <form class="header-form" method="post">
        <input type="hidden" name="logout" value="ok">
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
    
    <div class="partition">
      <ul class="partition-nav">
        <h1 class="partition-h1">Programação Do Evento</h1>
        <li><a class="slide" href="#segunda-feira">Segunda-feira</a></li>
        <li><a class="slide" href="#terça-feira">Terça-feira</a></li>
        <li><a class="slide" href="#quarta-feira">Quarta-feira</a></li>
        <!--
        <li><a class="slide" href="#todos-os-dias">Todos os dias</a></li>
      -->
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
