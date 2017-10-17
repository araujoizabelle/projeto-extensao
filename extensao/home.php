
<!doctype html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Início - Semana de Extensão 2017</title>
	
    <title>Evento</title>
    <link rel="stylesheet" href="./css/reset.css" />
    <script src="./js/jquery.min.js"></script>
    <script src="./js/plugins/carousel.js"></script>

    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <style>
    	.eventos {
    		border:#aaf solid 1px;
    		background-color: #aaf;
    		margin: 5px;
    		padding: 5px 10px;
    	}
	</style>
    <script>
    	var param = {"act": "listaPorTipo"};

	    $(function(){
	    	$( "#accordion" ).accordion({
				collapsible: true
			});

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

<div id="accordion">
  <h3>Section 1</h3>
  <div>
    <p>Mauris mauris ante, blandit et.</p>
  </div>
  <h3>Section 2</h3>
  <div>
    <p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna. </p>
  </div>
  <h3>Section 3</h3>
  <div>
    <p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui. </p>
    <ul>
      <li>List item one</li>
      <li>List item two</li>
      <li>List item three</li>
    </ul>
  </div>
  <h3>Section 4</h3>
  <div>
    <p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
  </div>
  <h3>Section 4</h3>
  <div>
    <p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
  </div>
  <h3>Section 4</h3>
  <div>
    <p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
  </div>
</div>
		
		<div class="eventos tipo_0">
			
		</div>

		<div class="eventos tipo_1">
		</div>

		<div class="eventos tipo_2">
		</div>
		
		<div class="eventos tipo_3">
		</div>

		<div class="eventos tipo_4">
		</div>

		<div class="eventos tipo_5">
		</div>
		
	</main>
</body>
</html>
