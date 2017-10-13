<?php
	include("../model/banco.php");

	function geraHorarioHTML($eventoId){
		$conexao = abrir();
   		$sql = "SELECT * from tb_horarioEvento";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
    	$horarioHtml = '<select name="horario">';

   		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
   			$selected = ($row["evento_id"]== $eventoId)?" selected ":"";
   			$horarioHtml .= '<option value="'.$row["id"].'" '.$selected.'>DE '.$row["data_inicio"].' ATE '.$row["data_termino"].'</option>';
   		}
   		$horarioHtml .= '</select>';

   		fechar($conexao);
        return $horarioHtml;
	}

	function geraSalaHTML(){
		$conexao = abrir();

   		$sql = "SELECT * from tb_sala s";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
    	$horarioHtml = '<select name="sala">';
   		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
   			$horarioHtml .= '<option value="'.$row["id"].'">'.$row["nome"].'</option>';
   		}
   		$horarioHtml .= '</select>';

   		fechar($conexao);
        return $horarioHtml;
	}

	function geraEventoHTML() {
		$conexao = abrir();
        
    	$sql = "SELECT * from tb_evento e  group by e.nome";

    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
    	$eventoHtml = '';
   		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
   			$eventoHtml .= '<form action="administracao.php?act=update&evento_id='.$row["id"].'" method="post">';
   			$eventoHtml .= '<label>Evento:'.$row["nome"].'</label>';
   			$eventoHtml .= '<label>Horário</label>'.geraHorarioHTML($row["id"]);
   			$eventoHtml .= '<label>Sala</label>'.geraSalaHTML();
   			$eventoHtml .= '<input type="submit" value="Atualizar">';
   			$eventoHtml .= '</form>';
   		}
   		$eventoHtml .= '<br />';
   		fechar($conexao);
        return $eventoHtml;
    }
    
	function gerarGrade() {
    	$conexao = abrir();

    	$sql = "SELECT e.nome, h.*, s.nome as sala FROM tb_evento e inner join tb_horarioEvento h ";
    	$sql .= "on e.id = h.evento_id inner join tb_sala s on s.id = h.sala_id ";
		$sql .= "group by e.nome ";
		$sql .= "order by h.data_inicio ASC ";
		$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
    	$elementoHtml = "";
   		while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)){
   			echo "<br />";

   			$elementoHtml .= '<h1>'.$row["nome"]."</h1>";
   			$elementoHtml .= '<h3> De '.$row["data_inicio"].' até '. $row["data_termino"].'</h3>';
   			$elementoHtml .= '<h3> Local '.$row["sala"]."</h3>";
   			$elementoHtml .= '<hr />';
   		}
   		fechar($conexao);
   		return $elementoHtml;
   	}

    if($_GET["act"] =="update") {
    	$evento_id = $_GET["evento_id"];
    	$horario_id = $_POST["horario"];
    	$sala_id = $_POST["sala"];

    	$conexao = abrir();
    	$sql  = "update tb_horarioEvento set evento_id = ";
    	$sql .= $evento_id. ", sala_id = ". $sala_id;
    	$sql .= " where id = ".$horario_id;

    	$query = mysqli_query($conexao, $sql) or die ("Deu erro na query: ".$sql.' '.mysqli_error($conexao));
        
        fechar($conexao);
    } 
?>
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<style>
		label {
			display: block;
			font-weight: bold;
		}
		input {
			display: block;
			margin: 10px 0 30px;
		}
	</style>
</head>
<body>	
	<a href="administracao.php?act=get">Ver resultado</a>
	
		<?php 
			if($_GET["act"]!="get") {
				echo(geraEventoHTML()); 
			} else {
				echo gerarGrade();
			}

		?> 
		
	</form>
</body>
</html>