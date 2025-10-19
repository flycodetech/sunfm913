<?php
/**
 * The template to display the widgets area in the header
 *
 * @package VERSE
 * @since VERSE 1.0
 */

// Header sidebar
$verse_header_name    = verse_get_theme_option( 'header_widgets' );
$verse_header_present = ! verse_is_off( $verse_header_name ) && is_active_sidebar( $verse_header_name );
if ( $verse_header_present ) {
	verse_storage_set( 'current_sidebar', 'header' );
	$verse_header_wide = verse_get_theme_option( 'header_wide' );
	ob_start();
	if ( is_active_sidebar( $verse_header_name ) ) {
		dynamic_sidebar( $verse_header_name );
	}
	$verse_widgets_output = ob_get_contents();
	ob_end_clean();
	if ( ! empty( $verse_widgets_output ) ) {
		$verse_widgets_output = preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $verse_widgets_output );
		$verse_need_columns   = strpos( $verse_widgets_output, 'columns_wrap' ) === false;
		if ( $verse_need_columns ) {
			$verse_columns = max( 0, (int) verse_get_theme_option( 'header_columns' ) );
			if ( 0 == $verse_columns ) {
				$verse_columns = min( 6, max( 1, verse_tags_count( $verse_widgets_output, 'aside' ) ) );
			}
			if ( $verse_columns > 1 ) {
				$verse_widgets_output = preg_replace( '/<aside([^>]*)class="widget/', '<aside$1class="column-1_' . esc_attr( $verse_columns ) . ' widget', $verse_widgets_output );
			} else {
				$verse_need_columns = false;
			}
		}
		?>
		<div class="header_widgets_wrap widget_area<?php echo ! empty( $verse_header_wide ) ? ' header_fullwidth' : ' header_boxed'; ?>">
			<?php do_action( 'verse_action_before_sidebar_wrap', 'header' ); ?>
			<div class="header_widgets_inner widget_area_inner">
				<?php
				if ( ! $verse_header_wide ) {
					?>
					<div class="content_wrap">
					<?php
				}
				if ( $verse_need_columns ) {
					?>
					<div class="columns_wrap">
					<?php
				}
				do_action( 'verse_action_before_sidebar', 'header' );
				verse_show_layout( $verse_widgets_output );
				do_action( 'verse_action_after_sidebar', 'header' );
				if ( $verse_need_columns ) {
					?>
					</div>	<!-- /.columns_wrap -->
					<?php
				}
				if ( ! $verse_header_wide ) {
					?>
					</div>	<!-- /.content_wrap -->
					<?php
				}
				?>
			</div>	<!-- /.header_widgets_inner -->
			<?php do_action( 'verse_action_after_sidebar_wrap', 'header' ); ?>
		</div>	<!-- /.header_widgets_wrap -->
		<?php
	}
}
