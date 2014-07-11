<?php

/*
 * Definiciones de las URL a los iconos de la imagen corporativa.
 */

define( 'IMAGEN_ULL_FAVICON', 		'//static.ull.es/v3/dist/img/favicon.ico');

define( 'IMAGEN_ULL_APPLEICON_144', '//static.ull.es/v3/dist/img/apple-touch-icon-144-precomposed.png');
define( 'IMAGEN_ULL_APPLEICON_114', '//static.ull.es/v3/dist/img/apple-touch-icon-114-precomposed.png');
define( 'IMAGEN_ULL_APPLEICON_72',	'//static.ull.es/v3/dist/img/apple-touch-icon-72-precomposed.png');
define( 'IMAGEN_ULL_APPLEICON_57',	'//static.ull.es/v3/dist/img/apple-touch-icon-57-precomposed.png');

/*
 * Añadir los iconos corporativos a la cabecera si no han sido especificados
 * en la configuración del tema.
 */
add_action( 'wp_head', function() {
	global $ss_settings;

    $favicon_item = $ss_settings['favicon'];
    $apple_icon_item = $ss_settings['apple_icon'];

	// Añadir el favicon si fuera necesario
	if ( empty( $favicon_item['url'] ) ) {
		echo '<link rel="shortcut icon" href="'.IMAGEN_ULL_FAVICON.'">';
	}

	// Añadir el apple icon si fuera necesario
	if ( empty( $apple_icon_item['url'] ) ) {
		echo '<link rel="apple-touch-icon-precomposed" sizes="144x144" href="'.IMAGEN_ULL_APPLEICON_144.'">';
		echo '<link rel="apple-touch-icon-precomposed" sizes="114x114" href="'.IMAGEN_ULL_APPLEICON_114.'">';
		echo '<link rel="apple-touch-icon-precomposed" sizes="72x72" href="'.IMAGEN_ULL_APPLEICON_72.'">';
		echo '<link rel="apple-touch-icon-precomposed" href="'.IMAGEN_ULL_APPLEICON_57.'">';
	}
});

/*
 * Añadir los nuevos estilos CSS/LESS del tema.
 */
add_filter( 'shoestrap_compiler', function( $bootstrap ) {
	return $bootstrap . '
	@import "' . get_stylesheet_directory() . '/assets/less/ull.less";';
}, 30);

/*
 * Cambiar opciones por defecto de Shoestrap.
 */
function image_ull_make_default_option_modifier( $id, $default_value) {
	return function ( $fields ) use ( $id, $default_value ) {
		return array_map( function( $field ) use ( $id, $default_value ) {
			if ( $field['id'] == $id ) {
				$field['default'] = $default_value;
			}
			return $field;
		}, $fields);
	};
}

// Activar el layout estilo 'fluid'
add_filter( 'shoestrap_module_layout_options_modifier', image_ull_make_default_option_modifier( 'site_style', 'fluid' ) );

// Desactivar el formulario de búsqueda de la barra de navegación
add_filter( 'shoestrap_module_menus_options_modifier', image_ull_make_default_option_modifier( 'navbar_search', 0 ) );

// Usar el CDN de Google para JQuery
add_filter( 'shoestrap_module_menus_options_modifier', image_ull_make_default_option_modifier( 'jquery_cdn_toggler', 1 ) );

/*
 * Añadir la barra principal ULL.
 */
add_action( 'shoestrap_pre_top_bar', function() {
	ss_get_template_part('templates/ull-bar');
});

/*
 * Ajustar las clases de las barras de navegación.
 * La barra original del tema se usará como barra contextual del servicio.
 */ 
add_filter( 'shoestrap_navbar_class', function( $class, $context = null ) {
	if ( $context == 'ull-bar' ) {
		return $class . ' navbar-ull';
	} else {
		return $class . ' navbar-app';
	}
}, 30, 2 );

/*
 * Soporte de Font Awesome en los menús de navegación.
 *
 * Simplemente hay que añadir la clase CSS fa-(nombre del icono) al elemento
 * de menú correspondiente.
 */
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array(), '4.1.0', 'all' );
});

add_filter( 'wp_nav_menu_items' , function( $items, $args ) {
	$html = new DOMDocument();
	$html->loadHTML('<?xml version="1.0" encoding="'.get_bloginfo('charset').'"?>' .$items );

	foreach ($html->getElementsByTagName( 'li' ) as $item) {
		if ( $item->hasAttribute( 'class' ) ) {
			$classes = explode( ' ', $item->getAttribute( 'class' ) );

			$before = true;
			$fontawesome_classes = array();
			$classes = array_filter( $classes, function( $class ) use ( &$before, &$fontawesome_classes ) {
				if ( substr( $class, 0, 2 ) == 'fa' ) {
					if ( $class == 'fa-after' ) {
						$before = false;
					} elseif ( $class != 'fa' ) {
						$fontawesome_classes[] = $class;
					}
					return false;
                }
				return true;
			});

			$item->setAttribute( 'class' , implode( ' ', $classes ) );
			if ( !empty( $fontawesome_classes ) ) {
				$fontawesome_classes[] = 'fa';
				$icon = $html->createElement( 'i' );
				$icon->setAttribute( 'class', implode( ' ', $fontawesome_classes ) );
				$space = $html->createTextNode( ' ' );
				$link = $item->firstChild;			// etiqueta <a>
				if( $before ){
					$link->insertBefore($space, $link->firstChild);
					$link->insertBefore($icon, $link->firstChild);
				} else {
					$link->appendChild($space);
					$link->appendChild($icon);
				}
			}
		}
	}
	return $html->saveHTML();
}, 10, 2)

?>
