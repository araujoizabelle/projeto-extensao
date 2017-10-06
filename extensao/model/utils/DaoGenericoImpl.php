<?php


class DaoGenericoImpl implements DaoGenerico {

    public function salvar($objeto) {
    	//$my_class = new myclass();

		$class_vars = get_class_vars(get_class($objeto));

		foreach ($class_vars as $name => $value) {
    		echo "$name : $value\n";
		}
/*
		$codigo = $objeto->codigo; 
		$data_inscricao = $objeto->data_inscricao;
		$tipo_evento_id = $objeto->tipo_evento_id;
		try {

		    $PDO = new PDO( 'mysql:host=' . SERVERNAME . ';dbname=' . DATABASE, USERNAME, PASSWORD );
		}
		catch ( PDOException $e ) {
		    echo 'Erro ao conectar com o MySQL: ' . $e->getMessage();
		}

		$this->codigo = $codigo;
		$this->codigo = $codigo;
		$descricao = $post["descricao"];
		$foto = "http://botanicapp.com.br/receitas/food.png";
		$preparo = $post["preparo"];
		$ingredientes = $post["ingredientes"];

		$conexao = conectarBD();

		$sql = "insert into receita (nome, descricao, foto, preparo, ingredientes) ".
				" values ('{$nome}', '{$descricao}', '{$foto}', '{$preparo}', '{ $ingredientes}') "; 

echo $sql;

		$insert = mysql_query($sql);

		if($insert) {
			echo "receita cadastrada com sucesso<br/>";
		} else {
			echo "erro ao salvar <br/>". mysql_error();  
		}
		$receitaId = 0; //mysql_insert_id();

		//fechando conexao
		mysql_close($conexao);
		return $receitaId;
	}
	*/
    }

	public function alterar($objeto);
	public function excluir($objeto);
	
	public function buscarId($key);	
	public function buscar($query, $params);	
	
	public function todos();
	public function listarQuery($query);	
	public function listarQuery($query, $params);
	
}

?>