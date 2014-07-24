<?php
require_once( dirname(__FILE__) . '/icons.php' );

/*
 * Obtener los links a las redes sociales especificados en la configuración
 */
function imagen_ull_get_social_links() {
	global $ss_social;
	$networks = $ss_social->get_social_links();

	// Mapear el nombre de los iconos
	return array_map( function( $network ) {
		if ( isset( $network['icon'] ) ) {
			$icon = imagen_ull_font_awesome_icons($network['icon']);
			if ( isset( $icon ) ) {
				$network['icon'] = $icon;
			}
		}
		return $network;
	}, $networks);
}

/*
 * Cambiar el valor por defecto de la opción especificada de Shoestrap.
 */
function imagen_ull_make_default_option_modifier( $id, $default_value) {
	return function ( $fields ) use ( $id, $default_value ) {
		return array_map( function( $field ) use ( $id, $default_value ) {
			if ( $field['id'] == $id ) {
				$field['default'] = $default_value;
			}
			return $field;
		}, $fields);
	};
}

?> 
