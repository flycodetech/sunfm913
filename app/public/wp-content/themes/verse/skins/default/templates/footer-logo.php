<?php
/**
 * The template to display the site logo in the footer
 *
 * @package VERSE
 * @since VERSE 1.0.10
 */

// Logo
if ( verse_is_on( verse_get_theme_option( 'logo_in_footer' ) ) ) {
	$verse_logo_image = verse_get_logo_image( 'footer' );
	$verse_logo_text  = get_bloginfo( 'name' );
	if ( ! empty( $verse_logo_image['logo'] ) || ! empty( $verse_logo_text ) ) {
		?>
		<div class="footer_logo_wrap">
			<div class="footer_logo_inner">
				<?php
				if ( ! empty( $verse_logo_image['logo'] ) ) {
					$verse_attr = verse_getimagesize( $verse_logo_image['logo'] );
					echo '<a href="' . esc_url( home_url( '/' ) ) . '">'
							. '<img src="' . esc_url( $verse_logo_image['logo'] ) . '"'
								. ( ! empty( $verse_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $verse_logo_image['logo_retina'] ) . ' 2x"' : '' )
								. ' class="logo_footer_image"'
								. ' alt="' . esc_attr__( 'Site logo', 'verse' ) . '"'
								. ( ! empty( $verse_attr[3] ) ? ' ' . wp_kses_data( $verse_attr[3] ) : '' )
							. '>'
						. '</a>';
				} elseif ( ! empty( $verse_logo_text ) ) {
					echo '<h1 class="logo_footer_text">'
							. '<a href="' . esc_url( home_url( '/' ) ) . '">'
								. esc_html( $verse_logo_text )
							. '</a>'
						. '</h1>';
				}
				?>
			</div>
		</div>
		<?php
	}
}
