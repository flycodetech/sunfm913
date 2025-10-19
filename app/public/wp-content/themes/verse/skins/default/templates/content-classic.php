<?php
/**
 * The Classic template to display the content
 *
 * Used for index/archive/search.
 *
 * @package VERSE
 * @since VERSE 1.0
 */

$verse_template_args = get_query_var( 'verse_template_args' );

if ( is_array( $verse_template_args ) ) {
	$verse_columns    = empty( $verse_template_args['columns'] ) ? 2 : max( 1, $verse_template_args['columns'] );
	$verse_blog_style = array( $verse_template_args['type'], $verse_columns );
    $verse_columns_class = verse_get_column_class( 1, $verse_columns, ! empty( $verse_template_args['columns_tablet']) ? $verse_template_args['columns_tablet'] : '', ! empty($verse_template_args['columns_mobile']) ? $verse_template_args['columns_mobile'] : '' );
} else {
	$verse_template_args = array();
	$verse_blog_style = explode( '_', verse_get_theme_option( 'blog_style' ) );
	$verse_columns    = empty( $verse_blog_style[1] ) ? 2 : max( 1, $verse_blog_style[1] );
    $verse_columns_class = verse_get_column_class( 1, $verse_columns );
}
$verse_expanded   = ! verse_sidebar_present() && verse_get_theme_option( 'expand_content' ) == 'expand';

$verse_post_format = get_post_format();
$verse_post_format = empty( $verse_post_format ) ? 'standard' : str_replace( 'post-format-', '', $verse_post_format );

?><div class="<?php
	if ( ! empty( $verse_template_args['slider'] ) ) {
		echo ' slider-slide swiper-slide';
	} else {
		echo ( verse_is_blog_style_use_masonry( $verse_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $verse_columns ) : esc_attr( $verse_columns_class ) );
	}
?>"><article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $verse_post_format )
				. ' post_layout_classic post_layout_classic_' . esc_attr( $verse_columns )
				. ' post_layout_' . esc_attr( $verse_blog_style[0] )
				. ' post_layout_' . esc_attr( $verse_blog_style[0] ) . '_' . esc_attr( $verse_columns )
	);
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
								: explode( ',', $verse_template_args['meta_parts'] )
								)
							: verse_array_get_keys_by_value( verse_get_theme_option( 'meta_parts' ) );

	verse_show_post_featured( apply_filters( 'verse_filter_args_featured',
		array(
			'thumb_size' => ! empty( $verse_template_args['thumb_size'] )
				? $verse_template_args['thumb_size']
				: verse_get_thumb_size(
				'classic' == $verse_blog_style[0]
						? ( strpos( verse_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $verse_columns > 2 ? 'big' : 'huge' )
								: ( $verse_columns > 2
									? ( $verse_expanded ? 'square' : 'square' )
									: ($verse_columns > 1 ? 'square' : ( $verse_expanded ? 'huge' : 'big' ))
									)
							)
						: ( strpos( verse_get_theme_option( 'body_style' ), 'full' ) !== false
								? ( $verse_columns > 2 ? 'masonry-big' : 'full' )
								: ($verse_columns === 1 ? ( $verse_expanded ? 'huge' : 'big' ) : ( $verse_columns <= 2 && $verse_expanded ? 'masonry-big' : 'masonry' ))
							)
			),
			'hover'      => $verse_hover,
			'meta_parts' => $verse_components,
			'no_links'   => ! empty( $verse_template_args['no_links'] ),
        ),
        'content-classic',
        $verse_template_args
    ) );

	// Title and post meta
	$verse_show_title = get_the_title() != '';
	$verse_show_meta  = count( $verse_components ) > 0 && ! in_array( $verse_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );

	if ( $verse_show_title ) {
		?>
		<div class="post_header entry-header">
			<?php

			// Post meta
			if ( apply_filters( 'verse_filter_show_blog_meta', $verse_show_meta, $verse_components, 'classic' ) ) {
				if ( count( $verse_components ) > 0 ) {
					do_action( 'verse_action_before_post_meta' );
					verse_show_post_meta(
						apply_filters(
							'verse_filter_post_meta_args', array(
							'components' => join( ',', $verse_components ),
							'seo'        => false,
							'echo'       => true,
						), $verse_blog_style[0], $verse_columns
						)
					);
					do_action( 'verse_action_after_post_meta' );
				}
			}

			// Post title
			if ( apply_filters( 'verse_filter_show_blog_title', true, 'classic' ) ) {
				do_action( 'verse_action_before_post_title' );
				if ( empty( $verse_template_args['no_links'] ) ) {
					the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
				} else {
					the_title( '<h4 class="post_title entry-title">', '</h4>' );
				}
				do_action( 'verse_action_after_post_title' );
			}

			if( !in_array( $verse_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
				// More button
				if ( apply_filters( 'verse_filter_show_blog_readmore', ! $verse_show_title || ! empty( $verse_template_args['more_button'] ), 'classic' ) ) {
					if ( empty( $verse_template_args['no_links'] ) ) {
						do_action( 'verse_action_before_post_readmore' );
						verse_show_post_more_link( $verse_template_args, '<div class="more-wrap">', '</div>' );
						do_action( 'verse_action_after_post_readmore' );
					}
				}
			}
			?>
		</div><!-- .entry-header -->
		<?php
	}

	// Post content
	if( in_array( $verse_post_format, array( 'quote', 'aside', 'link', 'status' ) ) ) {
		ob_start();
		if (apply_filters('verse_filter_show_blog_excerpt', empty($verse_template_args['hide_excerpt']) && verse_get_theme_option('excerpt_length') > 0, 'classic')) {
			verse_show_post_content($verse_template_args, '<div class="post_content_inner">', '</div>');
		}
		// More button
		if(! empty( $verse_template_args['more_button'] )) {
			if ( empty( $verse_template_args['no_links'] ) ) {
				do_action( 'verse_action_before_post_readmore' );
				verse_show_post_more_link( $verse_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'verse_action_after_post_readmore' );
			}
		}
		$verse_content = ob_get_contents();
		ob_end_clean();
		verse_show_layout($verse_content, '<div class="post_content entry-content">', '</div><!-- .entry-content -->');
	}
	?>

</article></div><?php
// Need opening PHP-tag above, because <div> is a inline-block element (used as column)!
