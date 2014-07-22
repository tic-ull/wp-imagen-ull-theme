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
 * Mapeo de nombres de los iconos Elusive a los de Font Awesome
 */

$_imagen_ull_font_awesome_icons = array(
	'facebook' => 'facebook-square',
	'twitter' => 'twitter-square',
	'github' => 'github-square',
	'linkedin' => 'linkedin-square',
	'googleplus' => 'google-plus-square',
	'instagram' => 'instagram-square',
	'pinterest' => 'pinterest-square',
	'vimeo' => 'vimeo-square',
	'youtube' => 'youtube-square',
);

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
	$class = 'navbar navbar-default';
	if ( $context == 'ull-bar' ) {
		return $class . ' navbar-ull';
	} else {
		return $class . ' navbar-app';
	}
}, 11, 2 );

add_filter( 'shoestrap_nav_class', function ($class ) {
	return 'navbar-nav nav navbar-right';
}, 11);

/*
 * Soporte de Font Awesome en los menús de navegación.
 *
 * Simplemente hay que añadir la clase CSS fa-(nombre del icono) al elemento
 * de menú correspondiente.
 */
function imagen_ull_nav_menu_font_awesome_icon( $item, $args ) {
	$before = true;
	$fontawesome_classes = array();
	foreach ( $item->classes as $class ) {
		if ( substr( $class, 0, 2 ) == 'fa' ) {
			if ( $class == 'fa-after' ) {
				$before = false;
			} elseif ( $class != 'fa' ) {
				$fontawesome_classes[] = $class;
			}
		}
	}

	if ( !empty( $fontawesome_classes ) ) {
		$fontawesome_classes[] = 'fa';
		$classes = implode( ' ', $fontawesome_classes );
		if( $before ){
			$args->link_before = '<i class="'.$classes.'"></i>&nbsp;';
		} else {
			$args->link_after = '&nbsp;<i class="'.$classes.'"></i>';
		}
	} else {
		// Necesario por el valor de $args se preserva entre invocaciones
		$args->link_before = '';
		$args->link_after = '';
	}
}

add_filter( 'nav_menu_link_attributes' , function( $atts, $item, $args ) {
	imagen_ull_nav_menu_font_awesome_icon( $item, $args );
	return $atts;
}, 10, 3);

// Quitar las clases fa-(nombre del icono) de los elementos <li>
add_filter( 'nav_menu_css_class' , function( $classes, $item, $args ) {
	return array_filter( $classes, function( $class ) {
		return ( substr( $class, 0, 2 ) == 'fa' ) ? false : true;
	});
}, 10, 3);

// Incluir los estilos de Font Awesome desde el CDN de Bootstrap
add_action( 'wp_enqueue_scripts', function() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css', array(), '4.1.0', 'all' );
});

/*
 * Soporte de tipos especiales de entradas en los menús de navegación.
 *
 * Para incorporar texto HTML libre no enlazado, simplemente añadir el atributo
 * dropdown-text al elemento de menú y el texto en cuestión a su descripción.
 *
 * Para incorporar una entrada con enlaces a las redes sociales, simplemente
 * añadir el atributo dropdown-social al elemento de menú.
 */
add_filter( 'walker_nav_menu_start_el', function( $item_output, $item, $depth, $args ) {
	$indent = ( $depth ) ? str_repeat( "\t", $depth ) : '';
	if ( strcasecmp( $item->attr_title, 'dropdown-text') == 0 && $depth === 1 ) {
//		No hace falta invocar:
//
//		imagen_ull_nav_menu_font_awesome_icon( $item, $args );
//
//		para soportar los iconos de Font Awesome si ya se hizo previamente
//		en el filtro 'nav_menu_link_attributes'.
		$item_output = $indent . '<li role="presentation" class="dropdown-text"><p>';
		$item_output .= $args->link_before . $item->description . $args->link_after;
		$item_output .= "</p></li>";
	} elseif ( strcasecmp( $item->attr_title, 'dropdown-social') == 0 && $depth === 1 ) {
		$networks = get_social_links();
		$item_output = $indent . '<ul class="rrss text-muted list-inline">';
		if ( ! is_null( $networks ) ) {
			foreach ( $networks as $network ) {
				// Comprobar si se ha definido la red social
				if ( isset( $network['url'] ) && ! empty( $network['url'] ) ) {
					$item_output .= '<li><a target="_blank" href="' . $network['url'] . '"><i class="fa fa-' . $network['icon'] . '"></i></a></li>';
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
 * Obtener los links a las redes sociales especificados en la configuración
 */
function get_social_links() {
	global $ss_social;
	$networks = $ss_social->get_social_links();

	// Mapear el nombre de los iconos a Font Awesome
	return array_map( function( $network ) {
		global $_imagen_ull_font_awesome_icons;
		if ( isset( $network['icon'] ) ) {
			$icon = $network['icon'];
			if ( isset( $_imagen_ull_font_awesome_icons[$icon] ) ) {
				$network['icon'] = $_imagen_ull_font_awesome_icons[$icon];
			}
		}
		return $network;
	}, $networks);
}

?>
