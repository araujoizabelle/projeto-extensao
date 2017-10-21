<?php 
	include("../model/banco.php");

	function listaParticipantes($evento_id) {
		$conexao = abrir();
		$sql  = " SELECT distinct u.nome as nome, u.email as email, i.evento_id ";
		$sql .= " FROM tb_usuario u inner join tb_inscricao i ";
		$sql .= " 	ON u.id = i.usuario_id ";
		$sql .= " WHERE i.evento_id = ".$evento_id;
		$sql .= " ORDER BY u.nome ASC ";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		$result = array();
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
        	array_push($result, array("participante" => $row["nome"], "email" => $row["email"]));
        }
		fechar($conexao);
		return $result;
	}

	function geraFolha($evento_id, $horario_id){
		$conexao = abrir();
		$sql  = " SELECT e.nome as nome, h.data_inicio as data, t.nome as tipo ";
		$sql .= " FROM tb_evento e inner join tb_horarioEvento h ";
		$sql .= " 	ON e.id = h.evento_id inner join tb_tipoEvento t ";
		$sql .= " 	ON t.id = e.tipo_evento_id ";
		$sql .= " WHERE h.evento_id = ".$evento_id." AND h.id = ".$horario_id;

		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		$result = array();
		$participantes = listaParticipantes($evento_id);
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $result = array("evento" => $row["nome"] 
        				, "tipo" => $row["tipo"]
        				, "horario" => $row["data"]
        				, "participantes" => $participantes);
		fechar($conexao);
		return json_encode($result);
	}

	if($_GET["act"]=="gerarFolha") {
		echo geraFolha($_GET["evento_id"], $_GET["horario_id"]);
	}
?>