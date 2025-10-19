<?php
/**
 * The template to display Admin notices
 *
 * @package VERSE
 * @since VERSE 1.0.64
 */

$verse_skins_url  = get_admin_url( null, 'admin.php?page=trx_addons_theme_panel#trx_addons_theme_panel_section_skins' );
$verse_skins_args = get_query_var( 'verse_skins_notice_args' );
?>
<div class="verse_admin_notice verse_skins_notice notice notice-info is-dismissible" data-notice="skins">
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
		<?php esc_html_e( 'New skins are available', 'verse' ); ?>
	</h3>
	<?php

	// Description
	$verse_total      = $verse_skins_args['update'];	// Store value to the separate variable to avoid warnings from ThemeCheck plugin!
	$verse_skins_msg  = $verse_total > 0
							// Translators: Add new skins number
							? '<strong>' . sprintf( _n( '%d new version', '%d new versions', $verse_total, 'verse' ), $verse_total ) . '</strong>'
							: '';
	$verse_total      = $verse_skins_args['free'];
	$verse_skins_msg .= $verse_total > 0
							? ( ! empty( $verse_skins_msg ) ? ' ' . esc_html__( 'and', 'verse' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d free skin', '%d free skins', $verse_total, 'verse' ), $verse_total ) . '</strong>'
							: '';
	$verse_total      = $verse_skins_args['pay'];
	$verse_skins_msg .= $verse_skins_args['pay'] > 0
							? ( ! empty( $verse_skins_msg ) ? ' ' . esc_html__( 'and', 'verse' ) . ' ' : '' )
								// Translators: Add new skins number
								. '<strong>' . sprintf( _n( '%d paid skin', '%d paid skins', $verse_total, 'verse' ), $verse_total ) . '</strong>'
							: '';
	?>
	<div class="verse_notice_text">
		<p>
			<?php
			// Translators: Add new skins info
			echo wp_kses_data( sprintf( __( "We are pleased to announce that %s are available for your theme", 'verse' ), $verse_skins_msg ) );
			?>
		</p>
	</div>
	<?php

	// Buttons
	?>
	<div class="verse_notice_buttons">
		<?php
		// Link to the theme dashboard page
		?>
		<a href="<?php echo esc_url( $verse_skins_url ); ?>" class="button button-primary"><i class="dashicons dashicons-update"></i> 
			<?php
			// Translators: Add theme name
			esc_html_e( 'Go to Skins manager', 'verse' );
			?>
		</a>
	</div>
</div>
