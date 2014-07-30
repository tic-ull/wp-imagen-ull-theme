<?php
require_once( dirname(__FILE__) . '/icons.php' );
require_once( dirname(__FILE__) . '/utils.php' );

/*
 * Definiciones de las URL de los iconos de la imagen corporativa.
 */

define( 'IMAGEN_ULL_FAVICON', 		'//static.ull.es/v3/dist/img/favicon.ico');

define( 'IMAGEN_ULL_APPLEICON_144', '//static.ull.es/v3/dist/img/apple-touch-icon-144-precomposed.png');
define( 'IMAGEN_ULL_APPLEICON_114', '//static.ull.es/v3/dist/img/apple-touch-icon-114-precomposed.png');
define( 'IMAGEN_ULL_APPLEICON_72',	'//static.ull.es/v3/dist/img/apple-touch-icon-72-precomposed.png');
define( 'IMAGEN_ULL_APPLEICON_57',	'//static.ull.es/v3/dist/img/apple-touch-icon-57-precomposed.png');

/*
 * Añadir los nuevos estilos CSS/LESS del tema.
 */

add_filter( 'shoestrap_compiler', function( $bootstrap ) {
	return $bootstrap . '
	@import "' . get_stylesheet_directory() . '/assets/less/font-awesome-4.1.0/font-awesome.less";
	@import "' . get_stylesheet_directory() . '/assets/less/elusive.less";
	@import "' . get_stylesheet_directory() . '/assets/less/ull.less";';
}, 30);

/*
 * Configuración del layout.
 */

// Activar por defecto el estilo 'fluid'
add_filter( 'shoestrap_module_layout_options_modifier',
			imagen_ull_make_default_option_modifier( 'site_style', 'fluid' ) );

// Colocar la barra lateral a la izquierda
add_filter( 'shoestrap_module_layout_options_modifier',
			imagen_ull_make_default_option_modifier( 'layout', '2' ) );

// Activar el uso de componentes 'panel' en los widgets
add_filter( 'shoestrap_module_layout_advanced_options_modifier',
			imagen_ull_make_default_option_modifier( 'widgets_mode', '0' ) );

/*
 * Configuración de las barras de navegación.
 */

// Añadir la barra principal ULL
add_action( 'shoestrap_pre_top_bar', function() {
	ss_get_template_part('templates/ull-bar');
});

// Ajustar las clases de las barras de navegación.
// La barra original del tema se usará como barra contextual del servicio.
add_filter( 'shoestrap_navbar_class', function( $class, $context = null ) {
	$class = 'navbar navbar-default';
	if ( $context == 'ull-bar' ) {
		return $class . ' navbar-ull';
	} else {
		return $class . ' navbar-app';
	}
}, 20, 2 );

add_filter( 'shoestrap_nav_class', function ($class ) {
	return 'navbar-nav nav navbar-right';
}, 20);

// Desactivar por defecto el formulario de búsqueda de la barra
// contextual del servicio.
add_filter( 'shoestrap_module_menus_options_modifier',
	imagen_ull_make_default_option_modifier( 'navbar_search', 0 ) );

/*
 * Incorporar soporte de iconos Font Awesome a los menús de navegación.
 *
 * Simplemente hay que añadir la clase CSS fa-(nombre del icono) al elemento
 * de menú correspondiente.
 */

add_filter( 'nav_menu_link_attributes' , function( $atts, $item, $args ) {
	imagen_ull_process_font_awesome_classes( $item->classes, $args );
	return $atts;
}, 10, 3);

// Quitar las clases fa-(nombre del icono) de los elementos <li> ya que
// no se puede hacer desde el filtro 'nav_menu_link_attributes'.
add_filter( 'nav_menu_css_class' , function( $classes, $item, $args ) {
	return array_filter( $classes, function( $class ) {
		return ( substr( $class, 0, 2 ) == 'fa' ) ? false : true;
	});
}, 10, 3);

