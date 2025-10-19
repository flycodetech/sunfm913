<?php
/**
 * The template to display the page title and breadcrumbs
 *
 * @package VERSE
 * @since VERSE 1.0
 */

// Page (category, tag, archive, author) title

if ( verse_need_page_title() ) {
	verse_sc_layouts_showed( 'title', true );
	verse_sc_layouts_showed( 'postmeta', true );
	?>
	<div class="top_panel_title sc_layouts_row sc_layouts_row_type_normal">
		<div class="content_wrap">
			<div class="sc_layouts_column sc_layouts_column_align_center">
				<div class="sc_layouts_item">
					<div class="sc_layouts_title sc_align_center">
						<?php
						// Post meta on the single post
						if ( is_single() ) {
							?>
							<div class="sc_layouts_title_meta">
							<?php
								verse_show_post_meta(
									apply_filters(
										'verse_filter_post_meta_args', array(
											'components' => join( ',', verse_array_get_keys_by_value( verse_get_theme_option( 'meta_parts' ) ) ),
											'counters'   => join( ',', verse_array_get_keys_by_value( verse_get_theme_option( 'counters' ) ) ),
											'seo'        => verse_is_on( verse_get_theme_option( 'seo_snippets' ) ),
										), 'header', 1
									)
								);
							?>
							</div>
							<?php
						}

						// Blog/Post title
						?>
						<div class="sc_layouts_title_title">
							<?php
							$verse_blog_title           = verse_get_blog_title();
							$verse_blog_title_text      = '';
							$verse_blog_title_class     = '';
							$verse_blog_title_link      = '';
							$verse_blog_title_link_text = '';
							if ( is_array( $verse_blog_title ) ) {
								$verse_blog_title_text      = $verse_blog_title['text'];
								$verse_blog_title_class     = ! empty( $verse_blog_title['class'] ) ? ' ' . $verse_blog_title['class'] : '';
								$verse_blog_title_link      = ! empty( $verse_blog_title['link'] ) ? $verse_blog_title['link'] : '';
								$verse_blog_title_link_text = ! empty( $verse_blog_title['link_text'] ) ? $verse_blog_title['link_text'] : '';
							} else {
								$verse_blog_title_text = $verse_blog_title;
							}
							?>
							<h1 itemprop="headline" class="sc_layouts_title_caption<?php echo esc_attr( $verse_blog_title_class ); ?>">
								<?php
								$verse_top_icon = verse_get_term_image_small();
								if ( ! empty( $verse_top_icon ) ) {
									$verse_attr = verse_getimagesize( $verse_top_icon );
									?>
									<img src="<?php echo esc_url( $verse_top_icon ); ?>" alt="<?php esc_attr_e( 'Site icon', 'verse' ); ?>"
										<?php
										if ( ! empty( $verse_attr[3] ) ) {
											verse_show_layout( $verse_attr[3] );
										}
										?>
									>
									<?php
								}
								echo wp_kses_data( $verse_blog_title_text );
								?>
							</h1>
							<?php
							if ( ! empty( $verse_blog_title_link ) && ! empty( $verse_blog_title_link_text ) ) {
								?>
								<a href="<?php echo esc_url( $verse_blog_title_link ); ?>" class="theme_button theme_button_small sc_layouts_title_link"><?php echo esc_html( $verse_blog_title_link_text ); ?></a>
								<?php
							}

							// Category/Tag description
							if ( ! is_paged() && ( is_category() || is_tag() || is_tax() ) ) {
								the_archive_description( '<div class="sc_layouts_title_description">', '</div>' );
							}

							?>
						</div>
						<?php

						// Breadcrumbs
						ob_start();
						do_action( 'verse_action_breadcrumbs' );
						$verse_breadcrumbs = ob_get_contents();
						ob_end_clean();
						verse_show_layout( $verse_breadcrumbs, '<div class="sc_layouts_title_breadcrumbs">', '</div>' );
						?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
}
