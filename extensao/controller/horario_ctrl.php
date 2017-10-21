<?php
	include("../model/banco.php");

	function listar(){
		$conexao = abrir();
		$sql = "SELECT DISTINCT DATE(h.data_inicio) as data FROM tb_horarioEvento h ";
		$sql .= " ORDER BY data ASC ";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		$result = array();
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { 
        	array_push($result, $row["data"]);
        }
        fechar($conexao);
        return json_encode($result);
	}

	function listarPorEvento($evento_id) {
		$conexao = abrir();
		$sql = "SELECT h.id, h.data_inicio as data FROM tb_horarioEvento h ";
		$sql .= " WHERE h.evento_id = ". $evento_id;
		$sql .= " ORDER BY data ASC ";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		$result = array();
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { 
        	array_push($result, array("horario_id" => $row["id"]
        							,"data" => $row["data"]));
        }
        fechar($conexao);
        return json_encode($result);
	}
	
	function getHourLastEvent($date) {
		$conexao = abrir();
		$time = strtotime($date);
        $date = date('Y-m-d',$time);
        $inicio = $date." 00:00:00";
        $fim = $date." 23:59:59";
        //$dateMais1 = date('Y-m-d H:i',$timeMais1);

		$sql = " SELECT MAX(data_inicio) as data FROM tb_horarioEvento h ";
		$sql .= " WHERE data_inicio >= \"".$inicio."\" AND data_inicio < \"".$fim."\"";

		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		$result = array();
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);

        $inicio = new DateTime($row["data"]);

        fechar($conexao);
        return json_encode($inicio->format('H'));
	}

	if($_GET["act"] == "list") {
		if($_GET["evento_id"]!=null) {
			echo listarPorEvento($_GET["evento_id"]);
		} else {
			echo listar();
		}
	} elseif($_GET["act"] == "getHourLastEvent") {
		echo getHourLastEvent($_GET["date"]);
	}
?>