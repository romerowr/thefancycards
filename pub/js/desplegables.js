jQuery(document).ready(function($){
	var $cart_trigger = $('#carrito');
	var $lateral_cart = $('#carritoDespegable');
	var $shadow_layer = $('#sombra');

	//se abre o se cierra el carrito haciendo click a la imagen:
	$cart_trigger.on('click', function(event){
		event.preventDefault();
		toggle_panel_visibility($lateral_cart, $shadow_layer, $('body'));
	});

	//se cierra al clicar al carrito o a la sombra:
	$shadow_layer.on('click', function(){
		$shadow_layer.removeClass('is-visible');
		if( $lateral_cart.hasClass('speed-in') ) {
			$lateral_cart.removeClass('speed-in').on('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
				$('body').removeClass('overflow-hidden');
			});
		} else {
			$lateral_cart.removeClass('speed-in');
		}
	});
});

function toggle_panel_visibility ($lateral_panel, $background_layer, $body) {
	if( $lateral_panel.hasClass('speed-in') ) {
		$lateral_panel.removeClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			$body.removeClass('overflow-hidden');
		});
		$background_layer.removeClass('is-visible');

	} else {
		$lateral_panel.addClass('speed-in').one('webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend', function(){
			$body.addClass('overflow-hidden');
		});
		$background_layer.addClass('is-visible');
	}
}
