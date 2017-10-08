;(function($){
	$(document).on("click", ".message-close", function(){
		$(this).parent().hide(200);
	});

	$.fn.message = function(options) {
		$(".message").addClass(options.class);
		$(".message").text(options.message);
		//adicionando o botão de fechar
		$(".message")
			.append($("<div />")
				.addClass("message-close")
				.html("&times;"));
		$(".message").show(200);
	}
})(jQuery);