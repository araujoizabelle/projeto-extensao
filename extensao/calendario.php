<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <title>Login</title>
    <link rel="stylesheet" href="./css/reset.css" />

<?php
/* esse bloco de código em php verifica se existe a sessão, pois o usuário pode simplesmente não fazer o login e digitar na barra de endereço do seu navegador o caminho para a página principal do site (sistema), burlando assim a obrigação de fazer um login, com isso se ele não estiver feito o login não será criado a session, então ao verificar que a session não existe a página redireciona o mesmo para a index.php.
*/

include("./controller/calendario_ctrl.php");

header('Content-type: text/html; charset=utf-8'); 

session_start();

if(!isset ($_SESSION['usuarioId'])== null){
	unset($_SESSION['login']);
	unset($_SESSION['senha']);
	header('location:index.html');
}


//$logado = $_SESSION['login'];

//print_f($eventos);
//$eventosArray = null;


//$numLinhas = mysql_num_rows($eventosArray);
//printf($eventosArray);

function montarTabela() { 
	$eventosArray = listar();
	$data_atual = null;
	while ($row = mysqli_fetch_array($eventosArray)) { //MYSQL_NUM
		$date = new DateTime($row["data_inicio"]);
		if($data_atual == null || $data_atual != $date->format('d/m/Y')) {
			$data_atual = $date->format('d/m/Y');
			echo "<tr><th colspan='6'>Programação do dia ".$data_atual."</th></tr>";
			echo "<tr><th>Título</th><th>Tipo</th><th>início</th><th>fim</th>";
			echo "<th colspan='2'></th></tr>";
		}
		echo "<tr>";
		//echo "<td>Id do evento: ".$row[0]."</td>";
		echo "<td>".$row[1]."</td>";
		echo "<td>".$row["nome"]."</td>";

		$date = new DateTime($row["data_inicio"]);
//$date->format('Y-m-d H:i:s')
		echo "<td>".$date->format('H:i')."</td>";
		
		$date = new DateTime($row["data_termino"]);
		echo "<td>".$date->format('H:i')."</td>"; //$row["data_termino"]
		echo "<td><a href='evento.php?act=inscricao&id=".$row[0]."'>Inscreva-se!</a></td>";
		echo "<td><a href='evento.php?act=get&id=".$row[0]."'>Detalhes</a></td>";
		echo "</tr>";
		
	}
}

?>
    
    
    <script src="./js/jquery.min.js"></script>
   	<script>
   		/*
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
   		*/
   	</script>
    
  </head>
  <body class="fadeIn">
    <table class="eventos">
    	<tr>
    		<th>Título</th>
    		<th>Tipo</th>
    		<th>início</th>
    		<th>fim</th>
    		<th colspan="2"></th>
    	</tr>
    <?php
    	montarTabela();
    ?>
    </table>
  </body>
</html>