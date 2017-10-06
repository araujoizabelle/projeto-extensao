<?php
	include("../model/banco.php");
	include("../model/tipo_evento.php");
	include("../model/dao/tipo_evento_dao.php");

	$acao = $_GET["act"];

	$tipoEvento = new TipoEvento();
	$tipoEventoDao = new TipoEventoDao();

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


?>