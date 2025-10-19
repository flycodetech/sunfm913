<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: //codex.wordpress.org/Template_Hierarchy
 *
 * @package VERSE
 * @since VERSE 1.0
 */

$verse_template = apply_filters( 'verse_filter_get_template_part', verse_blog_archive_get_template() );

if ( ! empty( $verse_template ) && 'index' != $verse_template ) {

	get_template_part( $verse_template );

} else {

	verse_storage_set( 'blog_archive', true );

	get_header();

	if ( have_posts() ) {

		// Query params
		$verse_stickies   = is_home()
								|| ( in_array( verse_get_theme_option( 'post_type' ), array( '', 'post' ) )
									&& (int) verse_get_theme_option( 'parent_cat' ) == 0
									)
										? get_option( 'sticky_posts' )
										: false;
		$verse_post_type  = verse_get_theme_option( 'post_type' );
		$verse_args       = array(
								'blog_style'     => verse_get_theme_option( 'blog_style' ),
								'post_type'      => $verse_post_type,
								'taxonomy'       => verse_get_post_type_taxonomy( $verse_post_type ),
								'parent_cat'     => verse_get_theme_option( 'parent_cat' ),
								'posts_per_page' => verse_get_theme_option( 'posts_per_page' ),
								'sticky'         => verse_get_theme_option( 'sticky_style' ) == 'columns'
															&& is_array( $verse_stickies )
															&& count( $verse_stickies ) > 0
															&& get_query_var( 'paged' ) < 1
								);

		verse_blog_archive_start();

		do_action( 'verse_action_blog_archive_start' );

		if ( is_author() ) {
			do_action( 'verse_action_before_page_author' );
			get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/author-page' ) );
			do_action( 'verse_action_after_page_author' );
		}

		if ( verse_get_theme_option( 'show_filters' ) ) {
			do_action( 'verse_action_before_page_filters' );
			verse_show_filters( $verse_args );
			do_action( 'verse_action_after_page_filters' );
		} else {
			do_action( 'verse_action_before_page_posts' );
			verse_show_posts( array_merge( $verse_args, array( 'cat' => $verse_args['parent_cat'] ) ) );
			do_action( 'verse_action_after_page_posts' );
		}

		do_action( 'verse_action_blog_archive_end' );

		verse_blog_archive_end();

	} else {

		if ( is_search() ) {
			get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/content', 'none-search' ), 'none-search' );
		} else {
			get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/content', 'none-archive' ), 'none-archive' );
		}
	}

	get_footer();
}
