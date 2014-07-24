<?php

/*
 * Definiciones de las URL de los iconos de la imagen corporativa.
 */

define( 'IMAGEN_ULL_FAVICON', 		'//static.ull.es/v3/dist/img/favicon.ico');

define( 'IMAGEN_ULL_APPLEICON_144', '//static.ull.es/v3/dist/img/apple-touch-icon-144-precomposed.png');
define( 'IMAGEN_ULL_APPLEICON_114', '//static.ull.es/v3/dist/img/apple-touch-icon-114-precomposed.png');
define( 'IMAGEN_ULL_APPLEICON_72',	'//static.ull.es/v3/dist/img/apple-touch-icon-72-precomposed.png');
define( 'IMAGEN_ULL_APPLEICON_57',	'//static.ull.es/v3/dist/img/apple-touch-icon-57-precomposed.png');

/*
 * Mapeo de los nombres de iconos Elusive a Font Awesome
 */

function imagen_ull_font_awesome_icons( $icon ) {
	switch ( $icon ) {
		case 'facebook':
		case 'twitter':
		case 'github':
		case 'linkedin':
		case 'instagram':
		case 'pinterest':
		case 'vimeo':
		case 'youtube':
			return $icon-'square';

		case 'googleplus':
			return 'google-plus-square';

		default:
			return $icon;
	}
}

?>