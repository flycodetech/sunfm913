<?php
/**
 * The Portfolio template to display the content
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

$verse_post_format = get_post_format();
$verse_post_format = empty( $verse_post_format ) ? 'standard' : str_replace( 'post-format-', '', $verse_post_format );

?><div class="
<?php
if ( ! empty( $verse_template_args['slider'] ) ) {
	echo ' slider-slide swiper-slide';
} else {
	echo ( verse_is_blog_style_use_masonry( $verse_blog_style[0] ) ? 'masonry_item masonry_item-1_' . esc_attr( $verse_columns ) : esc_attr( $verse_columns_class ));
}
?>
"><article id="post-<?php the_ID(); ?>" 
	<?php
	post_class(
		'post_item post_item_container post_format_' . esc_attr( $verse_post_format )
		. ' post_layout_portfolio'
		. ' post_layout_portfolio_' . esc_attr( $verse_columns )
		. ( 'portfolio' != $verse_blog_style[0] ? ' ' . esc_attr( $verse_blog_style[0] )  . '_' . esc_attr( $verse_columns ) : '' )
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

	$verse_hover   = ! empty( $verse_template_args['hover'] ) && ! verse_is_inherit( $verse_template_args['hover'] )
								? $verse_template_args['hover']
								: verse_get_theme_option( 'image_hover' );

	if ( 'dots' == $verse_hover ) {
		$verse_post_link = empty( $verse_template_args['no_links'] )
								? ( ! empty( $verse_template_args['link'] )
									? $verse_template_args['link']
									: get_permalink()
									)
								: '';
		$verse_target    = ! empty( $verse_post_link ) && false === strpos( $verse_post_link, home_url() )
								? ' target="_blank" rel="nofollow"'
								: '';
	}
	
	// Meta parts
	$verse_components = ! empty( $verse_template_args['meta_parts'] )
							? ( is_array( $verse_template_args['meta_parts'] )
								? $verse_template_args['meta_parts']
								: explode( ',', $verse_template_args['meta_parts'] )
								)
							: verse_array_get_keys_by_value( verse_get_theme_option( 'meta_parts' ) );

	// Featured image
	verse_show_post_featured( apply_filters( 'verse_filter_args_featured',
        array(
			'hover'         => $verse_hover,
			'no_links'      => ! empty( $verse_template_args['no_links'] ),
			'thumb_size'    => ! empty( $verse_template_args['thumb_size'] )
								? $verse_template_args['thumb_size']
								: verse_get_thumb_size(
									verse_is_blog_style_use_masonry( $verse_blog_style[0] )
										? (	strpos( verse_get_theme_option( 'body_style' ), 'full' ) !== false || $verse_columns < 3
											? 'masonry-big'
											: 'masonry'
											)
										: (	strpos( verse_get_theme_option( 'body_style' ), 'full' ) !== false || $verse_columns < 3
											? 'square'
											: 'square'
											)
								),
			'thumb_bg' => verse_is_blog_style_use_masonry( $verse_blog_style[0] ) ? false : true,
			'show_no_image' => true,
			'meta_parts'    => $verse_components,
			'class'         => 'dots' == $verse_hover ? 'hover_with_info' : '',
			'post_info'     => 'dots' == $verse_hover
										? '<div class="post_info"><h5 class="post_title">'
											. ( ! empty( $verse_post_link )
												? '<a href="' . esc_url( $verse_post_link ) . '"' . ( ! empty( $target ) ? $target : '' ) . '>'
												: ''
												)
												. esc_html( get_the_title() ) 
											. ( ! empty( $verse_post_link )
												? '</a>'
												: ''
												)
											. '</h5></div>'
										: '',
            'thumb_ratio'   => 'info' == $verse_hover ?  '100:102' : '',
        ),
        'content-portfolio',
        $verse_template_args
    ) );
	?>
</article></div><?php
// Need opening PHP-tag above, because <article> is a inline-block element (used as column)!