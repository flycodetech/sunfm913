<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package VERSE
 * @since VERSE 1.0
 */

if ( verse_sidebar_present() ) {
	
	$verse_sidebar_type = verse_get_theme_option( 'sidebar_type' );
	if ( 'custom' == $verse_sidebar_type && ! verse_is_layouts_available() ) {
		$verse_sidebar_type = 'default';
	}
	
	// Catch output to the buffer
	ob_start();
	if ( 'default' == $verse_sidebar_type ) {
		// Default sidebar with widgets
		$verse_sidebar_name = verse_get_theme_option( 'sidebar_widgets' );
		verse_storage_set( 'current_sidebar', 'sidebar' );
		if ( is_active_sidebar( $verse_sidebar_name ) ) {
			dynamic_sidebar( $verse_sidebar_name );
		}
	} else {
		// Custom sidebar from Layouts Builder
		$verse_sidebar_id = verse_get_custom_sidebar_id();
		do_action( 'verse_action_show_layout', $verse_sidebar_id );
	}
	$verse_out = trim( ob_get_contents() );
	ob_end_clean();
	
	// If any html is present - display it
	if ( ! empty( $verse_out ) ) {
		$verse_sidebar_position    = verse_get_theme_option( 'sidebar_position' );
		$verse_sidebar_position_ss = verse_get_theme_option( 'sidebar_position_ss' );
		?>
		<div class="sidebar widget_area
			<?php
			echo ' ' . esc_attr( $verse_sidebar_position );
			echo ' sidebar_' . esc_attr( $verse_sidebar_position_ss );
			echo ' sidebar_' . esc_attr( $verse_sidebar_type );

			$verse_sidebar_scheme = apply_filters( 'verse_filter_sidebar_scheme', verse_get_theme_option( 'sidebar_scheme' ) );
			if ( ! empty( $verse_sidebar_scheme ) && ! verse_is_inherit( $verse_sidebar_scheme ) && 'custom' != $verse_sidebar_type ) {
				echo ' scheme_' . esc_attr( $verse_sidebar_scheme );
			}
			?>
		" role="complementary">
			<?php

			// Skip link anchor to fast access to the sidebar from keyboard
			?>
			<a id="sidebar_skip_link_anchor" class="verse_skip_link_anchor" href="#"></a>
			<?php

			do_action( 'verse_action_before_sidebar_wrap', 'sidebar' );

			// Button to show/hide sidebar on mobile
			if ( in_array( $verse_sidebar_position_ss, array( 'above', 'float' ) ) ) {
				$verse_title = apply_filters( 'verse_filter_sidebar_control_title', 'float' == $verse_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'verse' ) : '' );
				$verse_text  = apply_filters( 'verse_filter_sidebar_control_text', 'above' == $verse_sidebar_position_ss ? esc_html__( 'Show Sidebar', 'verse' ) : '' );
				?>
				<a href="#" class="sidebar_control" title="<?php echo esc_attr( $verse_title ); ?>"><?php echo esc_html( $verse_text ); ?></a>
				<?php
			}
			?>
			<div class="sidebar_inner">
				<?php
				do_action( 'verse_action_before_sidebar', 'sidebar' );
				verse_show_layout( preg_replace( "/<\/aside>[\r\n\s]*<aside/", '</aside><aside', $verse_out ) );
				do_action( 'verse_action_after_sidebar', 'sidebar' );
				?>
			</div>
			<?php

			do_action( 'verse_action_after_sidebar_wrap', 'sidebar' );

			?>
		</div>
		<div class="clearfix"></div>
		<?php
	}
}
