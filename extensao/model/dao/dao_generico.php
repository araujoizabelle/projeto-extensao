<?php
class DaoGenerico {
    private $local;
    private $user;
    private $senha;
    private $msg0;
    private $msg1;
    private $nome_db;
    private $link;

    public function __construct(){
        $this->local    =       'localhost';
        $this->user     =       'root';
        $this->senha    =       'root';
        $this->msg0     =       'Conexão falou, erro: '.mysqli_error();
        $this->msg1     =       'Não foi possível selecionar o banco de dados!';
        $this->nome_db  =       'bd_evento';
    }
    
    public function abrir(){
        $this->link = mysqli_connect($this->local,$this->user,$this->senha) or die($this->msg0);
        mysqli_select_db($this->link,$this->nome_db) or die($this->msg1);
    }
    
    public function fechar(){
        //analisar se o mysql_close precisa ser colocado numa variável
        $closed = mysqli_close($this->link);
        $closed = NULL;
    }

    public function insert($objeto){ 
        $db = new Banco();
        $db->abrir();
        
        $params = "";

        foreach ($objeto->getCampos() as $campo) {
            $params .=$campo.",";
        }
        $size = strlen($params);
        $params = substr($params, 0, $size-1);

        $sql = "INSERT INTO ".$objeto->getNomeTabela()."(".$params.") VALUES ( ".$objeto->getValorCampos().")";
        
        $query = mysqli_query($db->link, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($db->link));

        $db->fechar(); 
        unset($objeto);
        $temp_id = explode('_',$objeto->getNomeTabela());
        header('location: '.$temp_id[1].'.php?msg=Inserido');
    }

    public function update($objeto){ 
            $db = new Banco();
            $db->abrir();

            $sql = "UPDATE ".$objeto->getNomeTabela()." SET ";
            foreach ($objeto->getCampos() as $campo) {
                    $sql .= $campo." = ". // como descobrir o valor correspondente???
            }
            $sql .= " WHERE id = ". $objeto->getId();
            
            $query = mysqli_query($db->link, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($db->link));

            $db->fechar(); 
            unset($objeto);
            $temp_id = explode('_',$objeto->getNomeTabela());
            header('location: '.$temp_id[1].'.php?msg=Alterado');
    }

    public function buscaValor($campo, $tb_name, $fields_where, $values_where) {
        $qtd = count($fields_where);
        if ($qtd != count($values_where)){ // verifica o numero de fields e values 
            echo ("Função: selectDataDb. Erro: Quantidade de campos diferente da quantidade de valores");
        }
        else {
            // Monta a string SQL=====================
            $sql = "select ".$campo." from ".$tb_name;
            if ($qtd != 0 ) {
                for ($j=1;$j<=$qtd;$j++) {
                    if ($j == 1) { 
                        $sql .= ' where '; 
                    } //garante que o where entre caso tenha algum parâmetro
                    $sql .= $fields_where[$j].' = '.$values_where[$j];              
                    if ($j<$qtd ) { 
                        $sql .= ' and '; 
                    }
                }
            } //=======================================
            $res = mysqli_query($sql) or die ($sql .mysqli_error());
            $linha = mysqli_fetch_array($res);
            return $linha[$campo]; // retorna o valor do campo especifico, com os parametros enviados (podendo ser nenhum ou vários)
        }//else
    }
    
    public function selectData($tb_name,$fields_where,$values_where){ 
        // nome da tabela, vetores: campos(fields), valores(values) da consulta
        $obj = explode('_',$tb_name);
        $new_objeto = new $obj[1];
        $db = new Banco();
        $db->abrir();
        $fieldInfo = mysqli_fetch_fields($this->nome_db,$tb_name); // informa os fields/campos da 
        print_r($fieldInfo);
        /*
        $fields_name = array();
        foreach ($fiedlInfo as field) {
            array_push($fields_name, $field->name);
            $fields_values = $this->BuscaValor(mysql_field_name($fields, $i),$tb_name,$fields_where,$values_where); 
            $new_objeto->$fields_name = $fields_values;
        }
        //$columns = mysql_num_fields($fields); //conta o número de campos
        for ($i = 0; $i < $columns; $i++) {
                $fields_name    = mysql_field_name($fields, $i);
                $fields_values = $this->BuscaValor(mysql_field_name($fields, $i),$tb_name,$fields_where,$values_where); 
                $new_objeto->$fields_name = $fields_values;
        }
        */
        $db->fechar();
        return $new_objeto;
    }
} //class

?>