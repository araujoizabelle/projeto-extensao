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
    <title>Gerar Folha de Presença</title>
    <link rel="stylesheet" href="./css/reset.css">
    <link rel="stylesheet" href="./css/grid/desktop.css">
    <link rel="stylesheet" href="./css/gerar_folha.css">
    <link rel="stylesheet" href="./font/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="./img/favicon.png">
    <script src="./js/jquery.min.js"></script>
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
                <h1 class="partition-h1">Folha de Presença</h1>
            </ul>
        </div>
        <main class="content">
            <fieldset class="form-folha">
                <label class="evento_id">Evento:</label>
                <select class="evento_id" >
                    <option value="0">Selecione um Evento</option>
                </select>
                <label class="horario_id">Horário:</label>
                <select class="horario_id"></select>
                <button id="gerarFolha">Gerar Folha de Presença</button>
            </fieldset>
        </main>
    </body>
</html>
