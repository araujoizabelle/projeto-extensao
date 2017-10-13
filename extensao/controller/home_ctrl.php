<?php
	include("../model/banco.php");

//	include("evento_ctrl.php");
//	include("tipo_evento_ctrl.php");


function getTipo($id) {
    	$conexao = abrir();
    	$sql = "SELECT * FROM tb_tipoEvento t";
    	$sql .= " WHERE t.id = ".$id;
    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query);

    	fechar($conexao);
    	return $result["nome"];	
    }

    function listTipo() {
    	$conexao = abrir();
    	$sql = "SELECT * FROM tb_tipoEvento t";
    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        $result = array();
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
        	array_push($result, array("id" => $row["id"]
        						, "nome" => utf8_encode($row["nome"])));
        }
    	fechar($conexao);
    	return $result;	
    }


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
		$sql = "SELECT e.* FROM tb_evento e where e.tipo_evento_id = ".$tipo_evento_id;

        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { 
			array_push($eventos_array, 
						array("evento_id" => $row["id"]
								, "evento_nome" => $row["nome"]
								, "evento_descricao" => $row["descricao"]
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

	} elseif($acao == "listId"){
		echo listTiposId();
	} elseif($acao == "listaPorTipo") {
		$tiposArray = listTipo();
		$result = array();
		for($i=0; $i<count($tiposArray);$i++) {
			$tipoNome = $tiposArray[$i]["nome"];
			$tipoId = $tiposArray[$i]["id"];
			array_push($result, array("tipo" => $tipoNome
							, "eventos" => listaEventosPorTipo($tipoId)));
		}
		echo json_encode($result);
	}
?>