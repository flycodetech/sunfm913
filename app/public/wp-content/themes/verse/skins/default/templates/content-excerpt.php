<?php
/**
 * The default template to display the content
 *
 * Used for index/archive/search.
 *
 * @package VERSE
 * @since VERSE 1.0
 */

$verse_template_args = get_query_var( 'verse_template_args' );
$verse_columns = 1;
if ( is_array( $verse_template_args ) ) {
	$verse_columns    = empty( $verse_template_args['columns'] ) ? 1 : max( 1, $verse_template_args['columns'] );
	$verse_blog_style = array( $verse_template_args['type'], $verse_columns );
	if ( ! empty( $verse_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $verse_columns > 1 ) {
	    $verse_columns_class = verse_get_column_class( 1, $verse_columns, ! empty( $verse_template_args['columns_tablet']) ? $verse_template_args['columns_tablet'] : '', ! empty($verse_template_args['columns_mobile']) ? $verse_template_args['columns_mobile'] : '' );
		?>
		<div class="<?php echo esc_attr( $verse_columns_class ); ?>">
		<?php
	}
} else {
	$verse_template_args = array();
}
$verse_expanded    = ! verse_sidebar_present() && verse_get_theme_option( 'expand_content' ) == 'expand';
$verse_post_format = get_post_format();
$verse_post_format = empty( $verse_post_format ) ? 'standard' : str_replace( 'post-format-', '', $verse_post_format );
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_excerpt post_format_' . esc_attr( $verse_post_format ) );
	verse_add_blog_animation( $verse_template_args );
	?>
>
	<?php

	// Sticky label
	if ( is_sticky() && ! is_paged() ) {
		?>
		<span class="post_label label_sticky"></span>
		<?php
	}

	// Featured image
	$verse_hover      = ! empty( $verse_template_args['hover'] ) && ! verse_is_inherit( $verse_template_args['hover'] )
							? $verse_template_args['hover']
							: verse_get_theme_option( 'image_hover' );
	$verse_components = ! empty( $verse_template_args['meta_parts'] )
							? ( is_array( $verse_template_args['meta_parts'] )
								? $verse_template_args['meta_parts']
								: array_map( 'trim', explode( ',', $verse_template_args['meta_parts'] ) )
								)
							: verse_array_get_keys_by_value( verse_get_theme_option( 'meta_parts' ) );
	verse_show_post_featured( apply_filters( 'verse_filter_args_featured',
		array(
			'no_links'   => ! empty( $verse_template_args['no_links'] ),
			'hover'      => $verse_hover,
			'meta_parts' => $verse_components,
			'thumb_size' => ! empty( $verse_template_args['thumb_size'] )
							? $verse_template_args['thumb_size']
							: verse_get_thumb_size( strpos( verse_get_theme_option( 'body_style' ), 'full' ) !== false
								? 'full'
								: ( $verse_expanded 
									? 'huge' 
									: 'big' 
									)
								),
		),
		'content-excerpt',
		$verse_template_args
	) );

	// Title and post meta
	$verse_show_title = get_the_title() != '';
	$verse_show_meta  = count( $verse_components ) > 0 && ! in_array( $verse_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $verse_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php
			// Post title
			if ( apply_filters( 'verse_filter_show_blog_title', true, 'excerpt' ) ) {
				do_action( 'verse_action_before_post_title' );
				if ( empty( $verse_template_args['no_links'] ) ) {
					the_title( sprintf( '<h3 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h3>' );
				} else {
					the_title( '<h3 class="post_title entry-title">', '</h3>' );
				}
				do_action( 'verse_action_after_post_title' );
			}
			?>
		</div><!-- .post_header -->
		<?php
	}

	// Post content
	if ( apply_filters( 'verse_filter_show_blog_excerpt', empty( $verse_template_args['hide_excerpt'] ) && verse_get_theme_option( 'excerpt_length' ) > 0, 'excerpt' ) ) {
		?>
		<div class="post_content entry-content">
			<?php

			// Post meta
			if ( apply_filters( 'verse_filter_show_blog_meta', $verse_show_meta, $verse_components, 'excerpt' ) ) {
				if ( count( $verse_components ) > 0 ) {
					do_action( 'verse_action_before_post_meta' );
					verse_show_post_meta(
						apply_filters(
							'verse_filter_post_meta_args', array(
								'components' => join( ',', $verse_components ),
								'seo'        => false,
								'echo'       => true,
							), 'excerpt', 1
						)
					);
					do_action( 'verse_action_after_post_meta' );
				}
			}

			if ( verse_get_theme_option( 'blog_content' ) == 'fullpost' ) {
				// Post content area
				?>
				<div class="post_content_inner">
					<?php
					do_action( 'verse_action_before_full_post_content' );
					the_content( '' );
					do_action( 'verse_action_after_full_post_content' );
					?>
				</div>
				<?php
				// Inner pages
				wp_link_pages(
					array(
						'before'      => '<div class="page_links"><span class="page_links_title">' . esc_html__( 'Pages:', 'verse' ) . '</span>',
						'after'       => '</div>',
						'link_before' => '<span>',
						'link_after'  => '</span>',
						'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'verse' ) . ' </span>%',
						'separator'   => '<span class="screen-reader-text">, </span>',
					)
				);
			} else {
				// Post content area
				verse_show_post_content( $verse_template_args, '<div class="post_content_inner">', '</div>' );
			}

			// More button
			if ( apply_filters( 'verse_filter_show_blog_readmore',  ! isset( $verse_template_args['more_button'] ) || ! empty( $verse_template_args['more_button'] ), 'excerpt' ) ) {
				if ( empty( $verse_template_args['no_links'] ) ) {
					do_action( 'verse_action_before_post_readmore' );
					if ( verse_get_theme_option( 'blog_content' ) != 'fullpost' ) {
						verse_show_post_more_link( $verse_template_args, '<p>', '</p>' );
					} else {
						verse_show_post_comments_link( $verse_template_args, '<p>', '</p>' );
					}
					do_action( 'verse_action_after_post_readmore' );
				}
			}

			?>
		</div><!-- .entry-content -->
		<?php
	}
	?>
</article>
<?php

if ( is_array( $verse_template_args ) ) {
	if ( ! empty( $verse_template_args['slider'] ) || $verse_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
