<?php
	//include("../model/banco.php");

	$email = $_POST["email"];
    $senha = $_POST["senha"];
    $acao = $_GET["act"];

    if($acao == "login") {
    	//$isAuth = autenticar($email, $senha);
    	if($isAuth) {
    		header("location:../home.html");
    	} else {
    		header("location:../index.html?msg=loginIncorreto");
    	}
    } elseif ($acao == "add") {

    }
    /*
    function autenticar($email, $senha) {
    	abrir();
    	$sql = "SELECT * FROM tb_usuario WHERE email = ".$email." AND senha = ".$senha;

    	$query = mysqli_query($db->link, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($db->link));
        
        
        $result = mysqli_fetch_array($query);
    	fechar();

    	if($result) {
    		return true;
    	}
    	return false;
    	
    }
    */
?>