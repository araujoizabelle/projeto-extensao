<?php 

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Origin', 'http://botanicapp.com.br');

	
	define("SERVERNAME", "localhost:3306");
	define("USERNAME", "root"); 
	define("PASSWORD", "root");
	define("DATABASE", "bd_evento");  

	header('Content-Type: text/html; charset=utf-8');

	function conectarBD(){
		echo "teste";
		/*
		$link = mysql_connect(SERVERNAME, USERNAME, PASSWORD);
		if (!$link) {
	    	die('Não foi possível conectar: ' . mysql_error());
	    	//echo "não abriu conexao";
		} else {
			//echo 'Conexão bem sucedida';
		}
		$conexao = mysql_select_db(DATABASE,$link); 

		mysql_query("SET NAMES 'utf8'");
		mysql_query('SET character_set_connection=utf8'); // Indicação da codificação usada na ligação
		mysql_query('SET character_set_client=utf8'); //Indicação da codificação que o cliente está a usar
		mysql_query('SET character_set_results=utf8'); //Indicação da codificação de retorno das consultas à BD

		return $conexao;
		*/
	}
?>