<?php 
	include("../tipo_evento.php");

class TipoEventoDao{
	var $db;

	public function __construct() {
		$this->db = new Banco();
	}

	public function getDb() {
		return $this->db;
	}
	
	public function add($object) {
		$this->getDb()->insert($object);
	}

	public function update($object) {
		$this->getDb()->update($object);
	}

	public function get($object, $fieldVals) {
		$resultArray = $this->getDb()->selectData($object->getNomeTabela(), $fieldVals);
		$object->setDados($resultArray["id"], $resultArray["nome"]);
		return $object;
	}

	public function delete($object, $fieldVals) {
		$this->getDb()->delete($object, $fieldVals);
	}

	
	public function list($object, $fieldVals) {
		$resultArray = $this->getDb()->selectData($this->getNomeTabela(), $fieldVals);
		$list = array();
		$temp = new TipoEvento();
		for($i=0; $i<count($resultArray); $i++) {
			$temp->setDados($resultArray["id"], $resultArray["nome"]);
			array_push($list, $temp);
		}
		return $list;
	}
	

}
?>