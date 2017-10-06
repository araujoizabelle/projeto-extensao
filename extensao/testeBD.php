<?php 
/*
	$conecta = mysql_connect("localhost:3306", "root", "") or print (mysql_error()); 
	print "Conexão OK!"; 
	mysql_close($conecta); 
*/
	$con = @mysqli_connect('localhost', 'estagiario', 'semextensao', 'bd_evento');

	if (!$con) {
	    echo "Error: " . mysqli_connect_error();
		exit();
	}
	echo 'Connected to MySQL';

	// Close connection
	mysqli_close ($con);
?>