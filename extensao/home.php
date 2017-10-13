
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Início - Semana de Extensão 2017</title>
	
    <title>Evento</title>
    <link rel="stylesheet" href="./css/reset.css" />
    <script src="./js/jquery.min.js"></script>
    <script src="./js/plugins/carousel.js"></script>
    <script>
    	var param = {"act": "list"};

    	function listTiposId() {
	    	$.get("./controller/tipo_evento_ctrl.php?act=listId")
		    	.done(function(data){
		    		var teste = JSON.parse(data);
		    		param.tipos = data;
		    		return data;
		    	}).fail(function(data){
		    		console.log("erro " + data);
		    		return "";
		    	});
	    }

    	function listDatas() {
    		$.get("./controller/horario_ctrl.php?act=list")
	    		.done(function(data){
	    		param.datas = data;

	    		return JSON.parse(data);
	    	});
    	}

		var tipos = listTiposId();
    	var datas = listDatas();
    	
    	param.tipos = tipos;
    	param.datas = datas;

	    $(function(){
	    	
	    	var servico = "./controller/home_ctrl.php";
	    	
	    	$.get(servico, param)
	    		.done(function(data){
	    			var eventosTipoArray = JSON.parse(data);
	    			console.log(eventosTipoArray);
	    			$.each(eventosTipoArray, function(index, obj){
	    				$eventos = $("<div />");
	    				$.each(obj.eventos,function(ind, evento){
	    					$eventos
	    						.append($("<div/>")
	    							.attr("id", "evento_" + evento.evento_id)
	    							.addClass("evento")
	    							.append($("<h3/>").text(evento.evento_nome))
	    							.append($("<p/>").text(evento.evento_descricao))
	    						);
	    				})
	    				$(".tipo_"+index)
	    					.append($("<h1 />").text(obj.tipo)
	    					.append($eventos));
	    			})
	    		})
	    		.fail(function(data){
	    			console.log(data);
	    		});
	    
	    	$("main").on("click", ".evento", function(){
	    		var evento_id = $(this).attr("id").substr(7);
	    		window.location.href = "evento.php?act=get&id="+evento_id;
	    	});
	    });
	</script>
</head>
<body>
	
	<header>
		<h1>CEFET/RJ Nova Friburgo</h1>
		<h3>Semana de Extensão 2017</h3>
		<nav>
			Usuário!
			<a href="./controller/usuario_ctrl.php?act=logout">Sair</button>
		</nav>
	</header>
	<main>
		<div>
			<a href="minha_grade.php">Minha Grade</a>
			<a href="programacao.php">Programação</a>
		</div>
		
		<div class="tipo_0">
			
		</div>

		<div class="tipo_1">
		</div>

		<div class="tipo_2">
		</div>
		
		<div class="tipo_3">
		</div>

		<div class="tipo_4">
		</div>

		<div class="tipo_5">
		</div>
		
	</main>
</body>
</html>
