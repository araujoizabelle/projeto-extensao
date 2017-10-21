<?php
    include("../model/banco.php");

    session_start();
/*
    if($_SESSION['usuarioId'] == null){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('location:../index.html');
    }
*/    
    $acao = $_GET['act'];

    function isHorarioDisponivel($evento_id, $usuario_id){
        $conexao = abrir();

        $sql  = "SELECT horarioEventoDesejado.evento_id, horarioEventoDesejado.data_inicio as inicioEvento, ";
        $sql .= " horarioEventoDesejado.data_termino as fimEvento ";
        $sql .= " FROM tb_horarioEvento horarioEventoDesejado ";
        $sql .= " WHERE horarioEventoDesejado.evento_id = ".$evento_id;

        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $horarioDisponivel = 1; 

        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
            $inicioEvento = $row["inicioEvento"];
            $fimEvento = $row["fimEvento"];
            
            $sql  = "SELECT h.data_inicio as inicio, h.data_termino as fim "; 
            $sql .= " FROM tb_inscricao i inner join tb_horarioEvento h ";
            $sql .= " on h.evento_id = i.evento_id AND i.usuario_id = ".$usuario_id;
            $sql .= " ORDER BY h.data_inicio ASC ";

            $query1 = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));

    //echo "<hr/>evento data do evento desejado: ".$inicioEvento.", fim: ".$fimEvento."<br/>";
            while($row1 = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
                $inicio = $row1["inicio"];
                $fim = $row1["fim"];
    //echo " data evento inscrito ". $inicio.", fim ".$fim."<br/>";
                if(($inicioEvento <= $inicio)&&($fimEvento>$inicio)){
    //echo "começa antes e termina depois um evento inscrito <br/>";
                    $horarioDisponivel =  0;
                    break;
                } 
                if(($inicioEvento>=$inicio)&&($inicioEvento<$fim)) {
    //echo "inicia depois de um evento ter iniciado <br/>";
                    $horarioDisponivel =  0;
                    break;
                }
            }
        }
        fechar($conexao);
        return $horarioDisponivel;

    }

    function isLimiteEsgotado($evento_id) {
        $conexao = abrir();
        $sql = " SELECT count(*) as numInscritos FROM tb_inscricao i WHERE i.evento_id = ".$evento_id;
        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));

        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $numInscritos = $row["numInscritos"];
        $sql = " SELECT qtd_vagas as limite FROM tb_evento e WHERE e.id = ".$evento_id;
        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));

        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $numVagas = $row["limite"];

        fechar($conexao);
        if($numVagas == 0) { //caso não tenha limite cadastrado
            return false;
        }
        return ($numInscritos>=$numVagas); 
    }

