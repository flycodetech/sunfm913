<?php
/**
 * The template to display the logo or the site name and the slogan in the Header
 *
 * @package VERSE
 * @since VERSE 1.0
 */

$verse_args = get_query_var( 'verse_logo_args' );

// Site logo
$verse_logo_type   = isset( $verse_args['type'] ) ? $verse_args['type'] : '';
$verse_logo_image  = verse_get_logo_image( $verse_logo_type );
$verse_logo_text   = verse_is_on( verse_get_theme_option( 'logo_text' ) ) ? get_bloginfo( 'name' ) : '';
$verse_logo_slogan = get_bloginfo( 'description', 'display' );
if ( ! empty( $verse_logo_image['logo'] ) || ! empty( $verse_logo_text ) ) {
	?><a class="sc_layouts_logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
		<?php
		if ( ! empty( $verse_logo_image['logo'] ) ) {
			if ( empty( $verse_logo_type ) && function_exists( 'the_custom_logo' ) && is_numeric($verse_logo_image['logo']) && (int) $verse_logo_image['logo'] > 0 ) {
				the_custom_logo();
			} else {
				$verse_attr = verse_getimagesize( $verse_logo_image['logo'] );
				echo '<img src="' . esc_url( $verse_logo_image['logo'] ) . '"'
						. ( ! empty( $verse_logo_image['logo_retina'] ) ? ' srcset="' . esc_url( $verse_logo_image['logo_retina'] ) . ' 2x"' : '' )
						. ' alt="' . esc_attr( $verse_logo_text ) . '"'
						. ( ! empty( $verse_attr[3] ) ? ' ' . wp_kses_data( $verse_attr[3] ) : '' )
						. '>';
			}
		} else {
			verse_show_layout( verse_prepare_macros( $verse_logo_text ), '<span class="logo_text">', '</span>' );
			verse_show_layout( verse_prepare_macros( $verse_logo_slogan ), '<span class="logo_slogan">', '</span>' );
		}
		?>
	</a>
	<?php
}
