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

	function getHourLastEvent($date) {
		$conexao = abrir();
		$time = strtotime($date);
        $date = date('Y-m-d H:i',$time);

		$sql = " SELECT MAX(data_inicio) as data FROM tb_horarioEvento h ";
		$sql .= " WHERE data_inicio >= \"".$date."\" AND data_termino > \"".$date."\"";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		$result = array();
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

        $inicio = new DateTime($row["data"]);

        fechar($conexao);
        return json_encode($inicio->format('H'));
	}

	if($_GET["act"] == "list") {
		echo listar();
	} elseif($_GET["act"] == "getHourLastEvent") {
		echo getHourLastEvent($_GET["date"]);
	}
?>