<?php

  session_start();

    if((!isset ($_SESSION['login']) == true) &&($_SESSION['usuarioId']== null)){
        unset($_SESSION['login']);
        unset($_SESSION['nome']);
        header('location:index.html');
    }
//echo "Usuario da sessao ".$_SESSION["usuarioId"];
//  $evento_id = $_GET["id"];

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <title>Programação</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/grid/desktop.css">
    <link rel="stylesheet" href="./font/css/font-awesome.min.css">
    <script src="./js/jquery.min.js"></script>

    <script src="./js/controller/grid.js"></script>

    <script>
      $(function(){
        posicionarHeader();
        carregarPagina();
        
        $(".logout_but").click(onButtonLogoutClick);
        
        $("main").on("click", ".event", onEventClick);
        $("main").on("mouseover",".event",onEventOver);
        $("main").on("mouseleave",".event",onEventLeave);

        $('.slide').click(onSlideClick);

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