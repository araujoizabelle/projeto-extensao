;(function($){

	function criaLinha(hora) {
		return "<div class='calendar-line'><div class='calendar-time'>"+hora+":00</div><div class='calendar-grid'></div>";
	}

	function criaEvento(evento, horaInicialGrade){
		var $evento = $("<div/>")
						.addClass("calendar-event")
						.addClass(evento.tipo)
						.attr("id", "evento_"+evento.id)
						.attr("data-termino", evento.horario_fim)
						.text(evento.nome);
		
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
			var $calendarRoom = $("<div/>")
									.addClass("calendar-room")	
									.append($("<div />")
										.addClass("calendar-room-title")
										.text(sala.nome));
			
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

	$.fn.calendar = function(options){
		var numLinhas = options.qtdLinhas;
		var horaInicial = options.horaInicial;
		$(this)
			.append($("<div />").addClass("calendar-date").text("Segunda-feira, 9/10/2017"))
			.append($("<div />").addClass("calendar-body")
				.append(carregarGridHoras(options.qtdLinhas, options.horaInicial))
				.append(carregarSalas(options.salas, options.qtdLinhas, options.horaInicial)));

	}

})(jQuery);