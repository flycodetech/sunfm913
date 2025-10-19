<?php
/**
 * The template to display custom header from the ThemeREX Addons Layouts
 *
 * @package VERSE
 * @since VERSE 1.0.06
 */

$verse_header_css   = '';
$verse_header_image = get_header_image();
$verse_header_video = verse_get_header_video();
if ( ! empty( $verse_header_image ) && verse_trx_addons_featured_image_override( is_singular() || verse_storage_isset( 'blog_archive' ) || is_category() ) ) {
	$verse_header_image = verse_get_current_mode_image( $verse_header_image );
}

$verse_header_id = verse_get_custom_header_id();
$verse_header_meta = get_post_meta( $verse_header_id, 'trx_addons_options', true );
if ( ! empty( $verse_header_meta['margin'] ) ) {
	verse_add_inline_css( sprintf( '.page_content_wrap{padding-top:%s}', esc_attr( verse_prepare_css_value( $verse_header_meta['margin'] ) ) ) );
}

?><header class="top_panel top_panel_custom top_panel_custom_<?php echo esc_attr( $verse_header_id ); ?> top_panel_custom_<?php echo esc_attr( sanitize_title( get_the_title( $verse_header_id ) ) ); ?>
				<?php
				echo ! empty( $verse_header_image ) || ! empty( $verse_header_video )
					? ' with_bg_image'
					: ' without_bg_image';
				if ( '' != $verse_header_video ) {
					echo ' with_bg_video';
				}
				if ( '' != $verse_header_image ) {
					echo ' ' . esc_attr( verse_add_inline_css_class( 'background-image: url(' . esc_url( $verse_header_image ) . ');' ) );
				}
				if ( is_single() && has_post_thumbnail() ) {
					echo ' with_featured_image';
				}
				if ( verse_is_on( verse_get_theme_option( 'header_fullheight' ) ) ) {
					echo ' header_fullheight verse-full-height';
				}
				$verse_header_scheme = verse_get_theme_option( 'header_scheme' );
				if ( ! empty( $verse_header_scheme ) && ! verse_is_inherit( $verse_header_scheme  ) ) {
					echo ' scheme_' . esc_attr( $verse_header_scheme );
				}
				?>
">
	<?php

	// Background video
	if ( ! empty( $verse_header_video ) ) {
		get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/header-video' ) );
	}

	// Custom header's layout
	do_action( 'verse_action_show_layout', $verse_header_id );

	// Header widgets area
	get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/header-widgets' ) );

	?>
</header>
