<?php
	include("autor_ctrl.php");
	
	if($_GET["act"]=="add") {
		$result = cadastrarAutor($_POST["nome"], $_POST["foto"], $_POST["lattes"], $_POST["bio"]);
		if($result) {
			header("location:adm_autor.php?msg=autorCadastrado");	
		} else {
			header("location:adm_autor.php?msg=erro");	
		}
		
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

  			if (vars["msg"]=="autorCadastrado") {
    			$(".message")
      				.message({message:"Autor cadastrado com sucesso!", class:"success"});
  			} else if(vars["msg"]=="erro") {
				$(".message")
      				.message({message:"Autor cadastrado com sucesso!", class:"success"});
  			}
    	});
    </script>

</head>
<body>	
	<!-- para a chamada do plugin -->
    <div class="message"></div>
	<form action="adm_autor.php?act=add" method="post">
		<label>Autor</label>
		<input type="text" name="nome" maxlength="300" size="300" />
		<br />

		<label>Foto</label>
		<input type="text" name="foto" maxlength="400" size="300" value="/extensao/img/"/> 
		<br />
		<label>URL Lattes</label>
		<input type="text" name="lattes" maxlength="400" size="300" /> 
		<br />
		<label>Bio autor</label>
		<textarea name="bio" cols="100" rows="5"></textarea>
		<br />
		<input type="submit" value="Cadastrar">
	</form>
</body>
</html>
