<?php
	include("../model/banco.php");
//	include("../model/tipo_evento.php");
//	include("../model/dao/tipo_evento_dao.php");

	$acao = $_GET["act"];
/*
	$tipoEvento = new TipoEvento();
	$tipoEventoDao = new TipoEventoDao();
*/
	function getTipoId($tipo) {
    	$conexao = abrir();
    	$sql = "SELECT * FROM tb_tipo_evento t";
    	$sql .= " WHERE t.nome LIKE %".$tipo."%";
    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query);

    	fechar($conexao);
    	return $result["id"];
    }

    function getTipo($id) {
    	$conexao = abrir();
    	$sql = "SELECT * FROM tb_tipo_evento t";
    	$sql .= " WHERE t.id = ".$id;
    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query);

    	fechar($conexao);
    	return $result["nome"];	
    }

	function listTiposId(){
		$conexao = abrir();
		$sql = "SELECT t.id FROM tb_tipoEvento t ";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
		$result = array();
		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) { 
			array_push($result, $row["id"]);
		}
		fechar($conexao);
		return json_encode($result);
	}


    if($_GET["act"] == "getId") {
    	echo getTipoId($_GET["tipo"]);
    } elseif($_GET["act"] =="listId"){
    	echo listTiposId();
    }

    /*

	if($acao == "add") {
		$tipoEvento->setDados(null, $_POST["nome"]);	
		
		$tipoEventoDao->add($tipoEvento);

		header('location: tipoEvento.php?msg=Cadastrado');
	} elseif ($acao == "update") {
		$tipoEvento->setDados($_POST["id"], $_POST["nome"]);
		
		$tipoEventoDao->update($tipoEvento);

		header('location: tipoEvento.php?msg=Atualizado');
	} elseif ($acao == "get") {
		$fieldVals = array("id" => $_POST["id"]);
		
		$obj = $tipoEventoDao->get($tipoEvento, $fieldVals); 
		
        header('location: tipoEvento.php');
	} elseif ($acao == "delete") {
		$fieldVals = array("id" => $_POST["id"]);
		
		$obj = $tipoEventoDao->delete($tipoEvento, $fieldVals); 
		
        header('location: tipoEvento.php');
	}
	
	unset($tipoEvento);
	unset($tipoEventoDao);

	*/
?>