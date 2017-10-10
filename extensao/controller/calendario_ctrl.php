<?php
	include("model/banco.php");
	
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