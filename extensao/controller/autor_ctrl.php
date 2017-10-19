<?php
	include("../model/banco.php");

	function cadastrarAutor($nome, $foto, $lattes, $bio) {
		$conexao = abrir();
		$sql = "INSERT INTO tb_autor (nome, foto, lattes, bio) values ";
		$sql .= " ('".$nome."', '".$foto."', '".$lattes."', '".$bio."')";

		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		
		$autorId = mysql_insert_id($conexao);
		fechar($conexao);
		return $autorId;
	}

	function listarAutor() {
		$conexao = abrir();
		$sql = "SELECT * FROM tb_autor ";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		$autoresArray = array();
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
			array_push($autoresArray, $row);
		}
		fechar($conexao);
		return json_encode($autoresArray);

	}

	if($_GET["act"]=="list") {
		echo listarAutor();
	}

?>