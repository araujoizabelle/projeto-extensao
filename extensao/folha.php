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
    <title>Folha</title>
<!--
    <link rel="stylesheet" href="./css/reset.css">
-->
    <link rel="stylesheet" href="./css/grid/desktop.css">
    <link rel="icon" type="image/png" href="./img/favicon.png">
    <link rel="stylesheet" href="./font/css/font-awesome.min.css">
    <link rel="stylesheet" href="./css/folha.css"/>
    <script src="./js/jquery.min.js"></script>
    <script src="./js/main.js"></script>

    <script src="./js/controller/grid.js"></script>

    <script>

        $(function(){
            var vars = getUrlVars();
            var evento_id = vars["evento_id"];
            var horario_id = vars["horario_id"];
            var servico = "./controller/folha_ctrl.php?act=gerarFolha&evento_id=";
            servico += evento_id+"&horario_id="+horario_id;
console.log(servico);
            $.get(servico)
                .done(function(data){
console.log(data);
                    var folha = JSON.parse(data);
                    console.log(folha);

                $(".evento-nome").text(folha.evento);
                $("#evento-data").text(formatarData(folha.horario)+"/2017");
                $("#evento-hora").text(formatarHora(folha.horario));
                $.each(folha.participantes, function(index, obj){
                    $(".participantes tbody")
                        .append($("<tr />")
                            .append($("<td/>").text(obj.participante))
                            .append($("<td/>"))
                            .append($("<td/>")));
                });
            });

            $(".logout_but").click(onButtonLogoutClick);
            //$('.slide').click(onSlideClick);

        });
    </script>

</head>
<body>
    <table class="folha">
    <thead>
        <tr class="cabecalho">
            <td>
                <img src="./img/logo_preto.png" class="logo-cefet"/>
                <h4>Campus Nova Friburgo</h4>
            </td>
            <th colspan="5">
                <img src="./img/logo_extensao.png" class="logo-extensao"/>
            </th>
        </tr>
        <tr class="evento">
            <th>Evento:</th>
            <td colspan="5" class="evento-nome"></td>
        </tr>
        <tr class="evento-detalhes">
            <th>Responsável:</th><td class="evento-responsavel"></td>
            <th class="evento-hora">Data:</th><td id="evento-data" class="evento-hora-val"></td>
            <th class="evento-hora">Hora:</th><td id="evento-hora" class="evento-hora-val"></td>
        </tr>
    </thead>
    </table>

    <h3>Participantes</h3>

    <table class="participantes">
    <tbody>
        <tr>
            <th class="participante-nome" >Nome</th>
            <th class="participante-matricula" >Matrícula</th>
            <th class="participante-assinatura" >Assinatura</th>
        </tr>
    </tbody>

    </table>
</body>
</html>
