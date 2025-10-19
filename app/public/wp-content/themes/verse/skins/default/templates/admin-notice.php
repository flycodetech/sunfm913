<?php
/**
 * The template to display Admin notices
 *
 * @package VERSE
 * @since VERSE 1.0.1
 */

$verse_theme_slug = get_option( 'template' );
$verse_theme_obj  = wp_get_theme( $verse_theme_slug );
?>
<div class="verse_admin_notice verse_welcome_notice notice notice-info is-dismissible" data-notice="admin">
	<?php
	// Theme image
	$verse_theme_img = verse_get_file_url( 'screenshot.jpg' );
	if ( '' != $verse_theme_img ) {
		?>
		<div class="verse_notice_image"><img src="<?php echo esc_url( $verse_theme_img ); ?>" alt="<?php esc_attr_e( 'Theme screenshot', 'verse' ); ?>"></div>
		<?php
	}

	// Title
	?>
	<h3 class="verse_notice_title">
		<?php
		echo esc_html(
			sprintf(
				// Translators: Add theme name and version to the 'Welcome' message
				__( 'Welcome to %1$s v.%2$s', 'verse' ),
				$verse_theme_obj->get( 'Name' ) . ( VERSE_THEME_FREE ? ' ' . __( 'Free', 'verse' ) : '' ),
				$verse_theme_obj->get( 'Version' )
			)
		);
		?>
	</h3>
	<?php

	// Description
	?>
	<div class="verse_notice_text">
		<p class="verse_notice_text_description">
			<?php
			echo str_replace( '. ', '.<br>', wp_kses_data( $verse_theme_obj->description ) );
			?>
		</p>
		<p class="verse_notice_text_info">
			<?php
			echo wp_kses_data( __( 'Attention! Plugin "ThemeREX Addons" is required! Please, install and activate it!', 'verse' ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="verse_notice_buttons">
		<?php
		// Link to the page 'About Theme'
		?>
		<a href="<?php echo esc_url( admin_url() . 'themes.php?page=verse_about' ); ?>" class="button button-primary"><i class="dashicons dashicons-nametag"></i> 
			<?php
			echo esc_html__( 'Install plugin "ThemeREX Addons"', 'verse' );
			?>
		</a>
	</div>
</div>
