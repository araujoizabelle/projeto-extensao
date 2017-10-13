<?php
	include("../model/banco.php");

	function vincularAutor($eventoId, $autorId) {
		$conexao = abrir();
		$sql = "INSERT INTO autor_tem_evento (tb_autor_id, tb_evento_id) values ";
		$sql .= " (".$autorId.", ".$eventoId.")";

		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));

		fechar($conexao);
		return $query;
	}


	if($_GET["act"]=="add") {
		$eventoId = $_POST["evento"];
		for($i=0; $i<count($_POST);$i++) {
			$autorId = $_POST[$i];
			if($autorId!=null) {
				vincularAutor($eventoId, $autorId);	
			}
		}
		header("location:adm_evento_autor.php?msg=vinculoCadastrado");
	}
?>

<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<link rel="stylesheet" type="text/css" href="../js/plugins/message-plugin.css" />
	<style>
		label {
			display: block;
			font-weight: bold;
		}
		input {
			display: block;
			margin: 10px 0 30px;
		}
	</style>
	<script src="../js/jquery.min.js"></script>
    <script src="../js/plugins/message-plugin.js"></script>
    <script>
    	$(function(){
    		function carregaCombo(autorArray, nameCombo) {
    			$(".autores")
    				.append($("<div/>")
    					.addClass("autor")
    					.append($("<select/>").attr("name", nameCombo))
    					.append($("<a/>").addClass("remove").attr("href", "#").text("apagar"))
    				);
				$.each(autorArray,function(index,autor){
					$("select[name="+nameCombo+"]")
						.append($("<option/>")
							.attr("value", autor.id)
							.text(autor.nome));	
  				});
    		}
    		function getUrlVars() {
			    var vars = [], hash;
			    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
			    for(var i = 0; i < hashes.length; i++) {
			      hash = hashes[i].split('=');
			      vars.push(hash[0]);
			      vars[hash[0]] = hash[1];
			    }
			    return vars;
			}

  			var vars = getUrlVars();

  			if (vars["msg"]=="vinculoCadastrado") {
    			$(".message")
      				.message({message:"Evento vinculado a autor(es) com sucesso!", class:"success"});
  			} 

  			var servico = "autor_ctrl.php?act=list";
  			var autoresArray;
  			$.get(servico).done(function(data){
  				autoresArray = JSON.parse(data);
  				carregaCombo(autoresArray, "0");
  				
  			}).fail(function(data){
  				$(".message").message({message:data, class:"danger"})
  			});

  			$.get("evento_ctrl.php?act=list").done(function(data){
  				eventosArray = JSON.parse(data);
  				$("#evento").append($("<select />").attr("name", "evento"));
  				$.each(eventosArray, function(index, evento){
  					$("select[name=evento]")
  						.append($("<option/>")
  							.attr("value", evento.id)
  							.text(evento.nome));
  				})
  			})

  			$("#maisAutor").click(function(){
  				var indexAutor = $(".autores").children().length;
  				console.log(indexAutor);
  				carregaCombo(autoresArray, indexAutor);
  			});
  			$(".autores").on("click", "a", function(){
  				$(this).parents(".autor").remove();
  			})
    	});
    </script>

</head>
<body>	
	<!-- para a chamada do plugin -->
    <div class="message"></div>
	<form action="adm_evento_autor.php?act=add" method="post">
		<label>Evento</label>
		<span id="evento"></span>

		<label>Autor</label>
		<div class="autores"></div>
		<a href="#" id="maisAutor">
			Mais autor
		</a>
		<input type="submit" value="Cadastrar">
	</form>
</body>
</html>
