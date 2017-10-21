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

function getUrlVars() {
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for(var i = 0; i < hashes.length; i++) {
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}

function formatarHora(data) {
    var horaArray = data.split(" ")[1].split(":");
    return horaArray[0]+":"+horaArray[1];
}
function formatarData(data) {
	var dataStr = data.split(" ")[0];
	return dataStr.split("-")[2]+"/"+dataStr.split("-")[1]; 
}
