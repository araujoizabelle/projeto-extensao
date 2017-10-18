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
        
        $row = mysqli_fetch_array($query, MYSQLI_ASSOC);
        $inicioEvento = $row["inicioEvento"];
        $fimEvento = $row["fimEvento"];

        $temConflito = false; 
        
        $sql  = "SELECT h.data_inicio as inicio, h.data_termino as fim "; 
        $sql .= " FROM tb_inscricao i inner join tb_horarioEvento h ";
        $sql .= " on h.evento_id = i.evento_id AND i.usuario_id = ".$usuario_id;

        $query1 = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));


        while($row1 = mysqli_fetch_array($query1, MYSQLI_ASSOC)) {
            $inicio = $row1["inicio"];
            $fim = $row1["fim"];

            if((($inicioEvento <= $inicio)&&($fimEvento>=$fim)) ||
                (($fimEvento>$inicio)&&($fimEvento<=$fim)) ||
                (($inicioEvento>=$inicio)&&($inicioEvento<$fim))) {
                $temConflito = true;
            }
        }
        fechar($conexao);
        return $temConflito;

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

        if (isHorarioDisponivel($evento_id, $usuario_id)) {
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
$usuario_id = 2;
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
$usuario_id = 2;
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
        $sql .= " on s.id = h.sala_id WHERE h.id = ".$evento_id;
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

        $sql  = " SELECT h.data_inicio as inicio, e.id, e.nome, t.nome as tipo, s.nome as local ";
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
            array_push($eventosArray, array("id" => $row["id"]
                                        , "nome" => utf8_encode($row["nome"])
                                        , "inicio" => $inicio->format('H:i')
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
    } elseif ($acao == "inscricao") {
        
        echo inscrever($_GET["evento_id"], $_GET["participante_id"]);
        
    } elseif($acao=="listMyEvents") {
        echo listarMeusEventos($_SESSION["usuarioId"]);
    } elseif ($acao=="teste") {
         echo listarDatasInscricoes($usuario_id);
    }


/*
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
*/

?>