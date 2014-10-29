<?php
require_once( dirname(__FILE__) . '/lib/simple_html_dom.php' );

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

/*
 * Función contenedora para mostrar las barras laterales.
 */
function imagen_ull_dynamic_sidebar( $index ) {
	// Capturar la salida de los widgets
	ob_start();
	$result = dynamic_sidebar( $index );
	$content = str_get_html( ob_get_clean() );

	// Incorporar a las etiquetas <ul> las clases de bootstrap adecuadas
	$items = $content->find( 'div.panel-body > ul' );
	foreach ( $items as $item ) {
		$item->class = 'nav nav-pills nav-stacked';
	}

	// Añadir iconos junto ia las entradas de comentarios recientes
	$items = $content->find( '#recentcomments > li' );
	foreach ( $items as $item ) {
		$item->innertext = '<i class="fa fa-edit"></i>&nbsp;' . $item->innertext;
	}

	// Mostrar el contenido de la barra lateral
	echo $content;
	return $result;
}