//@TODO programar a exceção para evitar tentativas de inscricao em horarios concomitantes
// evitar inscrições em um mesmo evento
    function inscrever($evento_id, $usuario_id){
        $conexao = abrir();

        if(isLimiteEsgotado($evento_id)) {
            return (-1);
        }

        if (isHorarioDisponivel($evento_id, $usuario_id)==true) {          
            $sql  = "INSERT INTO tb_inscricao (usuario_id, evento_id) VALUES ";
            $sql .= "(".$usuario_id.",".$evento_id.")";

            $query = mysqli_query($conexao, $sql); //or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
            $num_rows = mysqli_affected_rows($conexao);

            fechar($conexao);

            if ($num_rows<1) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 0;
        }
    }

    function cancelarInscricao($evento_id, $usuario_id) {
        $conexao = abrir();
        $sql  = "DELETE FROM tb_inscricao WHERE ";
        $sql .= " usuario_id = ".$usuario_id. " AND evento_id = ".$evento_id;
        $query = mysqli_query($conexao, $sql); //or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $num_rows = mysqli_affected_rows($conexao);

        fechar($conexao);

        if ($num_rows<1) {
            return 0;
        }
        return 1;
    }

    function get($evento_id) {      
        $conexao = abrir();
        
        $sql =  " SELECT * FROM tb_evento e ";
        $sql .= " WHERE e.id = ".$evento_id;
        
        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query, MYSQLI_ASSOC); 
        fechar($conexao);
    
        return $result;
    }

    function isInscrito($evento_id, $usuario_id) {
        $conexao = abrir();
        $sql = " SELECT * FROM tb_inscricao ";
        $sql .= " WHERE usuario_id = ".$usuario_id." AND evento_id = ".$evento_id;
        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));

        $result = mysqli_fetch_array($query, MYSQLI_ASSOC); 
        fechar($conexao);
        if($result) {
            return 1;
        }
        return 0;
        
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

    function listarEventos() {
        $conexao = abrir();
        $sql = "SELECT * FROM tb_evento ";

        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        $eventosArray = array();
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            array_push($eventosArray, array("id" => $row["id"]
                            , "nome" => utf8_encode($row["nome"])
                            , "tipo_evento_id" => $row["tipo_evento_id"]
                            , "descricao" => utf8_encode($row["descricao"])));
        }
        fechar($conexao);
        $result = json_encode($eventosArray);
        return $result;
    }

    //listar todas as datas em que o usuario tem inscricoes
    function listarDatasInscricoes($usuario_id) {
//$usuario_id = 2;
        $conexao = abrir();
        $sql  = "SELECT distinct DATE(h.data_inicio) as inicio ";
        $sql .= " FROM tb_horarioEvento h inner join tb_inscricao i ";
        $sql .= " ON i.evento_id = h.evento_id ";
        $sql .= " WHERE i.usuario_id = ".$usuario_id . " "; 
        $sql .= " ORDER BY inicio ASC ";

        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        $dataArray = array();
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            array_push($dataArray, $row["inicio"]);
        }
        fechar($conexao);
        return $dataArray;
    }

    function listarMeusEventos($usuario_id) {
//$usuario_id = 2;
        $conexao = abrir();
        $dataArray = listarDatasInscricoes($usuario_id);
        $objArray = array();
        
        for($i=0; $i<count($dataArray); $i++) {
            $data = $dataArray[$i];
            $sql  = " SELECT e.*, t.nome as tipo, ";
            $sql .= " h.data_inicio as inicio, "; 
            $sql .= " h.data_termino as termino  FROM tb_evento e "; 
            $sql .= " inner join tb_inscricao i on e.id = i.evento_id ";
            $sql .= " inner join tb_horarioEvento h on e.id = h.evento_id ";
            $sql .= " inner join tb_tipoEvento t on e.tipo_evento_id = t.id ";
            $sql .= " WHERE i.usuario_id = ".$usuario_id;
            $sql .= " AND DATE(h.data_inicio) = '".$data. "' ";
            $sql .= " ORDER BY h.data_inicio ASC ";

            $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
            $eventosArray = array();
            while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
                $inicio  = new DateTime($row["inicio"]);
                $termino = new DateTime($row["termino"]);

                array_push($eventosArray, array("id" => $row["id"]
                                , "nome" => utf8_encode($row["nome"])
                                , "horario_inicio" => $inicio->format('H:i')
                                , "horario_fim" => $termino->format('H:i')
                                , "tipo" => $row["tipo"]
                                ));
            }
            array_push($objArray, array("data" => $data
                                   , "programacao" => $eventosArray));
        }
        $result = json_encode($objArray);

        fechar($conexao);
        
        return $result;
    }

    function listHorarioEvento($evento_id) {
        $conexao = abrir();
        $sql =  " SELECT h.*, s.nome as sala FROM tb_horarioEvento h inner join tb_sala s ";
        $sql .= " on s.id = h.sala_id WHERE h.evento_id = ".$evento_id;
        $horarioList = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = array();
        while ($row = mysqli_fetch_array($horarioList, MYSQLI_ASSOC)) { //MYSQL_NUM
            array_push($result, array("data_inicio" => $row["data_inicio"]
                                    , "data_termino" => $row["data_termino"]
                                    , "sala" => $row["sala"]));     
        }
        fechar($conexao);
        return $result;
    }    
    function listAutores($evento_id) {
        $conexao = abrir();
        $sql  =  " SELECT a.* FROM tb_autor a inner join "; 
        $sql .= " autor_tem_evento ae on a.id = ae.tb_autor_id ";
        $sql .= " WHERE ae.tb_evento_id = ".$evento_id;
        $horarioList = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = array();
        while ($row = mysqli_fetch_array($horarioList, MYSQLI_ASSOC)) { //MYSQL_NUM
            array_push($result, array("id" => $row["id"]
                                    , "nome" => $row["nome"]
                                    , "foto" => $row["foto"]
                                    , "lattes" => $row["lattes"]
                                    , "bio" => $row["bio"]));     
        }
        fechar($conexao);
        return $result;
    }    
    function getEventoJson($evento_id){
        $evento = get($evento_id);
        //$foto = ($evento["foto"])?$evento["foto"]:"#";
        $tipoEvento = getTipoEvento($evento["tipo_evento_id"]);
        $result = array("id" => $evento["id"]
                    , "nome" => utf8_encode($evento["nome"])
                    , "descricao" => utf8_encode(nl2br($evento["descricao"]))
                    , "tipo_evento_id" => $evento["tipo_evento_id"]
                    , "tipo" => utf8_encode($tipoEvento["nome"])
                    , "horarios" => listHorarioEvento($evento["id"])
                    , "autores" => listAutores($evento["id"]));
        return json_encode($result);
    }

    function listarJson() {
        $resultArray = listar();
        $total = count($resultArray);
        return json_encode($resultArray);
    }

    function listaPorTipoEData($tipo_id, $data) {
        $conexao = abrir();
        $sql  = " SELECT e.*, t.nome as tipo, s.nome as sala, ";
        $sql .= " h.data_inicio, h.data_termino ";
        $sql .= " FROM tb_evento e inner join tb_tipoEvento t ";
        $sql .= " on e.tipo_evento_id = t.id inner join tb_horarioEvento h ";   
        $sql .= " on h.evento_id = e.id inner join tb_sala s ";
        $sql .= " on s.id = h.sala_id ";
        $sql .= " where e.tipo_evento_id = ".$tipo_id . " AND ";
        $sql .= " DATE(h.data_inicio) = '".$data. "'";
        $sql .= " order by h.data_inicio ASC ";

        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        $eventosArray = array();
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            
            $data_inicio = new DateTime($row["data_inicio"]);
            $data_termino = new DateTime($row["data_termino"]);
            
            array_push($eventosArray, array("id" => $row["id"]
                                , "nome" => utf8_encode($row["nome"])
                                , "descricao" => utf8_encode($row["descricao"])
                                , "tipo" => utf8_encode($row["tipo"])
                                , "sala" => utf8_encode($row["sala"])
                                , "hora_inicio" => $data_inicio->format('H:i')
                                , "hora_termino" => $data_termino->format('H:i')
                            ));

        }
        fechar($conexao);
        return json_encode($eventosArray);
    }

    function listaPorDataHorario($data_inicio, $data_fim) {
        $conexao = abrir();
        $inicioTime = strtotime($data_inicio);
        $inicio = date('Y-m-d H:i',$inicioTime);
        $fimTime = strtotime($data_fim);
        $termino = date('Y-m-d H:i',$fimTime);

        $sql  = " SELECT h.data_inicio as inicio, h.data_termino as fim, e.id, e.nome, t.nome as tipo, s.nome as local ";
        $sql .= " FROM tb_horarioEvento h inner join tb_evento e ";
        $sql .= " on h.evento_id = e.id inner join tb_tipoEvento t ";
        $sql .= " on t.id = e.tipo_evento_id inner join tb_sala s ";
        $sql .= " on s.id = h.sala_id ";
        $sql .= " WHERE (h.data_inicio >= \"".$inicio."\" AND h.data_inicio < \"".$termino."\") ";
        //$sql .= " OR (h.data_inicio < \"".$inicio."\" AND h.data_termino >= \"".$termino."\") ";
        $sql .= " ORDER BY h.data_inicio ASC ";


        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        $eventosArray = array();
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $inicio = new DateTime($row["inicio"]);
            $fim = new DateTime($row["fim"]);
            array_push($eventosArray, array("id" => $row["id"]
                                        , "nome" => utf8_encode($row["nome"])
                                        , "inicio" => $inicio->format('H:i')
                                        , "fim" => $fim->format('H:i')
                                        , "tipo" => utf8_encode($row["tipo"])
                                        , "local" => utf8_encode($row["local"])));
        }
        return json_encode($eventosArray);
    }

    function listaEventosPorData($data_evento) {
        $conexao = abrir();
        $inicio = $data_evento." 00:00:00";
        $termino = $data_evento." 23:59:59";

        $sql  = " SELECT h.data_inicio as inicio, h.data_termino as fim, ";
        $sql .= " e.id, e.nome, t.nome as tipo, s.nome as local ";
        $sql .= " FROM tb_horarioEvento h inner join tb_evento e ";
        $sql .= " on h.evento_id = e.id inner join tb_tipoEvento t ";
        $sql .= " on t.id = e.tipo_evento_id inner join tb_sala s ";
        $sql .= " on s.id = h.sala_id ";
        $sql .= " WHERE (h.data_inicio >= \"".$inicio."\" AND h.data_inicio < \"".$termino."\") ";
        //$sql .= " OR (h.data_inicio < \"".$inicio."\" AND h.data_termino >= \"".$termino."\") ";
        $sql .= " ORDER BY h.data_inicio ASC ";


        $query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        $eventosArray = array();
        while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
            $inicio = new DateTime($row["inicio"]);
            $fim = new DateTime($row["fim"]);
            array_push($eventosArray, array("id" => $row["id"]
                                        , "nome" => utf8_encode($row["nome"])
                                        , "inicio" => $inicio->format('H:i')
                                        , "fim" => $fim->format('H:i')
                                        , "tipo" => utf8_encode($row["tipo"])
                                        , "local" => utf8_encode($row["local"])));
        }
        return json_encode($eventosArray);
    }

    if($acao == "inscricao1") {
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
    } elseif ($acao == "get") {
        $evento_id = $_GET["id"];
        echo getEventoJson($evento_id);
    } elseif ($acao == "list") {
        if($_GET["tipo"]!=null && $_GET["data"]!=null) {
            echo listaPorTipoEData($_GET["tipo"], $_GET["data"]);
        } else {
            echo listarEventos();
        }
    } elseif ($acao == "listByDateTime"){
        echo listaPorDataHorario($_GET["begin"], $_GET["end"]);
    } elseif ($acao =="listaEventosPorData"){
        echo listaEventosPorData($_GET["data"]);
    } elseif ($acao == "inscricao") {
        $result = inscrever($_GET["evento_id"], $_GET["usuario_id"]);
        //header("location:../evento.php?data=".$result); 
        echo $result;
        /*
        if($result == -1) {
            echo "limiteEsgotado"; 
        } elseif($result==0) {
            echo "erroAoInserir"; 
        } elseif ($result==1) {
            echo "sucesso"; 
        }
        */
    } elseif($acao=="listMyEvents") {
        echo listarMeusEventos($_GET["usuario_id"]);
    } elseif($acao=="removeInscricao"){
        echo cancelarInscricao($_GET["evento_id"], $_GET["usuario_id"]);
    } elseif($acao=="inscrito"){
        echo isInscrito($_GET["evento_id"],$_GET["usuario_id"]);
    } elseif ($acao=="teste") {
        $evento_id = $_GET["evento_id"];
        $usuario_id = $_GET["usuario_id"];
        isInscrito($evento_id, $usuario_id);
//         echo listarDatasInscricoes($usuario_id);
    }


?>