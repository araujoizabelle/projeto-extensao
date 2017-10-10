<?php
	include("../model/banco.php");

    session_start();

    if($_SESSION['usuarioId'] == null){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('location:../index.html');
    }
    
    $acao = $_GET['act'];


    function inscrever($evento_id, $usuario_id){
        $sql  = "INSERT INTO tb_inscricao (participante_id, evento_id) VALUES ";
        $sql .= "(".$usuario_id.",".$evento_id.")";
        $conexao = abrir();
        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        fechar($conexao);
        if ($result) {
            fechar($conexao);
            return true;
        } else {
            return false;
        }
    }

	function get($evento_id) {    	
    	$conexao = abrir();
        
    	$sql =  " SELECT * FROM tb_evento e ";
        $sql .= " WHERE e.id = ".$evento_id;
        
    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC); //MYSQLI_BOTH  //MYSQLI_NUM //MYSQLI_ASSOC
    	fechar($conexao);
   	
        return $result;
    }

    function getTipoEvento($tipo_evento_id) {
        $conexao = abrir();
        
        $sql =  " SELECT * FROM tb_tipoEvento t ";
        $sql .= " WHERE t.id = ".$tipo_evento_id;
        
        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC); //MYSQLI_BOTH  //MYSQLI_NUM //MYSQLI_ASSOC
        fechar($conexao);
    
        return $result;
    }

    function listHorarioEvento($evento_id) {
        $conexao = abrir();
        
        $sql =  " SELECT * FROM tb_horarioEvento h WHERE h.id = ".$evento_id;
        
        $horarioList = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        $json_str = '"horarios": [';
        while ($row = mysqli_fetch_array($horarioList, MYSQLI_ASSOC)) { //MYSQL_NUM
            $json_str .= '{"data_inicio": "'.$row["data_inicio"];
            $json_str .= '", "data_termino": "'.$row["data_termino"].'" }';     
        }
        $json_str .= "]";

        fechar($conexao);
    
        return $json_str;
    }    

    function getEventoJson($evento_id){
        $evento = get($evento_id);
        $foto = ($evento["foto"])?$evento["foto"]:"#";
        $tipoEvento = getTipoEvento($evento["tipo_evento_id"]);
        $json_str  = '{"id":"'.$evento["id"].'", "nome": "'.$evento["nome"].'", "autor": "'.$evento["autor"];
        $json_str .= '", "descricao":"'.$evento["descricao"].'", "autor_bio":"';
        $json_str .= $evento["autor_bio"].'", "foto":"'.$foto;
        $json_str .= '", "tipo":"'.$tipoEvento["nome"].'", ';
        $json_str .= listHorarioEvento($evento["id"]);
        $json_str .= "}";
        return $json_str;
    }

    function listarJson() {
        $resultArray = listar();
        $total = count($resultArray);
        
        return json_encode($resultArray);
    }


    
    if($acao == "inscricao") {
        $evento_id = $_GET["id"];
        $usuario_id = $_SESSION["usuarioId"];
        $result = inscrever($evento_id, $usuario_id);
        
        if($result) {
            header("location:../home.html?msg=inscricaoEfetuada"); 
        } else {
            header("location:../home.html?msg=erro"); 
        }

    } elseif ($acao == "get") {

        $evento_id = $_GET["id"];
        echo getEventoJson($evento_id);

/*
        
        if($_POST["evento"]) {
            header("location:../evento.html"); 
        } else {
            header("location:../index.html?msg=emailJaCadastrado"); 
        }
        */
    }
?>