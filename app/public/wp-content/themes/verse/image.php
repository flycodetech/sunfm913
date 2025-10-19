<?php
/**
 * The template to display the attachment
 *
 * @package VERSE
 * @since VERSE 1.0
 */


get_header();

while ( have_posts() ) {
	the_post();

	// Display post's content
	get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/content', 'single-' . verse_get_theme_option( 'single_style' ) ), 'single-' . verse_get_theme_option( 'single_style' ) );

	// Parent post navigation.
	$verse_posts_navigation = verse_get_theme_option( 'posts_navigation' );
	if ( 'links' == $verse_posts_navigation ) {
		?>
		<div class="nav-links-single<?php
			if ( ! verse_is_off( verse_get_theme_option( 'posts_navigation_fixed' ) ) ) {
				echo ' nav-links-fixed fixed';
			}
		?>">
			<?php
			the_post_navigation( apply_filters( 'verse_filter_post_navigation_args', array(
					'prev_text' => '<span class="nav-arrow"></span>'
						. '<span class="meta-nav" aria-hidden="true">' . esc_html__( 'Published in', 'verse' ) . '</span> '
						. '<span class="screen-reader-text">' . esc_html__( 'Previous post:', 'verse' ) . '</span> '
						. '<h5 class="post-title">%title</h5>'
						. '<span class="post_date">%date</span>',
			), 'image' ) );
			?>
		</div>
		<?php
	}

	// Comments
	do_action( 'verse_action_before_comments' );
	comments_template();
	do_action( 'verse_action_after_comments' );
}

get_footer();
