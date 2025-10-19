<?php
/**
 * The template to display default site footer
 *
 * @package VERSE
 * @since VERSE 1.0.10
 */

?>
<footer class="footer_wrap footer_default
<?php
$verse_footer_scheme = verse_get_theme_option( 'footer_scheme' );
if ( ! empty( $verse_footer_scheme ) && ! verse_is_inherit( $verse_footer_scheme  ) ) {
	echo ' scheme_' . esc_attr( $verse_footer_scheme );
}
?>
				">
	<?php

	// Footer widgets area
	get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/footer-widgets' ) );

	// Logo
	get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/footer-logo' ) );

	// Socials
	get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/footer-socials' ) );

	// Copyright area
	get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/footer-copyright' ) );

	?>
</footer><!-- /.footer_wrap -->
