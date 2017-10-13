<?php
	include("../model/banco.php");

	function listar(){
		$conexao = abrir();
		$sql = "SELECT DISTINCT DATE(h.data_inicio) as data FROM tb_horarioEvento h ";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		$result = array();
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { 
        	array_push($result, $row["data"]);
        }
        fechar($conexao);
        return json_encode($result);

	}

	if($_GET["act"] == "list") {
		echo listar();
	}
?>