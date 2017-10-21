<?php
    session_start();

    if((!isset ($_SESSION['login']) == true) &&($_SESSION['usuarioId']== null)){
        unset($_SESSION['login']);
        unset($_SESSION['nome']);
        header('location:index.html');
    }
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
        label {
            display: block;
            margin:10px 0 0;
            font-weight: bold;
        }
        select {
            padding: 3px;
            font-size: 1.2em;
            width: 600px;
        }
        button {
            display: block;
            font-size: 1em;
            padding: 10px;
            margin: 20px auto;
        }
        .form-folha {
            width: 800px;
            margin: 0 auto;
            border: #888 solid 1px;
            padding: 15px;
            box-sizing: border-box;
        }
    </style>
    <script src="./js/controller/grid.js"></script>

    <script>
      $(function(){
        posicionarHeader();
        var servico = "./controller/evento_ctrl.php?act=list";

        $.get(servico)
            .done(function(data){
            var eventoArray = JSON.parse(data);
            $.each(eventoArray, function(index, evento) {
                $("#evento_id")
                    .append($("<option />")
                        .attr("value", evento.id)
                        .text(evento.nome));
            });
        });

        $("#evento_id").change(function(){
            $("#horario_id").empty();
            if($(this).val()!="0"){
                var evento_id = $(this).val();
                $.get("./controller/horario_ctrl.php?act=list&evento_id="+evento_id)
                .done(function(data){

                    var dataArray = JSON.parse(data);
                    
                    $("#horario_id").empty();

                    $.each(dataArray, function(index, dataEvento) {
                        $("#horario_id")
                            .append($("<option/>")
                                .attr("value", dataEvento.horario_id)
                                .text(dataEvento.data));
                    });
                });
            }
        });

        $("#gerarFolha").click(function(){
            var path = "folha.php?evento_id="+$("#evento_id").val()+"&";
            path += "horario_id="+$("#horario_id").val();
            location.href = path;
        });

        $(".logout_but").click(onButtonLogoutClick);
        $('.slide').click(onSlideClick);

      });
    </script>
  </head>
    <body class="fadeIn">
        <header class="header">
            <form class="header-form" method="post">
                <input type="hidden" name="logout" value="ok">
                <a class="escricoes_but" href="grid.php">Toda a Programação</a>
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
                <li><a class="slide" href="grid.php#segunda-feira">Segunda-feira</a></li>
                <li><a class="slide" href="grid.php#terça-feira">Terça-feira</a></li>
                <li><a class="slide" href="grid.php#quarta-feira">Quarta-feira</a></li>
            </ul>
        </div>
        <main class="content">
            <fieldset class="form-folha">
                <legend>Horário do Evento</legend>
                <label>Evento:</label>
                <select id="evento_id" >
                    <option value="0">Selecione um Evento</option>
                </select>
                <label>Horário:</label>
                <select id="horario_id"></select>
                <button id="gerarFolha">Gerar Folha de Presença</button>
            </fieldset> 
        </main>
    </body>
</html>