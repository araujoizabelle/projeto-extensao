<?php
	include("../model/banco.php");

    session_start();

    if($_SESSION['usuarioId'] == null){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('location:../index.html');
    }
    
    $acao = $_GET['act'];


//@TODO programar a exceção para evitar tentativas de inscricao em horarios concomitantes
// evitar inscrições em um mesmo evento
    function inscrever($evento_id, $usuario_id){
        $sql  = "INSERT INTO tb_inscricao (usuario_id, evento_id) VALUES ";
        $sql .= "(".$usuario_id.",".$evento_id.")";

        $conexao = abrir();
        $query = mysqli_query($conexao, $sql);// or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $num_rows = mysqli_affected_rows($conexao);
        fechar($conexao);

        if ($num_rows<1) {
            return false;
        } else {
            return true;
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

    function isHorarioDisponivel($evento_id, $usuario_id){
        $conexao = abrir();

        $sqlDataNovo  = " select h.data_inicio, h.data_termino ";
        $sqlDataNovo .= " from tb_evento e, tb_horarioEvento h ";
        $sqlDataNovo .= " where e.id = h.evento_id and e.id = ".$evento_id;

        $sqlDataInscrito  = " select h.data_inicio, h.data_termino ";
        $sqlDataInscrito .= " from tb_inscricao i, tb_horarioEvento h";
        $sqlDataInscrito .= " where i.evento_id = h.evento_id and ";
        $sqlDataInscrito .= " i.usuario_id = ".$usuario_id;


        $horarioNovoList = mysqli_query($conexao, $sqlDataNovo) or die ("Deu erro na query: ".$sqlDataNovo.' '.mysqli_error($conexao));

        $horarioInscritoList = mysqli_query($conexao, $sqlDataInscrito) or die ("Deu erro na query: ".$sqlDataInscrito.' '.mysqli_error($conexao));
        
        while ($rowNovo = mysqli_fetch_array($horarioNovoList, MYSQLI_ASSOC)) {
            $dataNovoInicio = strtotime($rowNovo["data_inicio"]);
            $dataNovoTermino = strtotime($rowNovo["data_termino"]);

            while ($rowInscrito = mysqli_fetch_array($horarioInscritoList, MYSQLI_ASSOC)) {
               
                $dataInscritoInicio = strtotime($rowInscrito["data_inicio"]);
                $dataInscritoTermino = strtotime($rowInscrito["data_termino"]);

                if($dataNovoInicio<=$dataInscritoTermino
                    && $dataNovoInicio>=$dataInscritoInicio) {
                    fechar($conexao);
                    return false;
                }
                if($dataNovoTermino<=$dataInscritoTermino 
                    && $dataNovoTermino>=$dataInscritoInicio) {
                    fechar($conexao);
                    return false;
                }
            }
        }
        fechar($conexao);
        return true;
    }

    
    if($acao == "inscricao") {
        $evento_id = $_GET["id"];
        $usuario_id = $_SESSION["usuarioId"];

        if(isHorarioDisponivel($evento_id, $usuario_id)) {
            $result = inscrever($evento_id, $usuario_id);
            if($result == true) {
                header("location:../home.php?msg=inscricaoEfetuada"); 
            } else {
                header("location:../home.php?msg=erro"); 
            }
        } else {
            header("location:../programacao.php?msg=conflitoHorario"); 
        }
    //echo $result;

        

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