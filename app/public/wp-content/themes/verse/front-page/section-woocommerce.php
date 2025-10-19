<?php
$verse_woocommerce_sc = verse_get_theme_option( 'front_page_woocommerce_products' );
if ( ! empty( $verse_woocommerce_sc ) ) {
	?><div class="front_page_section front_page_section_woocommerce<?php
		$verse_scheme = verse_get_theme_option( 'front_page_woocommerce_scheme' );
		if ( ! empty( $verse_scheme ) && ! verse_is_inherit( $verse_scheme ) ) {
			echo ' scheme_' . esc_attr( $verse_scheme );
		}
		echo ' front_page_section_paddings_' . esc_attr( verse_get_theme_option( 'front_page_woocommerce_paddings' ) );
		if ( verse_get_theme_option( 'front_page_woocommerce_stack' ) ) {
			echo ' sc_stack_section_on';
		}
	?>"
			<?php
			$verse_css      = '';
			$verse_bg_image = verse_get_theme_option( 'front_page_woocommerce_bg_image' );
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
		$verse_anchor_icon = verse_get_theme_option( 'front_page_woocommerce_anchor_icon' );
		$verse_anchor_text = verse_get_theme_option( 'front_page_woocommerce_anchor_text' );
		if ( ( ! empty( $verse_anchor_icon ) || ! empty( $verse_anchor_text ) ) && shortcode_exists( 'trx_sc_anchor' ) ) {
			echo do_shortcode(
				'[trx_sc_anchor id="front_page_section_woocommerce"'
											. ( ! empty( $verse_anchor_icon ) ? ' icon="' . esc_attr( $verse_anchor_icon ) . '"' : '' )
											. ( ! empty( $verse_anchor_text ) ? ' title="' . esc_attr( $verse_anchor_text ) . '"' : '' )
											. ']'
			);
		}
	?>
		<div class="front_page_section_inner front_page_section_woocommerce_inner
			<?php
			if ( verse_get_theme_option( 'front_page_woocommerce_fullheight' ) ) {
				echo ' verse-full-height sc_layouts_flex sc_layouts_columns_middle';
			}
			?>
				"
				<?php
				$verse_css      = '';
				$verse_bg_mask  = verse_get_theme_option( 'front_page_woocommerce_bg_mask' );
				$verse_bg_color_type = verse_get_theme_option( 'front_page_woocommerce_bg_color_type' );
				if ( 'custom' == $verse_bg_color_type ) {
					$verse_bg_color = verse_get_theme_option( 'front_page_woocommerce_bg_color' );
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
			<div class="front_page_section_content_wrap front_page_section_woocommerce_content_wrap content_wrap woocommerce">
				<?php
				// Content wrap with title and description
				$verse_caption     = verse_get_theme_option( 'front_page_woocommerce_caption' );
				$verse_description = verse_get_theme_option( 'front_page_woocommerce_description' );
				if ( ! empty( $verse_caption ) || ! empty( $verse_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
					// Caption
					if ( ! empty( $verse_caption ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<h2 class="front_page_section_caption front_page_section_woocommerce_caption front_page_block_<?php echo ! empty( $verse_caption ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( $verse_caption, 'verse_kses_content' );
						?>
						</h2>
						<?php
					}

					// Description (text)
					if ( ! empty( $verse_description ) || ( current_user_can( 'edit_theme_options' ) && is_customize_preview() ) ) {
						?>
						<div class="front_page_section_description front_page_section_woocommerce_description front_page_block_<?php echo ! empty( $verse_description ) ? 'filled' : 'empty'; ?>">
						<?php
							echo wp_kses( wpautop( $verse_description ), 'verse_kses_content' );
						?>
						</div>
						<?php
					}
				}

				// Content (widgets)
				?>
				<div class="front_page_section_output front_page_section_woocommerce_output list_products shop_mode_thumbs">
					<?php
					if ( 'products' == $verse_woocommerce_sc ) {
						$verse_woocommerce_sc_ids      = verse_get_theme_option( 'front_page_woocommerce_products_per_page' );
						$verse_woocommerce_sc_per_page = count( explode( ',', $verse_woocommerce_sc_ids ) );
					} else {
						$verse_woocommerce_sc_per_page = max( 1, (int) verse_get_theme_option( 'front_page_woocommerce_products_per_page' ) );
					}
					$verse_woocommerce_sc_columns = max( 1, min( $verse_woocommerce_sc_per_page, (int) verse_get_theme_option( 'front_page_woocommerce_products_columns' ) ) );
					echo do_shortcode(
						"[{$verse_woocommerce_sc}"
										. ( 'products' == $verse_woocommerce_sc
												? ' ids="' . esc_attr( $verse_woocommerce_sc_ids ) . '"'
												: '' )
										. ( 'product_category' == $verse_woocommerce_sc
												? ' category="' . esc_attr( verse_get_theme_option( 'front_page_woocommerce_products_categories' ) ) . '"'
												: '' )
										. ( 'best_selling_products' != $verse_woocommerce_sc
												? ' orderby="' . esc_attr( verse_get_theme_option( 'front_page_woocommerce_products_orderby' ) ) . '"'
													. ' order="' . esc_attr( verse_get_theme_option( 'front_page_woocommerce_products_order' ) ) . '"'
												: '' )
										. ' per_page="' . esc_attr( $verse_woocommerce_sc_per_page ) . '"'
										. ' columns="' . esc_attr( $verse_woocommerce_sc_columns ) . '"'
						. ']'
					);
					?>
				</div>
			</div>
		</div>
	</div>
	<?php
}
