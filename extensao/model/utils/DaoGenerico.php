<?php

interface DaoGenerico {
    
    public function salvar($objeto);
	public function alterar($objeto);
	public function excluir($objeto);
	
	public function buscarId($key);	
	public function buscar($query, $params);	
	
	public function todos();
	public function listarQuery($query);	
	public function listarQuery($query, $params);
	
}

?>