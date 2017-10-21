function getDiaSemana(dia) {
var diaDaSemana = dia.getDay();
  switch (diaDaSemana){
    case 0: return "domingo";
    case 1: return "segunda-feira";
    case 2: return "terça-feira";
    case 3: return "quarta-feira";
    case 4: return "quinta-feira";
    case 5: return "sexta-feira";
    case 6: return "sábado";
  }
}

function carregarPagina(){
    var intervalo = 2;
    $.get("./controller/horario_ctrl.php?act=list")
        .done(function(data){
            var dataArray = JSON.parse(data);
            $.each(dataArray, function(i, obj){
                carregaDias(obj, intervalo);
            });
            $.each(dataArray, function(i, obj){
                var seletor = obj.split("-")[2];
                carregaGridDia($("div[data-dia="+seletor+"]"), obj, intervalo);
        });
    });
}

function carregarEventos($div, inicio, fim) {
    var servico = "./controller/evento_ctrl.php";
    var params = {"act": "listByDateTime", "begin": inicio, "end":fim};
    $.get(servico, params).done(function(data){
        var eventosArray = JSON.parse(data);
        $.each(eventosArray,function(index, evento){
            $div
                .append($("<div/>")
                    .addClass("event")
                    .attr("id", evento.id)
                .append($("<p/>")
                    .addClass("event-horario")
                    .text(evento.inicio + " às " + evento.fim))
                .append($("<p/>")
                    .addClass("event-tipo")
                    .addClass(evento.tipo.toLowerCase().split(" ")[0])
                    .text(evento.tipo))
                .append($("<h1/>")
                    .addClass("evento-title")
                    .text(evento.nome))
                .append($("<p/>")
                    .addClass("event-local")
                    .text(evento.local))
                /*
                .append($("<span />")
                    .addClass("event-details")
                    .append($("<i/>")
                        .addClass("fa fa-paper-plane-o")
                        .attr("aria-hidden", "true")
                    )
                )
                */
            );
        });
    });
}
function carregaDias(data, intervalo) {
    var dataArray = data.split("-");
    var ano = dataArray[0];
    var mes = parseInt(dataArray[1])-1;
    var diaDoMes = dataArray[2];
    var diaDate = new Date(ano, mes, diaDoMes);
    $divDia = $("<div/>")
                .addClass("day")
                .attr("data-dia", diaDoMes)
                .append($("<div />")
                    .addClass("day-date")
                    .append($("<h1/>")
                        .attr("id", getDiaSemana(diaDate))
                    .text(getDiaSemana(diaDate) +  "["+diaDoMes+"]")
                )
              );
    $("main").append($divDia);
}

function carregaGridDia($div, data, intervalo) {
    var dataArray = data.split("-");
    var ano = dataArray[0];
    var mes = parseInt(dataArray[1])-1;
    var diaDoMes = dataArray[2];
    //passo 1 identificar até que horas haverá eventos iniciando
    var servico = "./controller/horario_ctrl.php";
    var params = {act: "getHourLastEvent", date: data};
//console.log("getHourLastEvent do dia " + data);

    $.get(servico, params).done(function(data){
        //retirando as aspas do data;
        var horarioTermino = parseInt(data.substring(1, data.length-1));

//console.log("hora de termino do dia " + diaDoMes + ": "+horarioTermino);

        for(var i=8; i<horarioTermino; i+=intervalo) {
            var dataStr = ano+"-"+(mes+1)+"-"+diaDoMes;
            var seletor= dataStr+"_"+i;
            $div
                .append($("<div/>").addClass("day-grid")
                    .append($("<div />").addClass("grid")
                        .append($("<div />").addClass("grid-hour")
                            .append($("<h1/>").text(i+":00"))
                        )
                        .append($("<div/>")
                            .addClass("grid-event")
                            .attr("data-inicio",seletor))
                    )
                );

            carregarEventos($("div[data-inicio="+seletor+"]")
                      , dataStr+" "+i+":00"
                      , dataStr+" "+(i+intervalo)+":00");      
        }
    }); 
}


function onButtonLogoutClick(){
    $.get("./controller/usuario_ctrl.php?act=logout")
        .done(function(data){
            window.location.href = "index.html";
    });
}

function onEventClick(){
    var evento_id = $(this).attr("id");
    window.location.href = "evento.php?act=get&id="+evento_id;
}

function onEventOver(){
    var tipo = $(this).children(".event-tipo").attr("class").split(" ")[1];
    if( tipo == "palestra" ){
        $(this).children(".evento-title").css("color", "#fff");
        $(this).children(".event-tipo").css("color", "rgb( 45, 83, 23)");
        $(this).children(".event-local").css("color", "rgb( 45, 83, 23)");
        $(this).css("background-color", "rgb( 94, 176, 48)")
    }
    if( tipo == "minicurso" ){
        $(this).children(".evento-title").css("color", "#fff");
        $(this).children(".event-tipo").css("color", "rgb( 97, 10, 20)");
        $(this).children(".event-local").css("color", "rgb( 97, 10, 20)");
        $(this).css("background-color", "rgb( 223, 22, 48)")
    }
    if( tipo == "mesa" ){
        $(this).children(".evento-title").css("color", "#fff");
        $(this).children(".event-tipo").css("color", "rgb( 95, 38, 12)");
        $(this).children(".event-local").css("color", "rgb( 95, 38, 12)");
        $(this).css("background-color", "rgb( 234, 95, 30)")
    }
    if( tipo == "outra" ){
        $(this).children(".evento-title").css("color", "#fff");
        $(this).children(".event-tipo").css("color", "rgb( 13, 65, 94)");
        $(this).children(".event-local").css("color", "rgb( 13, 65, 94)");
        $(this).css("background-color", "rgb( 31, 147, 210)")
    }
    if( tipo == "exposup" || tipo == "expotec" ){
        $(this).children(".evento-title").css("color", "#fff");
        $(this).children(".event-tipo").css("color", "rgb( 97, 70, 10)");
        $(this).children(".event-local").css("color", "rgb( 97, 70, 10)");
        $(this).css("background-color", "rgb( 192, 142, 19)")
    }
    if( tipo == "poster" ){
        $(this).children(".evento-title").css("color", "#fff");
        $(this).children(".event-tipo").css("color", "rgb( 0, 32, 15)");
        $(this).children(".event-local").css("color", "rgb( 0, 32, 15");
        $(this).css("background-color", "rgb( 0, 117, 54)")
    }
}

function onEventLeave(){
    $(this).children(".evento-title").css("color", "#000");
    $(this).children(".event-tipo").css("color", "#000");
    $(this).children(".event-local").css("color", "#000");
    $(this).css("background-color", "#eee");
}

function onSlideClick() {
    $doc.animate({
        scrollTop: $( $.attr(this, 'href') ).offset().top
    }, 750);
}
function posicionarHeader() {
    var marginLogo = parseInt($(".header-logo").css("margin-left"));
    var widthTexts = parseInt($(".header-texts").css("width"));
    var widthForm = parseInt($(".header-form").css("width"));
    var heightHeader = parseInt($(".header").css("height"));
    var heightTexts = parseInt($(".header-texts").css("height")) +  20;
    var heightForm = parseInt($(".header-form").css("height"));
    $(".header-texts").css("left", (marginLogo - widthTexts)/2);
    $(".header-texts").css("margin-top", (heightHeader - heightTexts)/2);
    $(".header-form").css("right", (marginLogo - widthForm)/2);
    $(".header-form").css("margin-top", (heightHeader - heightForm)/2);

    var $doc = $('html, body');
}