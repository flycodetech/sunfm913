<?php
/**
 * The template to display single post
 *
 * @package VERSE
 * @since VERSE 1.0
 */

// Full post loading
$full_post_loading          = verse_get_value_gp( 'action' ) == 'full_post_loading';

// Prev post loading
$prev_post_loading          = verse_get_value_gp( 'action' ) == 'prev_post_loading';
$prev_post_loading_type     = verse_get_theme_option( 'posts_navigation_scroll_which_block' );

// Position of the related posts
$verse_related_position   = verse_get_theme_option( 'related_position' );

// Type of the prev/next post navigation
$verse_posts_navigation   = verse_get_theme_option( 'posts_navigation' );
$verse_prev_post          = false;
$verse_prev_post_same_cat = verse_get_theme_option( 'posts_navigation_scroll_same_cat' );

// Rewrite style of the single post if current post loading via AJAX and featured image and title is not in the content
if ( ( $full_post_loading 
		|| 
		( $prev_post_loading && 'article' == $prev_post_loading_type )
	) 
	&& 
	! in_array( verse_get_theme_option( 'single_style' ), array( 'style-6' ) )
) {
	verse_storage_set_array( 'options_meta', 'single_style', 'style-6' );
}

do_action( 'verse_action_prev_post_loading', $prev_post_loading, $prev_post_loading_type );

get_header();

while ( have_posts() ) {

	the_post();

	// Type of the prev/next post navigation
	if ( 'scroll' == $verse_posts_navigation ) {
		$verse_prev_post = get_previous_post( $verse_prev_post_same_cat );  // Get post from same category
		if ( ! $verse_prev_post && $verse_prev_post_same_cat ) {
			$verse_prev_post = get_previous_post( false );                    // Get post from any category
		}
		if ( ! $verse_prev_post ) {
			$verse_posts_navigation = 'links';
		}
	}

	// Override some theme options to display featured image, title and post meta in the dynamic loaded posts
	if ( $full_post_loading || ( $prev_post_loading && $verse_prev_post ) ) {
		verse_sc_layouts_showed( 'featured', false );
		verse_sc_layouts_showed( 'title', false );
		verse_sc_layouts_showed( 'postmeta', false );
	}

	// If related posts should be inside the content
	if ( strpos( $verse_related_position, 'inside' ) === 0 ) {
		ob_start();
	}

	// Display post's content
	get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/content', 'single-' . verse_get_theme_option( 'single_style' ) ), 'single-' . verse_get_theme_option( 'single_style' ) );

	// If related posts should be inside the content
	if ( strpos( $verse_related_position, 'inside' ) === 0 ) {
		$verse_content = ob_get_contents();
		ob_end_clean();

		ob_start();
		do_action( 'verse_action_related_posts' );
		$verse_related_content = ob_get_contents();
		ob_end_clean();

		if ( ! empty( $verse_related_content ) ) {
			$verse_related_position_inside = max( 0, min( 9, verse_get_theme_option( 'related_position_inside' ) ) );
			if ( 0 == $verse_related_position_inside ) {
				$verse_related_position_inside = mt_rand( 1, 9 );
			}

			$verse_p_number         = 0;
			$verse_related_inserted = false;
			$verse_in_block         = false;
			$verse_content_start    = strpos( $verse_content, '<div class="post_content' );
			$verse_content_end      = strrpos( $verse_content, '</div>' );

			for ( $i = max( 0, $verse_content_start ); $i < min( strlen( $verse_content ) - 3, $verse_content_end ); $i++ ) {
				if ( $verse_content[ $i ] != '<' ) {
					continue;
				}
				if ( $verse_in_block ) {
					if ( strtolower( substr( $verse_content, $i + 1, 12 ) ) == '/blockquote>' ) {
						$verse_in_block = false;
						$i += 12;
					}
					continue;
				} else if ( strtolower( substr( $verse_content, $i + 1, 10 ) ) == 'blockquote' && in_array( $verse_content[ $i + 11 ], array( '>', ' ' ) ) ) {
					$verse_in_block = true;
					$i += 11;
					continue;
				} else if ( 'p' == $verse_content[ $i + 1 ] && in_array( $verse_content[ $i + 2 ], array( '>', ' ' ) ) ) {
					$verse_p_number++;
					if ( $verse_related_position_inside == $verse_p_number ) {
						$verse_related_inserted = true;
						$verse_content = ( $i > 0 ? substr( $verse_content, 0, $i ) : '' )
											. $verse_related_content
											. substr( $verse_content, $i );
					}
				}
			}
			if ( ! $verse_related_inserted ) {
				if ( $verse_content_end > 0 ) {
					$verse_content = substr( $verse_content, 0, $verse_content_end ) . $verse_related_content . substr( $verse_content, $verse_content_end );
				} else {
					$verse_content .= $verse_related_content;
				}
			}
		}

		verse_show_layout( $verse_content );
	}

	// Comments
	do_action( 'verse_action_before_comments' );
	comments_template();
	do_action( 'verse_action_after_comments' );

	// Related posts
	if ( 'below_content' == $verse_related_position
		&& ( 'scroll' != $verse_posts_navigation || verse_get_theme_option( 'posts_navigation_scroll_hide_related' ) == 0 )
		&& ( ! $full_post_loading || verse_get_theme_option( 'open_full_post_hide_related' ) == 0 )
	) {
		do_action( 'verse_action_related_posts' );
	}

	// Post navigation: type 'scroll'
	if ( 'scroll' == $verse_posts_navigation && ! $full_post_loading ) {
		?>
		<div class="nav-links-single-scroll"
			data-post-id="<?php echo esc_attr( get_the_ID( $verse_prev_post ) ); ?>"
			data-post-link="<?php echo esc_attr( get_permalink( $verse_prev_post ) ); ?>"
			data-post-title="<?php the_title_attribute( array( 'post' => $verse_prev_post ) ); ?>"
			<?php do_action( 'verse_action_nav_links_single_scroll_data', $verse_prev_post ); ?>
		></div>
		<?php
	}
}

get_footer();
