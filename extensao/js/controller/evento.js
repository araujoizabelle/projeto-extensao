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
	console.log(data);
		var mensagem, classe = "";

		if(data==-1){
			mensagem = "Limite de vagas atingido";
			classe= "danger";
			$('#modalErroLimite').modal('show');
		} else if(data==0) {
			mensagem = "Erro ao efetuar inscrição. Por favor, verifique sua programação";
			classe= "danger";
			$('#modalError').modal('show');
		} else{
			mensagem = "Inscrição realizada com sucesso!";
			classe= "success";
			$('#modalSucesso').modal('show');
		}
		//$(".message")
			//	.message({message: mensagem
			//		, class: classe});
}