/*
 * Configuración de widgets.
 *
 * - Conviene usar el plugin Widget CSS Classes para incorporar iconos
 *   y colores a las cabeceras de los widgets:
 *
 *   http://cleverness.org/plugins/widget-css-classes-plugin/
 */

add_filter( 'shoestrap_widgets_class', function( $class ) {
	return $class . ' panel-ull';
}, 20);

// add_filter( 'shoestrap_widgets_before_title', function( $before ) {
// 	return $before . '<h3 class="panel-title">';
// }, 20);
// 
// add_filter( 'shoestrap_widgets_after_title', function( $after ) {
// 	return '</h3>' . $after;
// }, 20);

add_filter( 'dynamic_sidebar_params', function( $params ) {
	$args = new stdClass();
	$pattern = '/class=[\'"]([^\'"]*)[\'"]/';
	$params[0]['before_widget'] = preg_replace_callback( $pattern, function( $matches ) use ( &$args ) {
		$classes = explode( ' ', $matches[1] );
		$classes = imagen_ull_process_font_awesome_classes( $classes, $args );
		return 'class="' . implode( ' ', $classes ) . '"';
	}, $params[0]['before_widget'] );
	$params[0]['before_title'] .= '<h3 class="panel-title">' . $args->link_before;
	$params[0]['after_title'] = $args->link_after . '</h3>'. $params[0]['after_title'];
	return $params;
}, 20);

/*
 * Soporte de tipos especiales de elementos en los menús de navegación.
 *
 * - Para incorporar texto HTML libre no enlazado, simplemente añadir el
 *   atributo dropdown-text al elemento de menú y el texto en cuestión a su.
 *   descripción.
 *
 * - Para incorporar una entrada con enlaces a las redes sociales, simplemente
 *   añadir el atributo dropdown-social al elemento de menú.
 */

add_filter( 'walker_nav_menu_start_el', function( $item_output, $item, $depth, $args ) {
	$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	if ( strcasecmp( $item->attr_title, 'dropdown-text') == 0 && $depth === 1 ) {
//		No hace falta invocar:
//
//		imagen_ull_process_font_awesome_classes( $item->classes, $args );
//
//		para soportar los iconos de Font Awesome si ya se hizo previamente
//		en el filtro 'nav_menu_link_attributes'.
		$item_output = $indent . '<li role="presentation" class="dropdown-text"><p>';
		$item_output .= $args->link_before . $item->description . $args->link_after;
		$item_output .= "</p></li>";
	} elseif ( strcasecmp( $item->attr_title, 'dropdown-social') == 0 && $depth === 1 ) {
		global $ss_social;

		// Clase base para los iconos que va a ser usados.
		$baseclass  = 'icon el-icon-';

		// Array de las redes sociales disponibles.
		$networks = $ss_social->get_social_links();

		$item_output = $indent . '<ul class="rrss text-muted list-inline">';
		if ( ! is_null( $networks ) ) {
			foreach ( $networks as $network ) {
				// Comprobar si se ha definido la red social
				if ( isset( $network['url'] ) && ! empty( $network['url'] ) ) {
					$item_output .= '<li><a target="_blank" href="' . $network['url'] . '">';
					$item_output .= '<i class="' . $baseclass . $network['icon'] . '"></i>';
					$item_output .= '</a></li>';
				}
			}
		}
		$item_output .= '</ul>';
	}
	return $item_output;
}, 10, 4);

// Pemitir HTML en las descripciones de los elementos de menú
remove_filter( 'nav_menu_description', 'strip_tags' );
add_filter( 'wp_setup_nav_menu_item', function( $menu_item ) {
     $menu_item->description = apply_filters( 'nav_menu_description', $menu_item->post_content );
     return $menu_item;
});

/*
 * Añadir los iconos corporativos a la cabecera, si no han sido especificados
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
 * Usar por defecto el CDN de Google para JQuery.
 */

add_filter( 'shoestrap_module_advanced_options_modifier',
	imagen_ull_make_default_option_modifier( 'jquery_cdn_toggler', 1 ) );

?>
