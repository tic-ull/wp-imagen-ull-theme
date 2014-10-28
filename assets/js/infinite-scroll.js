/*
 * Soporte de scroll infinito para páginas multi-página
 * https://github.com/paulirish/infinite-scroll/
 */

(function($, undefined) {
	$.extend($.infinitescroll.prototype, {

		// Al configurar la instancia...
		_setup_imagenull: function() {
			var options = this.options;
			var content = this.element;
			var instance = this;
			
			// Añadir clases al <a> a la siguiente página
			// En Wordpress parece no haber forma sencilla de hacerlo
			$(options.nextSelector).addClass(options.nextClasses);

			// Enganchar manejador para lanzar la carga manual de las páginas
			$(options.nextSelector).click( function(e) {
				if (e.which == 1 && !e.metaKey && !e.shiftKey) {
					e.preventDefault();
					instance.retrieve();
				}
			});
			
			// Desactivar el scroll automático por debajo del umbral
			// de ancho especificado
			$(window).ready( function() {
				$(window).resize( function() {
					var threshold = options.widthThreshold;
					if ( $('header').first().width() < threshold ) {
						instance.pause();
						$(options.navSelector)
							.appendTo(content)
							.show(options.loading.speed);
					}
					else {
						$(options.navSelector).hide(options.loading.speed);
						instance.resume();
					}
				}).resize();
			});
			
			// Enganchar la instancia del plugin
			instance.bind();
		},

		// Cuando los datos se hayan cargado...
		_callback_imagenull: function(data, url) {
			// Recuperamos la instancia puesto que this = elemento
			var instance = $(this).data('infinitescroll');
			var options = instance.options;

			// Si es necesario, mover el control manual detrás del nuevo contenido
			var threshold = options.widthThreshold;
			if ( $('header').first().width() < threshold) {
				$(options.navSelector)
					.appendTo(this)
					.show(options.loading.speed);
			}
		},
	});
})(jQuery);

if ( infinite_scroll !== undefined ) {
	var options = jQuery.parseJSON(infinite_scroll);
	$(options.contentSelector).infinitescroll(options);
}
