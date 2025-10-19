<?php
/**
 * The Footer: widgets area, logo, footer menu and socials
 *
 * @package VERSE
 * @since VERSE 1.0
 */

							do_action( 'verse_action_page_content_end_text' );
							
							// Widgets area below the content
							verse_create_widgets_area( 'widgets_below_content' );
						
							do_action( 'verse_action_page_content_end' );
							?>
						</div>
						<?php
						
						do_action( 'verse_action_after_page_content' );

						// Show main sidebar
						get_sidebar();

						do_action( 'verse_action_content_wrap_end' );
						?>
					</div>
					<?php

					do_action( 'verse_action_after_content_wrap' );

					// Widgets area below the page and related posts below the page
					$verse_body_style = verse_get_theme_option( 'body_style' );
					$verse_widgets_name = verse_get_theme_option( 'widgets_below_page' );
					$verse_show_widgets = ! verse_is_off( $verse_widgets_name ) && is_active_sidebar( $verse_widgets_name );
					$verse_show_related = verse_is_single() && verse_get_theme_option( 'related_position' ) == 'below_page';
					if ( $verse_show_widgets || $verse_show_related ) {
						if ( 'fullscreen' != $verse_body_style ) {
							?>
							<div class="content_wrap">
							<?php
						}
						// Show related posts before footer
						if ( $verse_show_related ) {
							do_action( 'verse_action_related_posts' );
						}

						// Widgets area below page content
						if ( $verse_show_widgets ) {
							verse_create_widgets_area( 'widgets_below_page' );
						}
						if ( 'fullscreen' != $verse_body_style ) {
							?>
							</div>
							<?php
						}
					}
					do_action( 'verse_action_page_content_wrap_end' );
					?>
			</div>
			<?php
			do_action( 'verse_action_after_page_content_wrap' );

			// Don't display the footer elements while actions 'full_post_loading' and 'prev_post_loading'
			if ( ( ! verse_is_singular( 'post' ) && ! verse_is_singular( 'attachment' ) ) || ! in_array ( verse_get_value_gp( 'action' ), array( 'full_post_loading', 'prev_post_loading' ) ) ) {
				
				// Skip link anchor to fast access to the footer from keyboard
				?>
				<a id="footer_skip_link_anchor" class="verse_skip_link_anchor" href="#"></a>
				<?php

				do_action( 'verse_action_before_footer' );

				// Footer
				$verse_footer_type = verse_get_theme_option( 'footer_type' );
				if ( 'custom' == $verse_footer_type && ! verse_is_layouts_available() ) {
					$verse_footer_type = 'default';
				}
				get_template_part( apply_filters( 'verse_filter_get_template_part', "templates/footer-" . sanitize_file_name( $verse_footer_type ) ) );

				do_action( 'verse_action_after_footer' );

			}
			?>

			<?php do_action( 'verse_action_page_wrap_end' ); ?>

		</div>

		<?php do_action( 'verse_action_after_page_wrap' ); ?>

	</div>

	<?php do_action( 'verse_action_after_body' ); ?>

	<?php wp_footer(); ?>

</body>
</html>