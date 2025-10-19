<div class="front_page_section front_page_section_about<?php
	$verse_scheme = verse_get_theme_option( 'front_page_about_scheme' );
	if ( ! empty( $verse_scheme ) && ! verse_is_inherit( $verse_scheme ) ) {
		echo ' scheme_' . esc_attr( $verse_scheme );
	}
	echo ' front_page_section_paddings_' . esc_attr( verse_get_theme_option( 'front_page_about_paddings' ) );
	if ( verse_get_theme_option( 'front_page_about_stack' ) ) {
		echo ' sc_stack_section_on';
	}
?>"
		<?php
		$verse_css      = '';
		$verse_bg_image = verse_get_theme_option( 'front_page_about_bg_image' );
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
	$verse_anchor_icon = verse_get_theme_option( 'front_page_about_anchor_icon' );
	$verse_anchor_text = verse_get_theme_option( 'front_page_about_anchor_text' );
if ( ( ! empty( $verse_anchor_icon ) || ! empty( $verse_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
	echo do_shortcode(
		'[trx_sc_anchor id="front_page_section_about"'
									. ( ! empty( $verse_anchor_icon ) ? ' icon="' . esc_attr( $verse_anchor_icon ) . '"' : '' )
									. ( ! empty( $verse_anchor_text ) ? ' title="' . esc_attr( $verse_anchor_text ) . '"' : '' )
									. ']'
	);
}
?>
	<div class="front_page_section_inner front_page_section_about_inner
	<?php
	if ( verse_get_theme_option( 'front_page_about_fullheight' ) ) {
		echo ' verse-full-height sc_layouts_flex sc_layouts_columns_middle';
	}
	?>
			"
			<?php
			$verse_css           = '';
			$verse_bg_mask       = verse_get_theme_option( 'front_page_about_bg_mask' );
			$verse_bg_color_type = verse_get_theme_option( 'front_page_about_bg_color_type' );
			if ( 'custom' == $verse_bg_color_type ) {
				$verse_bg_color = verse_get_theme_option( 'front_page_about_bg_color' );
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
		<div class="front_page_section_content_wrap front_page_section_about_content_wrap content_wrap">
			<?php
			// Caption
			$verse_caption = verse_get_theme_option( 'front_page_about_caption' );
			if ( ! empty( $verse_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<h2 class="front_page_section_caption front_page_section_about_caption front_page_block_<?php echo ! empty( $verse_caption ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( $verse_caption, 'verse_kses_content' ); ?></h2>
				<?php
			}

			// Description (text)
			$verse_description = verse_get_theme_option( 'front_page_about_description' );
			if ( ! empty( $verse_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_description front_page_section_about_description front_page_block_<?php echo ! empty( $verse_description ) ? 'filled' : 'empty'; ?>"><?php echo wp_kses( wpautop( $verse_description ), 'verse_kses_content' ); ?></div>
				<?php
			}

			// Content
			$verse_content = verse_get_theme_option( 'front_page_about_content' );
			if ( ! empty( $verse_content ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
				?>
				<div class="front_page_section_content front_page_section_about_content front_page_block_<?php echo ! empty( $verse_content ) ? 'filled' : 'empty'; ?>">
					<?php
					$verse_page_content_mask = '%%CONTENT%%';
					if ( strpos( $verse_content, $verse_page_content_mask ) !== false ) {
						$verse_content = preg_replace(
							'/(\<p\>\s*)?' . $verse_page_content_mask . '(\s*\<\/p\>)/i',
							sprintf(
								'<div class="front_page_section_about_source">%s</div>',
								apply_filters( 'the_content', get_the_content() )
							),
							$verse_content
						);
					}
					verse_show_layout( $verse_content );
					?>
				</div>
				<?php
			}
			?>
		</div>
	</div>
</div>
