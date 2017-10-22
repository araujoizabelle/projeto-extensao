<?php
/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode simplesmente não fazer o login e digitar na barra de endereço do seu navegador o caminho para a página principal do site (sistema), burlando assim a obrigação de fazer um login, com isso se ele não estiver feito o login não será criado a session, então ao verificar que a session não existe a página redireciona o mesmo para a index.php.
*/

header('Content-type: text/html; charset=utf-8');

session_start();

if(isset($_SESSION['usuarioId'])== null){
  unset($_SESSION['login']);
  unset($_SESSION['nome']);
  header('location:index.html');
}

//echo "usuario da sessao = ".$_SESSION['usuarioId'];

?>

<!doctype html>

<html>
<head>
  <meta charset="utf-8"/>
  <link rel="stylesheet" type="text/css" href="./js/plugins/calendar-plugin-novo.css" />
  <link rel="stylesheet" href="./css/grid/desktop.css">
  <link rel="stylesheet" href="./font/css/font-awesome.min.css" />
  <link rel="stylesheet" type="text/css" href="./js/bootstrap.min.css"/>
  <link rel="icon" type="image/png" href="./img/favicon.png">
  <script src="./js/jquery.min.js"></script>
  <script src="./js/bootstrap.min.js"></script>
  <script src="./js/plugins/calendar-plugin.js"></script>
  <script src="./js/controller/grid.js"></script>
  <title>Suas Inscrições</title>
  <script>
    $(function(){
        var url = "./controller/evento_ctrl.php?";
        url += "act=listMyEvents&usuario_id=<?php echo $_SESSION["usuarioId"]; ?>";
        var $xhr = $.get(url);
        $xhr.done(function(data) {
          var dataEventosArray = JSON.parse(data);
          var opcoes = {qtdLinhas: 14
                    , horaInicial: 8
                    , salas: dataEventosArray};

          $(".calendar").calendar(opcoes);
        });


        $(".buttonDesistir").click(function(){
            var servico = "./controller/evento_ctrl.php";
            var evento_id = $(this).attr("data-evento").substr(7);
            var params = {act:"removeInscricao"
                        , evento_id: evento_id
                        , usuario_id: $("#usuario_id").val()};
            $.get(servico, params)
                .done(function(data){
                    window.location.href="calendario.php";
                });
        })

        posicionarHeader();

        $('.slide').click(function() {
            $doc.animate({
                scrollTop: $( $.attr(this, 'href') ).offset().top
            }, 750);
        });

        $(".logout_but").click(function(){
          $.get("./controller/usuario_ctrl.php?act=logout")
            .done(function(data){
              window.location.href = "index.html";
          });
        });

    });

  </script>
    <style>
      main {
        width: 760px;
      }
        .calendar {
            margin:0 auto;
            width: 700px;
        }
    </style>
</head>
<body class="fadeIn">

    <input type="hidden" id="usuario_id" value="<?php echo $_SESSION['usuarioId'];?>"/>
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
    <div class="title-page">
      <h1 class="title">Suas Inscrições</h1>
    </div>
    <main class="content">
      <div class="calendar"></div>
      <div class="message"></div>
    </main>

    <!-- MODAL -->

    <div id="myModal" class="modal fade" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Semana de Extensão 2017 - Confirmação de Desistência</h4>
          </div>
          <div class="modal-body">
            <p>Deseja desistir de sua inscrição no evento "<span></span>"?</p>
          </div>
          <div class="modal-footer">
            <button class="buttonDesistir" class="btn btn-danger" data-dismiss="modal" >Confirmar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
          </div>
        </div>
      </div>
    </div>
  </body>

</html>
