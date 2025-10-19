<?php
/**
 * The template to display the widgets area in the footer
 *
 * @package VERSE
 * @since VERSE 1.0.10
 */

// Footer sidebar
$verse_footer_name    = verse_get_theme_option( 'footer_widgets' );
$verse_footer_present = ! verse_is_off( $verse_footer_name ) && is_active_sidebar( $verse_footer_name );
if ( $verse_footer_present ) {
	verse_storage_set( 'current_sidebar', 'footer' );
	$verse_footer_wide = verse_get_theme_option( 'footer_wide' );
	ob_start();
	if ( is_active_sidebar( $verse_footer_name ) ) {
		dynamic_sidebar( $verse_footer_name );
	}
	$verse_out = trim( ob_get_contents() );
	ob_end_clean();
	if ( ! empty( $verse_out ) ) {
		$verse_out          = preg_replace( "/<\\/aside>[\r\n\s]*<aside/", '</aside><aside', $verse_out );
		$verse_need_columns = true;   //or check: strpos($verse_out, 'columns_wrap')===false;
		if ( $verse_need_columns ) {
			$verse_columns = max( 0, (int) verse_get_theme_option( 'footer_columns' ) );			
			if ( 0 == $verse_columns ) {
				$verse_columns = min( 4, max( 1, verse_tags_count( $verse_out, 'aside' ) ) );
			}
			if ( $verse_columns > 1 ) {
				$verse_out = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $verse_columns ) . ' widget', $verse_out );
			} else {
				$verse_need_columns = false;
			}
		}
		?>
		<div class="footer_widgets_wrap widget_area<?php echo ! empty( $verse_footer_wide ) ? ' footer_fullwidth' : ''; ?> sc_layouts_row sc_layouts_row_type_normal">
			<?php do_action( 'verse_action_before_sidebar_wrap', 'footer' ); ?>
			<div class="footer_widgets_inner widget_area_inner">
				<?php
				if ( ! $verse_footer_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $verse_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'verse_action_before_sidebar', 'footer' );
				verse_show_layout( $verse_out );
				do_action( 'verse_action_after_sidebar', 'footer' );
				if ( $verse_need_columns ) {
					?>
					</div><!-- /.columns_wrap -->
					<?php
				}
				if ( ! $verse_footer_wide ) {
					?>
					</div><!-- /.content_wrap -->
					<?php
				}
				?>
			</div><!-- /.footer_widgets_inner -->
			<?php do_action( 'verse_action_after_sidebar_wrap', 'footer' ); ?>
		</div><!-- /.footer_widgets_wrap -->
		<?php
	}
}
