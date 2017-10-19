<?php
	include("../model/banco.php");

    $acao = $_GET["act"];
	
	
	function autenticar($email, $senha) {   	
    	$conexao = abrir();
    	
    	$sql = "SELECT * FROM tb_usuario WHERE email = '".$email."' AND senha = '".$senha."'" ;
    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query);

    	fechar($conexao);
    	return $result;
    }
    function logout() {
        unset($_SESSION['usuarioId']);
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        unset($_SESSION['nome']);
        session_destroy();
    }
    function cadastrar($nome, $email, $senha) {
    	$conexao = abrir();

    	//Testar se email já está cadastrado
    	$sql = "SELECT * FROM tb_usuario WHERE email = '".$email."'";

    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        $result = mysqli_fetch_array($query);

        if ($result) {
        	fechar($conexao);
        	return false;
        } else {
        	$sqlAdd = "INSERT INTO tb_usuario (nome, email, senha) values ";
        	$sqlAdd .= "('".$nome."','".$email."','".$senha."')";
			$queryAdd = mysqli_query($conexao, $sqlAdd) or die ("Deu erro na query: ".$sqlAdd.' '.mysqli_error($conexao));
        
        	//$result = mysqli_fetch_array($query);        	
        	$usuarioId = mysqli_insert_id($conexao);
        	fechar($conexao);
        	return $usuarioId;
        }
    }

    if($acao == "login") {
    	$email = $_POST["email"];
    	$senha = $_POST["senha"];

    	$isAuth = autenticar($email, $senha);
 
    	if($isAuth) {
    		session_start();
    		$_SESSION['usuarioId'] = $isAuth["id"];
    		$_SESSION['login'] = $isAuth["email"];
    		$_SESSION['nome'] = $isAuth["nome"];
    		header("location:../grid.php");
    	} else {
            unset($_SESSION['login']);
            unset($_SESSION['senha']);
            unset($_SESSION['usuarioId']);
    		header("location:../index.html?msg=loginIncorreto");
    	}
 
    } elseif ($acao == "add") {
    	$nome = $_POST["nome"];
    	$email = $_POST["email"];
    	$senha = $_POST["senha"];

    
    	$usuarioId = cadastrar($nome,$email,$senha);

    	if($usuarioId) {
    		header("location:../index.html?msg=usuarioCadastrado");	
    	} else {
    		header("location:../index.html?msg=emailJaCadastrado");	
    	}
    } elseif($acao == "logout") {
        logout();
    }
    
    
    
?>