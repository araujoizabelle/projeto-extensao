<?php
/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode simplesmente não fazer o login e digitar na barra de endereço do seu navegador o caminho para a página principal do site (sistema), burlando assim a obrigação de fazer um login, com isso se ele não estiver feito o login não será criado a session, então ao verificar que a session não existe a página redireciona o mesmo para a index.php.
*/

include("./controller/calendario_ctrl.php");
/*
session_start();

if(!isset ($_SESSION['usuarioId'])== null){
	unset($_SESSION['login']);
	unset($_SESSION['senha']);
	header('location:index.html');
}
*/
//$logado = $_SESSION['login'];
$eventosArray = listar();
//print_f($eventos);
//$eventosArray = null;


//$numLinhas = mysql_num_rows($eventosArray);
//printf($eventosArray);

while ($row = mysqli_fetch_array($eventosArray)) { //MYSQL_NUM
	//print_r($row);
	echo "<h1>Nome do evento: ".$row[1]."</h1>";
	echo "<h2>Tipo de evento: ".$row["nome"]."</h2>";
	echo "<h3>data de inicio: ".$row[5]."</h3>";
	echo "<h3>data de fim: ".$row[6]."</h3>";
	echo "<br/> <br/>";
}



?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="./css/reset.css" />
    
    
    <script src="./js/jquery.min.js"></script>
   	<script>
   		$(function() {
   			var url = "./controller/calendario_ctrl.php/listarJson";
   			var $xhr = $.get(url);

   			$xhr.done(function(data) {
   				var eventosArray = JSON.parse(data);
   				//eventosArray = data;
   				console.log(eventosArray);
   				$.each(eventosArray, function(index, evento){
   					$(".eventos")
   						.append($("<tr />")
   							.append($("<td />")
   								.text(evento.nome)
   							)
   							.append($("<td />")
   								.text(evento.tipo_evento_id))
   							.append($("<td />")
   								.text(evento.data_inicio))
   							.append($("<td />")
   								.text(evento.data_fim))
   						)	
   				})
   				
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
    		<th>Título</th>
    		<th>Tipo</th>
    		<th>início</th>
    		<th>fim</th>
    	</tr>
    </table>
  </body>
</html>