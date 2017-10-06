<?php

    var $local = 'localhost';
    var $user =  'root';
    var $senha = 'root';
    var $msg0 = 'Conexão falou, erro: '.mysqli_error();
    var $msg1 = 'Não foi possível selecionar o banco de dados!';
    var $nome_db  = 'bd_evento';
    
    
    function abrir(){
        $link = mysqli_connect($local,$user,$senha) or die($msg0);
        mysqli_select_db($link,$nome_db) or die($msg1);
    }
    
    function fechar(){
        //analisar se o mysql_close precisa ser colocado numa variável
        $closed = mysqli_close($link);
        $closed = NULL;
    }
/*
    public function insert($objeto){ 
        $db = new Banco();
        $db->abrir();
        
        $params = "";

        foreach ($objeto->getCampos() as $campo) {
            $params .= $campo.",";
        }
        $size = strlen($params);
        $params = substr($params, 0, $size-1);

        $sql = "INSERT INTO ".$objeto->getNomeTabela()."(".$params.") VALUES ( ".$objeto->getValorCampos().")";
        
        $query = mysqli_query($db->link, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($db->link));
        $db->fechar(); 

        $temp_id = explode('_',$objeto->getNomeTabela());

        unset($objeto);

        header('location: '.$temp_id[1].'.php?msg=Inserido');
    }

    public function update($objeto) {
        $db = new Banco();
        $db->abrir();
        $params = "";

        foreach ($objeto->getValorCamposArray() as $key => $value) {
            $params .= "".$key." = '".$value. "' AND ";
        }
        $size = strlen($params);
        $params = substr($params, 0, $size-4);

        $sql = "UPDATE ".$objeto->getNomeTabela();
        $sql .= " SET ".$params." WHERE id = '".$objeto->getId()."'";

        $query = mysqli_query($db->link, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($db->link));
        $db->fechar(); 

        $temp_id = explode('_',$objeto->getNomeTabela());

        unset($objeto);

        header('location: '.$temp_id[1].'.php?msg=Atualizado');

    }

    public function selectData($tb_name, $fieldsVal) {
        $db = new Banco();
        $db->abrir();

        $sql = "SELECT * FROM ". $tb_name;

        $params = "";

        if(count($fieldsVal)) {
            $params .= " WHERE ";
            foreach ($fieldsVal as $key => $value) {
                $params .= $key . " = ". $value. " AND ";
            }
        }
        $size = strlen($params);
        $params = substr($params, 0, $size-4);

        $sql .= $params;

        $query = mysqli_query($db->link, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($db->link));
        
        $db->fechar();
        return mysqli_fetch_array($query);
    }
    
    public function delete($object, $fieldsVal) {
        $db = new Banco();
        $db->abrir();

        $sql = "DELETE FROM ". $object->getNomeTabela();

        $params = "";

        if(count($fieldsVal)) {
            $params .= " WHERE ";
            foreach ($fieldsVal as $key => $value) {
                $params .= $key . " = ". $value. " AND ";
            }
        }
        $size = strlen($params);
        $params = substr($params, 0, $size-4);

        $sql .= $params;

        $query = mysqli_query($db->link, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($db->link));
        
        $db->fechar();
        return mysqli_fetch_array($query);
    }

} //class

*/

?>