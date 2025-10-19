<div class="front_page_section front_page_section_subscribe<?php
	$verse_scheme = verse_get_theme_option( 'front_page_subscribe_scheme' );
	if ( ! empty( $verse_scheme ) && ! verse_is_inherit( $verse_scheme ) ) {
		echo ' scheme_' . esc_attr( $verse_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( verse_get_theme_option( 'front_page_subscribe_paddings' ) );
	if ( verse_get_theme_option( 'front_page_subscribe_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$verse_css      = '';
		$verse_bg_image = verse_get_theme_option( 'front_page_subscribe_bg_image' );
		if ( ! empty( $verse_bg_image ) ) {
			$verse_css .= 'background-image: url(' . esc_url( verse_get_attachment_url( $verse_bg_image ) ) . ');';
		}
		if ( ! empty( $verse_css ) ) {
			echo ' style="' . esc_attr( $verse_css ) . '"';
		}
		?>
>
<?php
	// Add anchor
	$verse_anchor_icon = verse_get_theme_option( 'front_page_subscribe_anchor_icon' );
	$verse_anchor_text = verse_get_theme_option( 'front_page_subscribe_anchor_text' );
if ( ( ! empty( $verse_anchor_icon ) || ! empty( $verse_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_subscribe"'
									. ( ! empty( $verse_anchor_icon ) ? ' icon="' . esc_attr( $verse_anchor_icon ) . '"' : '' )
									. ( ! empty( $verse_anchor_text ) ? ' title="' . esc_attr( $verse_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_subscribe_inner
	<?php
	if ( verse_get_theme_option( 'front_page_subscribe_fullheight' ) ) {
		echo ' verse-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$verse_css      = '';
			$verse_bg_mask  = verse_get_theme_option( 'front_page_subscribe_bg_mask' );
			$verse_bg_color_type = verse_get_theme_option( 'front_page_subscribe_bg_color_type' );
			if ( 'custom' == $verse_bg_color_type ) {
				$verse_bg_color = verse_get_theme_option( 'front_page_subscribe_bg_color' );
			} elseif ( 'scheme_bg_color' == $verse_bg_color_type ) {
				$verse_bg_color = verse_get_scheme_color( 'bg_color', $verse_scheme );
			} else {
				$verse_bg_color = '';
			}
			if ( ! empty( $verse_bg_color ) && $verse_bg_mask > 0 ) {
				$verse_css .= 'background-color: ' . esc_attr(
					1 == $verse_bg_mask ? $verse_bg_color : verse_hex2rgba( $verse_bg_color, $verse_bg_mask )
				) . ';';
			}
			if ( ! empty( $verse_css ) ) {
				echo ' style="' . esc_attr( $verse_css ) . '"';
			}
			?>
	>
		<div class="front_page_section_content_wrap front_page_section_subscribe_content_wrap content_wrap">
			<?php
			// Caption
			$verse_caption = verse_get_theme_option( 'front_page_subscribe_caption' );
			if ( ! empty( $verse_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_subscribe_caption front_page_block_<?php echo ! empty( $verse_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $verse_caption, 'verse_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$verse_description = verse_get_theme_option( 'front_page_subscribe_description' );
			if ( ! empty( $verse_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_subscribe_description front_page_block_<?php echo ! empty( $verse_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $verse_description ), 'verse_kses_content' ); ?></div>
				<?php
			}

			// Content
			$verse_sc = verse_get_theme_option( 'front_page_subscribe_shortcode' );
			if ( ! empty( $verse_sc ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_output front_page_section_subscribe_output front_page_block_<?php echo ! empty( $verse_sc ) ? 'filled' : 'empty'; ?>">
				<?php
					verse_show_layout( do_shortcode( $verse_sc ) );
				?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
