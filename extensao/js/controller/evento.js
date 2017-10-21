function setFolha(tipoEvento) {
	if(tipoEvento == "Palestra") 
		$("#folha").attr("href", "./css/tipo_evento/palestra.css");
	else if(tipoEvento == "Minicurso")
		$("#folha").attr("href", "./css/tipo_evento/minicurso.css");
	else if(tipoEvento == "Mesa Redonda")
		$("#folha").attr("href", "./css/tipo_evento/mesaredonda.css");
	else if(tipoEvento == "EXPOSUP")
		$("#folha").attr("href", "./css/tipo_evento/exposup.css");
	else if(tipoEvento == "EXPOTEC")
		$("#folha").attr("href", "./css/tipo_evento/expotec.css");
	else 
		$("#folha").attr("href", "./css/tipo_evento/outros.css");
}

function geraMensagem(data){
  var mensagem, classe = "";
  if(data==-1){
    mensagem = "Limite de vagas atingido";
    classe= "danger";
    //$('#modalErroLimite').modal('show');
  } else if(data==0) {
    mensagem = "Erro ao efetuar inscrição. Por favor, verifique sua programação";
    classe= "danger";
    //$('#modalError').modal('show');
  } else{
    mensagem = "Inscrição realizada com sucesso!";
    classe= "success";
    //$('#modalSucesso').modal('show');
    $("#inscricao").addClass("btn btn-danger btn-custom")
            .attr({"data-toggle":"modal","data-target":"#modalCancelamento"})
            .text("Cancelar Inscrição"); 
  }
  $(".message")
      .message({message: mensagem
        , class: classe});
}

function configuraBotaoInscricao(evento_id,usuario_id){
    var servico = "./controller/evento_ctrl.php";
    var params = {act:"inscrito"
                , evento_id:evento_id
                , usuario_id:usuario_id};

    $.get(servico, params).done(function(data){
console.log(servico);
console.log(params);
        if(data==0) {
            $("#inscricao")
                .attr("class","btn btn-primary btn-custom")
                .attr({"data-toggle":"modal","data-target":"#modalInscricao"})
                .text("Inscreva-se!");  
        } else {
            $("#inscricao")
                .attr("class","btn btn-danger btn-custom")
                .attr({"data-toggle":"modal","data-target":"#modalCancelamento"})
                .text("Cancelar Inscrição");  
        }

    });
}

function carregaEvento(evento_id){
	$.get("./controller/evento_ctrl.php?act=get&id="+evento_id).done(function(data){
		var evento = JSON.parse(data);
		//configurando folha de estilo
		setFolha(evento.tipo);
		$(".tipo_evento h3").text(evento.tipo);
		$(".info_evento h2").text(evento.nome);
		$(".modal-body span").text(evento.nome);
		$(".info_evento h3").text(evento.horarios[0].sala);
		$(".description p").html(evento.descricao);
		$(".buttonInscrever").attr("data-evento-id", evento_id);

        $.each(evento.horarios, function(index, horario){
            var dataFormatada = formatarData(horario.data_inicio);
            var horaInicio = formatarHora(horario.data_inicio);
            var horaFim = formatarHora(horario.data_termino);
            //<li>Dia 23/10, 8:00 às 12:00</li>
            $(".horarios ul")
              .append($("<li />")
                .text("Dia "+dataFormatada+", de "+horaInicio+" às "+horaFim));
        });

        carregarAutores(evento.autores);
		
	});	
}

function carregarAutores(autoresArray) {
	$.each(autoresArray, function(index, autor){
		var foto = (autor.foto!="")?autor.foto:"./img/perfilpadrao.jpg";
		$("main")
			.append($("<section />")
				.addClass("palestrante")
				.append($("<img />")
					.attr({"src": foto, "alt": "Foto do participante "+autor.nome}))
				.append($("<article />").addClass("bioPalestrante")
					.append($("<h3/>").text(autor.nome))
					.append($("<p/>").text(autor.bio))
					.append($("<h4/>").text(autor.lattes))
				)
			);
	});
}

