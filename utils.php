<?php

/**
 * Procesar las clases de los iconos Font Awesome.
 *
 * @param array $classes Clases entre las que buscar las de Font Awesome.
 * @param object $args Objeto de datos con el resultado.
 * @return array El resto de clases no relacionadas con Font Awesome.
 */

function imagen_ull_process_font_awesome_classes( $classes, $args ) {
	$before = true;
	$fontawesome_classes = array();
	$other_classes = array();
	foreach ( $classes as $class ) {
		if ( substr( $class, 0, 2 ) == 'fa' ) {
			if ( $class == 'fa-after' ) {
				$before = false;
			} elseif ( $class != 'fa' ) {
				$fontawesome_classes[] = $class;
			}
		} else {
			$other_classes[] = $class;
		}
	}

	$args->link_before = '';
	$args->link_after = '';

	if ( !empty( $fontawesome_classes ) ) {
		$fontawesome_classes[] = 'fa';
		$class_names = implode( ' ', $fontawesome_classes );
		if( $before ){
			$args->link_before = '<i class="'.$class_names.'"></i>&nbsp;';
		} else {
			$args->link_after = '&nbsp;<i class="'.$class_names.'"></i>';
		}
	}

	return $other_classes;
}

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
