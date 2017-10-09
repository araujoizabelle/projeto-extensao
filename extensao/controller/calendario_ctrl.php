<?php
	include("model/banco.php");
	
	function listar() {    	
    	$conexao = abrir();
        
    	$sql =  "SELECT * FROM tb_evento e left join tb_horarioEvento h ";
        $sql .= " on e.id = h.evento_id ";
        $sql .= " left join tb_tipoEvento t "; 
        $sql .= " on e.tipo_evento_id = t.id";
        

        //$sql = "SELECT * from tb_evento";

    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC); //MYSQLI_BOTH  //MYSQLI_NUM //MYSQLI_ASSOC
    	fechar($conexao);
   	
        return $query;
    	//return $query;
    }

    function listarJson() {
        $resultArray = listar();
        $total = count($resultArray);
        /*
        $resultStr = "[";
        while($row = mysql_fetch_assoc($resultArray)) {
            $resultStr .= json_encode($row);
            $resultStr .= ",";
        } 
        if($total>0) {
            $resultStr .= substr($resultStr,0, $resultStr-1);
        }
        $resultStr .= "]";
        */
        
        return json_encode($resultArray);
    }
?>