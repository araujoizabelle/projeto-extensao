<?php 

class Evento {
	var $id; 
	var $nome;
	var $data_inscricao;
	var $tipo_evento_id;


    function Evento($id, $nome, $data_inscricao, $tipo_evento_id) {
        $this->id = $id;
        $this->nome = $nome;
        $this->data_inscricao = $data_inscricao;
        $this->tipo_evento_id = $tipo_evento_id;
    }

    function getId(){
		return $this->id;
    }

    function setId($id) {
        $this->id = $id;
    }

    function getNome(){
		return $this->nome;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function getDataInscricao(){
		return $this->data_inscricao;
    }

    function setDataInscricao($data_inscricao) {
        $this->data_inscricao = $data_inscricao;
    }

    function getTipoEventoId(){
		return $this->tipo_evento_id;
    }

    function setTipoEventoId($tipo_evento_id) {
        $this->tipo_evento_id = $tipo_evento_id;
    }
}
?>