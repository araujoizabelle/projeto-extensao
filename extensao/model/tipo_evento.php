<?php 
	//include("utils/bd_utils.php");

class TipoEvento {

	private $nome_tabela = "tb_TipoEvento";
	private $campos = array("nome");
	var $id;
	var $nome;

	public function setDados($evento_tipo_id, $nome){
		if(isset($evento_tipo_id)){
			$this->id = $evento_tipo_id; 
		} else {
			$this->id = null;
		}
		$this->nome = $nome;
	}

	public function getId(){
		return $this->id;
	}
	public function getNome(){
		return $this->nome;
	}

	public function setNome($nome) {
		$this->nome = $nome;
	}

	public function getNomeTabela() {
		return $this->nome_tabela;
	}

	public function getCampos() {
		return $this->campos;
	}

	public function getValorCamposArray() {
		return array("nome" => $this->nome);
	}
	public function getValorCampos() {
		return "'".$this->nome."'";
	}
	/*

	public function get($fieldVals, $db) {
		$resultArray = $db->selectData($this->getNomeTabela(), $fieldVals);
		$this->setDados($resultArray["id"], $resultArray["nome"]);
		return $this;
	}

	
	public function delete($fields, $values, $db) {
		$db->delete($this->getNomeTabela(), $fields, $values);
	}
	*/

}

?>