<?php
/**
 * The template to display default site footer
 *
 * @package VERSE
 * @since VERSE 1.0.10
 */

$verse_footer_id = verse_get_custom_footer_id();
$verse_footer_meta = get_post_meta( $verse_footer_id, 'trx_addons_options', true );
if ( ! empty( $verse_footer_meta['margin'] ) ) {
	verse_add_inline_css( sprintf( '.page_content_wrap{padding-bottom:%s}', esc_attr( verse_prepare_css_value( $verse_footer_meta['margin'] ) ) ) );
}
?>
<footer class="footer_wrap footer_custom footer_custom_<?php echo esc_attr( $verse_footer_id ); ?> footer_custom_<?php echo esc_attr( sanitize_title( get_the_title( $verse_footer_id ) ) ); ?>
						<?php
						$verse_footer_scheme = verse_get_theme_option( 'footer_scheme' );
						if ( ! empty( $verse_footer_scheme ) && ! verse_is_inherit( $verse_footer_scheme  ) ) {
							echo ' scheme_' . esc_attr( $verse_footer_scheme );
						}
						?>
						">
	<?php
	// Custom footer's layout
	do_action( 'verse_action_show_layout', $verse_footer_id );
	?>
</footer><!-- /.footer_wrap -->
