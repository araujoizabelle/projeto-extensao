$(function(){
  function getUrlVars() {
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
  }
  
  var vars = getUrlVars();

  if (vars["msg"]=="loginIncorreto") {
    //programar uma caixa de mensagem vermelha...
  }

  //efeito formulário
  $(".inputEmail").on("focus", function(){
    $(".labelEmail").css("color","#696969");
    $(".labelEmail").css("border-bottom","2px solid #696969");
    $(".inputEmail").css("border-bottom","2px solid #696969");
  });
  $(".inputEmail").on("blur", function(){
    if($(".inputEmail").val() == ""){
      $(".labelEmail").css("color","rgba(153, 153, 153, 0)");
    }
    else{
      $(".labelEmail").css("color","rgba(153, 153, 153, 1)");
    }
    $(".labelEmail").css("border-bottom","2px solid #888");
    $(".inputEmail").css("border-bottom","2px solid #888");
  });

  $(".inputSenha").on("focus", function(){
    $(".labelSenha").css("color","#696969");
    $(".labelSenha").css("border-bottom","2px solid #696969");
    $(".inputSenha").css("border-bottom","2px solid #696969");
  });
  $(".inputSenha").on("blur", function(){
    if($(".inputSenha").val() == ""){
      $(".labelSenha").css("color","rgba(153, 153, 153, 0)");
    }
    else{
      $(".labelSenha").css("color","rgba(153, 153, 153, 1)");
    }
    $(".labelSenha").css("border-bottom","2px solid #888");
    $(".inputSenha").css("border-bottom","2px solid #888");
  });

  //efeito background
  document.querySelector('.fadeIn').addEventListener('mousemove', function(event) {
    var posX = event.clientX;
    var posY = event.clientY;
    posX = -(posX/10);
    posY = -(posY/10);
    $(".fadeIn").css("background-position", posX+"px "+posY+"px");
  });
});
