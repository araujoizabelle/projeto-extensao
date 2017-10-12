<?php
	include("../model/banco.php");
	
	function listar() {    	
    	$conexao = abrir();
        
    	$sql =  " SELECT e.id, e.nome, h.data_inicio, h.data_termino, t.id, t.nome ";
        $sql .= " FROM tb_evento e, tb_horarioEvento h, tb_tipoEvento t ";
        $sql .= " WHERE e.id = h.evento_id AND e.tipo_evento_id = t.id ";
        $sql .= " group by h.data_inicio ";
        $sql .= " order by h.data_inicio ASC ";
        

        //$sql = "SELECT * from tb_evento";

    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC); //MYSQLI_BOTH  //MYSQLI_NUM //MYSQLI_ASSOC
    	fechar($conexao);
   	
        return $query;
    	//return $query;
    }

    function listarAutores($evento_id){
        $conexao = abrir();
        
        $sql =  " SELECT a.id, a.nome, a.foto, a.bio ";
        $sql .= " FROM tb_evento e, autor_tem_evento ae, tb_autor a ";
        $sql .= " WHERE a.id = ae.tb_autor_id AND ae.tb_evento_id = e.id AND ";
        $sql .= " e.id = ". $evento_id;
        
        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $resultArray = array(); 
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, array("autor_id" => $row["id"], 
                                        "autor_nome" => $row["nome"],
                                        "autor_foto" => $row["foto"],
                                        "autor_bio" => $row["bio"]
                                        ));
        }
        fechar($conexao);
    
        return $resultArray;
    }

    function listarEvento($evento_id) {
        $conexao = abrir();
        
        $sql =  " SELECT e.id, e.nome, e.descricao, t.nome as tipo ";
        $sql .= " FROM tb_evento e, tb_tipoEvento t";
        $sql .= " WHERE e.tipo_evento_id = t.id AND e.id = ".$evento_id;
        
        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $resultArray = array(); 
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            array_push($resultArray, array("evento_id" => $row["id"], 
                                        "evento_nome" => $row["nome"],
                                        "evento_tipo" => $row["tipo"],
                                        "evento_descricao" => $row["descricao"],
                                        "evento_autores" => listarAutores($row["id"])
                                        ));
        }
        fechar($conexao);
    
        return $resultArray;
        
    }

    function listarHorarioEvento() {
        $conexao = abrir();

        $sql  = " SELECT h.evento_id, h.data_inicio, h.data_termino ";
        $sql .= " FROM tb_horarioEvento h ";
        $sql .= " group by h.data_inicio ";
        $sql .= " order by h.data_inicio ASC ";

        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $resultArray = array(); 
        while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){

            $data_inicio = new DateTime($row["data_inicio"]);
            $data_termino = new DateTime($row["data_termino"]);
            
            array_push($resultArray, array(
                                        "data" => $data_inicio->format('d/m/Y'),
                                        "hora_inicio" => $data_inicio->format('H:i'), 
                                        "hora_termino" => $data_termino->format('H:i'),
                                        "eventos" => listarEvento($row["evento_id"]) ));
        }
        fechar($conexao);
        echo json_encode($resultArray);
    }

    $acao = $_GET["act"];
    if($acao == "list") {
        listarHorarioEvento();
    } elseif($acao == "get") {
        echo json_encode(listarEvento($_GET["evento_id"]));
    }
    
?>