;(function($){


	function criaLinha(hora) {
		return "<div class='calendar-line'><div class='calendar-time'>"+hora+":00</div><div class='calendar-grid'></div>";
	}

	function criaEvento(evento, horaInicialGrade){
		var $evento = $("<div/>")
						.addClass("calendar-event")
						.addClass(evento.tipo.toLowerCase().split(" ")[0])
						.append($("<p/>")
							.attr("id", "evento_"+evento.id)
							.attr("data-termino", evento.horario_fim)
							.text(evento.nome));
		
		$evento
			.append($("<div />")
				.addClass("remove").html("&times;")
				.attr({"data-toggle":"modal","data-target": "#myModal"}));
		//a altura padrão das grids está configurada para 60px;
		var alturaPadrao = 60;

		var inicioArray = evento.horario_inicio.split(":");

		var horaInicialEvento = parseInt(inicioArray[0]);
		var minutoInicialEvento = parseInt(inicioArray[1]);

		var fimArray = evento.horario_fim.split(":");
		var horaFinalEvento = parseInt(fimArray[0]);
		var minutoFinalEvento = parseInt(fimArray[1]);

		var inicioMinuto = horaInicialEvento*60 + minutoInicialEvento;
		var fimMinuto = horaFinalEvento*60 + minutoFinalEvento;
		var duracao = (fimMinuto - inicioMinuto);
		// o titulo das salas têm 30px; por isso desconto aqui
		var topo = 30 + minutoInicialEvento + (horaInicialEvento - horaInicialGrade) * alturaPadrao;
		
		var $eventosArray = $(".calendar-event");
		$evento.css({top: topo, height: duracao});
		//calculando número de caracteres proporcional ao tamanho da caixa
		var numMaxCaracteres = (parseInt($evento.css("height"))/30)*20;
		if($evento.children("p").text().length>numMaxCaracteres) {
			$evento.children("p").text($evento.children("p").text().substr(0,numMaxCaracteres)+"...");	
		}
		
		return $evento;
	}

	function carregarGridHoras(numLinhas, horaInicial) {
		var $gridTime = $("<div/>")
							.addClass("calendar-grid-time")
							.append($("<div />")
								.addClass("calendar-time-title").text("Horários"));

		for(var i=0; i<numLinhas; i++){
			//$(".calendar-grid-time")
			$gridTime
				.append($("<div />")
					.addClass("calendar-time")
					.text((horaInicial+i)+":00"));
		}
		return $gridTime;
	}
	function carregarSalas(salas, numLinhas, horaInicial) {
		var $bodyGrid = $("<div />").addClass("calendar-body-grid");
		salas.forEach(function(sala){
			var dataArray = sala.data.split("-");
			var dataDt = new Date(dataArray[0], (dataArray[1]-1), dataArray[2]);
			var $calendarRoom = $("<div/>")
									.addClass("calendar-room")	
									.append($("<div />")
										.addClass("calendar-room-title")
										.text(getDiaSemana(dataDt)+ " "+dataArray[2]+"/"+dataArray[1])
									);
			
			for(var i=0; i<numLinhas;i++){
				$calendarRoom.append($("<div />").addClass("calendar-grid"));
			}
			sala.programacao.forEach(function(evento){
				$calendarRoom.append(criaEvento(evento, horaInicial));
			});	
			$bodyGrid.append($calendarRoom);
		})
		return $bodyGrid;	
	}

	function getDiaSemana(dataCompleta) {
		switch (dataCompleta.getDay()) {
			case 0: return "Domingo";
			case 1: return "Segunda-feira";
			case 2: return "Terça-feira";
			case 3: return "Quarta-feira";
			case 4: return "Quinta-feira";
			case 5: return "Sexta-feira";
			case 6: return "Sábado";
		}
	}

	
	$.fn.calendar = function(options){

		var numLinhas = options.qtdLinhas;
		var horaInicial = options.horaInicial;
		$(this)			
			.append($("<div />").addClass("calendar-body")
				.append(carregarGridHoras(options.qtdLinhas, options.horaInicial))
				.append(carregarSalas(options.salas, options.qtdLinhas, options.horaInicial)));


		$(this).on("click", ".calendar-event p", function(){
			var evento_id = $(this).attr("id").substr(7);
			location.href = "evento.php?act=get&id="+evento_id;
		});

		$(this).on("click", ".remove", function(){
			var nomeEvento = $(this).parent().children(".calendar-event p").text();
			$(".modal-body span").text(nomeEvento);
			$(".buttonDesistir").attr("data-evento", $(this).parent().children(".calendar-event p").attr("id"))
			
		})
	}

})(jQuery);