;(function($){
	$(document).on("click", ".message-close", function(){
		$(this).parent().hide(1000);
	});

	$.fn.message = function(options) {
		$(".message").addClass(options.class);
		$(".message").text(options.message);
		//adicionando o botão de fechar
		$(".message")
			.append($("<div />")
				.addClass("message-close")
				.html("&times;"));
		$(".message").show(2000);
	}
})(jQuery);