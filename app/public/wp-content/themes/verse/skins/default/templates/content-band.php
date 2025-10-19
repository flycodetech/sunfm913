<?php
/**
 * 'Band' template to display the content
 *
 * Used for index/archive/search.
 *
 * @package VERSE
 * @since VERSE 1.71.0
 */

$verse_template_args = get_query_var( 'verse_template_args' );
if ( ! is_array( $verse_template_args ) ) {
	$verse_template_args = array(
								'type'    => 'band',
								'columns' => 1
								);
}

$verse_columns       = 1;

$verse_expanded      = ! verse_sidebar_present() && verse_get_theme_option( 'expand_content' ) == 'expand';

$verse_post_format   = get_post_format();
$verse_post_format   = empty( $verse_post_format ) ? 'standard' : str_replace( 'post-format-', '', $verse_post_format );

if ( is_array( $verse_template_args ) ) {
	$verse_columns    = empty( $verse_template_args['columns'] ) ? 1 : max( 1, $verse_template_args['columns'] );
	$verse_blog_style = array( $verse_template_args['type'], $verse_columns );
	if ( ! empty( $verse_template_args['slider'] ) ) {
		?><div class="slider-slide swiper-slide">
		<?php
	} elseif ( $verse_columns > 1 ) {
	    $verse_columns_class = verse_get_column_class( 1, $verse_columns, ! empty( $verse_template_args['columns_tablet']) ? $verse_template_args['columns_tablet'] : '', ! empty($verse_template_args['columns_mobile']) ? $verse_template_args['columns_mobile'] : '' );
				?><div class="<?php echo esc_attr( $verse_columns_class ); ?>"><?php
	}
}
?>
<article id="post-<?php the_ID(); ?>" data-post-id="<?php the_ID(); ?>"
	<?php
	post_class( 'post_item post_item_container post_layout_band post_format_' . esc_attr( $verse_post_format ) );
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
			'thumb_bg'   => true,
			'thumb_ratio'   => '1:1',
			'thumb_size' => ! empty( $verse_template_args['thumb_size'] )
								? $verse_template_args['thumb_size']
								: verse_get_thumb_size( 
								in_array( $verse_post_format, array( 'gallery', 'audio', 'video' ) )
									? ( strpos( verse_get_theme_option( 'body_style' ), 'full' ) !== false
										? 'full'
										: ( $verse_expanded 
											? 'big' 
											: 'medium-square'
											)
										)
									: 'masonry-big'
								)
		),
		'content-band',
		$verse_template_args
	) );

	?><div class="post_content_wrap"><?php

		// Title and post meta
		$verse_show_title = get_the_title() != '';
		$verse_show_meta  = count( $verse_components ) > 0 && ! in_array( $verse_hover, array( 'border', 'pull', 'slide', 'fade', 'info' ) );
		if ( $verse_show_title ) {
			?>
			<div class="post_header entry-header">
				<?php
				// Categories
				if ( apply_filters( 'verse_filter_show_blog_categories', $verse_show_meta && in_array( 'categories', $verse_components ), array( 'categories' ), 'band' ) ) {
					do_action( 'verse_action_before_post_category' );
					?>
					<div class="post_category">
						<?php
						verse_show_post_meta( apply_filters(
															'verse_filter_post_meta_args',
															array(
																'components' => 'categories',
																'seo'        => false,
																'echo'       => true,
																'cat_sep'    => false,
																),
															'hover_' . $verse_hover, 1
															)
											);
						?>
					</div>
					<?php
					$verse_components = verse_array_delete_by_value( $verse_components, 'categories' );
					do_action( 'verse_action_after_post_category' );
				}
				// Post title
				if ( apply_filters( 'verse_filter_show_blog_title', true, 'band' ) ) {
					do_action( 'verse_action_before_post_title' );
					if ( empty( $verse_template_args['no_links'] ) ) {
						the_title( sprintf( '<h4 class="post_title entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h4>' );
					} else {
						the_title( '<h4 class="post_title entry-title">', '</h4>' );
					}
					do_action( 'verse_action_after_post_title' );
				}
				?>
			</div><!-- .post_header -->
			<?php
		}

		// Post content
		if ( ! isset( $verse_template_args['excerpt_length'] ) && ! in_array( $verse_post_format, array( 'gallery', 'audio', 'video' ) ) ) {
			$verse_template_args['excerpt_length'] = 13;
		}
		if ( apply_filters( 'verse_filter_show_blog_excerpt', empty( $verse_template_args['hide_excerpt'] ) && verse_get_theme_option( 'excerpt_length' ) > 0, 'band' ) ) {
			?>
			<div class="post_content entry-content">
				<?php
				// Post content area
				verse_show_post_content( $verse_template_args, '<div class="post_content_inner">', '</div>' );
				?>
			</div><!-- .entry-content -->
			<?php
		}
		// Post meta
		if ( apply_filters( 'verse_filter_show_blog_meta', $verse_show_meta, $verse_components, 'band' ) ) {
			if ( count( $verse_components ) > 0 ) {
				do_action( 'verse_action_before_post_meta' );
				verse_show_post_meta(
					apply_filters(
						'verse_filter_post_meta_args', array(
							'components' => join( ',', $verse_components ),
							'seo'        => false,
							'echo'       => true,
						), 'band', 1
					)
				);
				do_action( 'verse_action_after_post_meta' );
			}
		}
		// More button
		if ( apply_filters( 'verse_filter_show_blog_readmore', ! $verse_show_title || ! empty( $verse_template_args['more_button'] ), 'band' ) ) {
			if ( empty( $verse_template_args['no_links'] ) ) {
				do_action( 'verse_action_before_post_readmore' );
				verse_show_post_more_link( $verse_template_args, '<div class="more-wrap">', '</div>' );
				do_action( 'verse_action_after_post_readmore' );
			}
		}
		?>
	</div>
</article>
<?php

if ( is_array( $verse_template_args ) ) {
	if ( ! empty( $verse_template_args['slider'] ) || $verse_columns > 1 ) {
		?>
		</div>
		<?php
	}
}
