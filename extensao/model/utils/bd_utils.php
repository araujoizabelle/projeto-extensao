<?php 

	header('Access-Control-Allow-Origin: *');
	header('Access-Control-Allow-Origin', 'http://botanicapp.com.br');

	
	define("SERVERNAME", "localhost");
	define("USERNAME", "root"); 
	define("PASSWORD", "root");
	define("DATABASE", "bd_evento");  

	header('Content-Type: text/html; charset=utf-8');

	function conectarBD(){
		$con = @mysqli_connect(SERVERNAME, USERNAME, PASSWORD, DATABASE);

		if (!$con) {
			echo "Error: " . mysqli_connect_error();
			exit();
		}
/*
		mysqli_query("SET NAMES 'utf8'");
		mysqli_query('SET character_set_connection=utf8'); // Indicação da codificação usada na ligação
		mysqli_query('SET character_set_client=utf8'); //Indicação da codificação que o cliente está a usar
		mysqli_query('SET character_set_results=utf8'); //Indicação da codificação de retorno das consultas à BD
*/	
		return $con;		
	}
?>