<?php
	include("../model/banco.php");

	$email = $_POST["email"];
    $senha = $_POST["senha"];
    $acao = $_GET["act"];
	
	
	function autenticar($email, $senha) {
    	
    	$conexao = abrir();
    	
    	$sql = "SELECT * FROM tb_usuario WHERE email = '".$email."' AND senha = '".$senha."'" ;


    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        
        $result = mysqli_fetch_array($query);

        print_f($result);
    	
    	fechar($conexao);
/*
    	if($result) {
    		return true;
    	}
    	
    	return false;
  */  	
    }
/*
    if($acao == "login") {
    	$isAuth = autenticar($email, $senha);
    	if($isAuth) {
    		session_start($userId)
    		header("location:../home.html");
    	} else {
    		header("location:../index.html?msg=loginIncorreto");
    	}
    } elseif ($acao == "add") {

    }
    
    */
    
?>