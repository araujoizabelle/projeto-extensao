<!doctype html>
<html>
<head>
	<title>3</title>
	<meta charset="utf-8" />
    <title>Evento</title>
    <link rel="stylesheet" href="./css/reset.css" />
    <script src="./js/jquery.min.js"></script>
    <script>

	    $(function(){
	    	var servico = "./controller/home_ctrl.php";
	    	var param = {"act": "list"};
	    	var xhr = $.get(servico, param);

	    	xhr.done(function(data){
	    		var eventosTipoArray = JSON.parse(data);
	    		$.each(eventosTipoArray, function(index, obj){
	    			$(".programacao")
	    				.append($("<div />").addClass(obj.tipo_evento)
	    					.append($("<h1 />").text(obj.tipo_evento)));
	    		})
	    	})
	    });
	</script>
</head>
<body>
	<header>
		<h1>Nome</h1>
		<button>Grade</button>
		<button>Sair</button>
	</header>
	<main>
		<table>
			<tr>
				<th></th>
				<th>Título</th>
				<th>Data</th>
				<th>Hora</th>
			</tr>
			<tr>
				<td>Ckeck</td>
				<td>Curso de xml</td>
				<td>09/02</td>
				<td>14:00</td>
			</tr>
		</table>
		<button>Salvar</button>
	</main>
	<div class="programacao">
	</div>
</body>
</html>
