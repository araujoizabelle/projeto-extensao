<?php
	include("../model/banco.php");

	function listarHorarioEvento($evento_id) {
		$conexao = abrir();
		$sql = "SELECT * FROM tb_horarioEvento h where h.evento_id = ".$evento_id;
		$horario_array = array();
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));

        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { 
        	array_push($horario_array, array("data_inicio" =>$row["data_inicio"]
        								,"data_termino" =>$row["data_termino"]));
        }
        return $horario_array;
	}
	function listaEventosPorTipo($tipo_evento_id){
		$conexao = abrir();
		$eventos_array = array();
		$sql = "SELECT * FROM tb_evento e where e.tipo_evento_id = ".$tipo_evento_id;

        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { 
			array_push($eventos_array, 
						array("evento_id" => $row["id"],
								"evento_nome" => $row["nome"],
								"evento_autor" => $row["autor"],
								"evento_sala" => $row["sala"],
								"evento_descricao" => $row["descricao"]
								));
		}

		fechar($conexao);
		return $eventos_array;
	}

	function listaEventos(){
		$conexao = abrir();
		$sql = "SELECT * FROM tb_tipoEvento";
        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));

        $result_str = '{"programacao": [';
        $result_array = array();

		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { 
			array_push($result_array, 
						array("tipo_evento" => $row["nome"],
						  	  "eventos" => listaEventosPorTipo($row["id"])
						));
		}

		echo json_encode($result_array);
		fechar($conexao);
	}



	$acao = $_GET["act"];
	
	if($acao == "list") {
		listaEventos();
	}
?>