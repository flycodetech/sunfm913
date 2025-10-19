<?php
/**
 * Required plugins
 *
 * @package VERSE
 * @since VERSE 1.76.0
 */

// THEME-SUPPORTED PLUGINS
// If plugin not need - remove its settings from next array
//----------------------------------------------------------
$verse_theme_required_plugins_groups = array(
	'core'          => esc_html__( 'Core', 'verse' ),
	'page_builders' => esc_html__( 'Page Builders', 'verse' ),
	'ecommerce'     => esc_html__( 'E-Commerce & Donations', 'verse' ),
	'socials'       => esc_html__( 'Socials and Communities', 'verse' ),
	'events'        => esc_html__( 'Events and Appointments', 'verse' ),
	'content'       => esc_html__( 'Content', 'verse' ),
	'other'         => esc_html__( 'Other', 'verse' ),
);
$verse_theme_required_plugins        = array(
	'trx_addons'                 => array(
		'title'       => esc_html__( 'ThemeREX Addons', 'verse' ),
		'description' => esc_html__( "Will allow you to install recommended plugins, demo content, and improve the theme's functionality overall with multiple theme options", 'verse' ),
		'required'    => true,
		'logo'        => 'trx_addons.png',
		'group'       => $verse_theme_required_plugins_groups['core'],
	),
	'elementor'                  => array(
		'title'       => esc_html__( 'Elementor', 'verse' ),
		'description' => esc_html__( "Is a beautiful PageBuilder, even the free version of which allows you to create great pages using a variety of modules.", 'verse' ),
		'required'    => false,
		'logo'        => 'elementor.png',
		'group'       => $verse_theme_required_plugins_groups['page_builders'],
	),
	'gutenberg'                  => array(
		'title'       => esc_html__( 'Gutenberg', 'verse' ),
		'description' => esc_html__( "It's a posts editor coming in place of the classic TinyMCE. Can be installed and used in parallel with Elementor", 'verse' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'gutenberg.png',
		'group'       => $verse_theme_required_plugins_groups['page_builders'],
	),
	'js_composer'                => array(
		'title'       => esc_html__( 'WPBakery PageBuilder', 'verse' ),
		'description' => esc_html__( "Popular PageBuilder which allows you to create excellent pages", 'verse' ),
		'required'    => false,
		'install'     => false,          // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'js_composer.jpg',
		'group'       => $verse_theme_required_plugins_groups['page_builders'],
	),
	'woocommerce'                => array(
		'title'       => esc_html__( 'WooCommerce', 'verse' ),
		'description' => esc_html__( "Connect the store to your website and start selling now", 'verse' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'woocommerce.png',
		'group'       => $verse_theme_required_plugins_groups['ecommerce'],
	),
	'elegro-payment'             => array(
		'title'       => esc_html__( 'Elegro Crypto Payment', 'verse' ),
		'description' => esc_html__( "Extends WooCommerce Payment Gateways with an elegro Crypto Payment", 'verse' ),
		'required'    => false,
		'install'     => false,
		'logo'        => 'elegro-payment.png',
		'group'       => $verse_theme_required_plugins_groups['ecommerce'],
	),
	'instagram-feed'             => array(
		'title'       => esc_html__( 'Instagram Feed', 'verse' ),
		'description' => esc_html__( "Displays the latest photos from your profile on Instagram", 'verse' ),
		'required'    => false,
        'logo'        => 'instagram-feed.png',
		'group'       => $verse_theme_required_plugins_groups['socials'],
	),
	'mailchimp-for-wp'           => array(
		'title'       => esc_html__( 'MailChimp for WP', 'verse' ),
		'description' => esc_html__( "Allows visitors to subscribe to newsletters", 'verse' ),
		'required'    => false,
		'logo'        => 'mailchimp-for-wp.png',
		'group'       => $verse_theme_required_plugins_groups['socials'],
	),
	'booked'                     => array(
		'title'       => esc_html__( 'Booked Appointments', 'verse' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'booked.png',
		'group'       => $verse_theme_required_plugins_groups['events'],
	),
	'quickcal'                     => array(
		'title'       => esc_html__( 'QuickCal', 'verse' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'quickcal.png',
		'group'       => $verse_theme_required_plugins_groups['events'],
	),
	'the-events-calendar'        => array(
		'title'       => esc_html__( 'The Events Calendar', 'verse' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'the-events-calendar.png',
		'group'       => $verse_theme_required_plugins_groups['events'],
	),
	'contact-form-7'             => array(
		'title'       => esc_html__( 'Contact Form 7', 'verse' ),
		'description' => esc_html__( "CF7 allows you to create an unlimited number of contact forms", 'verse' ),
		'required'    => false,
		'logo'        => 'contact-form-7.png',
		'group'       => $verse_theme_required_plugins_groups['content'],
	),

	'latepoint'                  => array(
		'title'       => esc_html__( 'LatePoint', 'verse' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => verse_get_file_url( 'plugins/latepoint/latepoint.png' ),
		'group'       => $verse_theme_required_plugins_groups['events'],
	),
	'advanced-popups'                  => array(
		'title'       => esc_html__( 'Advanced Popups', 'verse' ),
		'description' => '',
		'required'    => false,
        	'logo'        => verse_get_file_url( 'plugins/advanced-popups/advanced-popups.jpg' ),
		'group'       => $verse_theme_required_plugins_groups['content'],
	),
	'devvn-image-hotspot'                  => array(
		'title'       => esc_html__( 'Image Hotspot by DevVN', 'verse' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => verse_get_file_url( 'plugins/devvn-image-hotspot/devvn-image-hotspot.png' ),
		'group'       => $verse_theme_required_plugins_groups['content'],
	),
	'ti-woocommerce-wishlist'                  => array(
		'title'       => esc_html__( 'TI WooCommerce Wishlist', 'verse' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => verse_get_file_url( 'plugins/ti-woocommerce-wishlist/ti-woocommerce-wishlist.png' ),
		'group'       => $verse_theme_required_plugins_groups['ecommerce'],
	),
	'woo-smart-quick-view'                  => array(
		'title'       => esc_html__( 'WPC Smart Quick View for WooCommerce', 'verse' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => verse_get_file_url( 'plugins/woo-smart-quick-view/woo-smart-quick-view.png' ),
		'group'       => $verse_theme_required_plugins_groups['ecommerce'],
	),
	'twenty20'                  => array(
		'title'       => esc_html__( 'Twenty20 Image Before-After', 'verse' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => verse_get_file_url( 'plugins/twenty20/twenty20.png' ),
		'group'       => $verse_theme_required_plugins_groups['content'],
	),
	'essential-grid'             => array(
		'title'       => esc_html__( 'Essential Grid', 'verse' ),
		'description' => '',
		'required'    => false,
		'install'     => false,
		'logo'        => 'essential-grid.png',
		'group'       => $verse_theme_required_plugins_groups['content'],
	),
	'revslider'                  => array(
		'title'       => esc_html__( 'Revolution Slider', 'verse' ),
		'description' => '',
		'required'    => false,
		'logo'        => 'revslider.png',
		'group'       => $verse_theme_required_plugins_groups['content'],
	),
	'sitepress-multilingual-cms' => array(
		'title'       => esc_html__( 'WPML - Sitepress Multilingual CMS', 'verse' ),
		'description' => esc_html__( "Allows you to make your website multilingual", 'verse' ),
		'required'    => false,
		'install'     => false,      // Do not offer installation of the plugin in the Theme Dashboard and TGMPA
		'logo'        => 'sitepress-multilingual-cms.png',
		'group'       => $verse_theme_required_plugins_groups['content'],
	),
	'wp-gdpr-compliance'         => array(
		'title'       => esc_html__( 'Cookie Information', 'verse' ),
		'description' => esc_html__( "Allow visitors to decide for themselves what personal data they want to store on your site", 'verse' ),
		'required'    => false,
		'logo'        => 'wp-gdpr-compliance.png',
		'group'       => $verse_theme_required_plugins_groups['other'],
	),
	'trx_updater'                => array(
		'title'       => esc_html__( 'ThemeREX Updater', 'verse' ),
		'description' => esc_html__( "Update theme and theme-specific plugins from developer's upgrade server.", 'verse' ),
		'required'    => false,
		'logo'        => 'trx_updater.png',
		'group'       => $verse_theme_required_plugins_groups['other'],
	),
);

if ( VERSE_THEME_FREE ) {
	unset( $verse_theme_required_plugins['js_composer'] );
	unset( $verse_theme_required_plugins['booked'] );
	unset( $verse_theme_required_plugins['quickcal'] );
	unset( $verse_theme_required_plugins['the-events-calendar'] );
	unset( $verse_theme_required_plugins['calculated-fields-form'] );
	unset( $verse_theme_required_plugins['essential-grid'] );
	unset( $verse_theme_required_plugins['revslider'] );
	unset( $verse_theme_required_plugins['sitepress-multilingual-cms'] );
	unset( $verse_theme_required_plugins['trx_updater'] );
	unset( $verse_theme_required_plugins['trx_popup'] );
}

// Add plugins list to the global storage
verse_storage_set( 'required_plugins', $verse_theme_required_plugins );
