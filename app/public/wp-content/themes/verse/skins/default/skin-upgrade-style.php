<?php
// Add plugin-specific colors and fonts to the custom CSS
if ( ! function_exists( 'verse_extra_get_css' ) ) {
	add_filter( 'verse_filter_get_css', 'verse_extra_get_css', 10, 2 );
	function verse_extra_get_css( $css, $args ) {
		if ( isset( $css['fonts'] ) && isset( $args['fonts'] ) ) {
			$fonts         = $args['fonts'];
			$css['fonts'] .= <<<CSS



		.trx_addons_bg_text_char {
			{$fonts['h5_font-family']}
		}

CSS;
		}

		return $css;
	}
}

