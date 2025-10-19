<?php
/* Elegro Crypto Payment support functions
------------------------------------------------------------------------------- */

// Theme init priorities:
// 9 - register other filters (for installer, etc.)
if ( ! function_exists( 'verse_elegro_payment_theme_setup9' ) ) {
	add_action( 'after_setup_theme', 'verse_elegro_payment_theme_setup9', 9 );
	function verse_elegro_payment_theme_setup9() {
		if ( verse_exists_elegro_payment() ) {
			add_action( 'wp_enqueue_scripts', 'verse_elegro_payment_frontend_scripts', 1100 );
			add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'verse_elegro_payment_frontend_scripts', 10, 1 );
			add_filter( 'verse_filter_merge_styles', 'verse_elegro_payment_merge_styles' );
		}
		if ( is_admin() ) {
			add_filter( 'verse_filter_tgmpa_required_plugins', 'verse_elegro_payment_tgmpa_required_plugins' );
		}
	}
}

// Filter to add in the required plugins list
if ( ! function_exists( 'verse_elegro_payment_tgmpa_required_plugins' ) ) {
	//Handler of the add_filter('verse_filter_tgmpa_required_plugins',	'verse_elegro_payment_tgmpa_required_plugins');
	function verse_elegro_payment_tgmpa_required_plugins( $list = array() ) {
		if ( verse_storage_isset( 'required_plugins', 'woocommerce' ) && verse_storage_isset( 'required_plugins', 'elegro-payment' ) && verse_storage_get_array( 'required_plugins', 'elegro-payment', 'install' ) !== false ) {
			$list[] = array(
				'name'     => verse_storage_get_array( 'required_plugins', 'elegro-payment', 'title' ),
				'slug'     => 'elegro-payment',
				'required' => false,
			);
		}
		return $list;
	}
}

// Check if this plugin installed and activated
if ( ! function_exists( 'verse_exists_elegro_payment' ) ) {
	function verse_exists_elegro_payment() {
		return class_exists( 'WC_Elegro_Payment' );
	}
}


// Enqueue styles for frontend
if ( ! function_exists( 'verse_elegro_payment_frontend_scripts' ) ) {
	//Handler of the add_action( 'wp_enqueue_scripts', 'verse_elegro_payment_frontend_scripts', 1100 );
	//Handler of the add_action( 'trx_addons_action_load_scripts_front_elegro_payment', 'verse_elegro_payment_frontend_scripts', 10, 1 );
	function verse_elegro_payment_frontend_scripts( $force = false ) {
		verse_enqueue_optimized( 'elegro_payment', $force, array(
			'css' => array(
				'verse-elegro-payment' => array( 'src' => 'plugins/elegro-payment/elegro-payment.css' ),
			)
		) );
	}
}

// Merge custom styles
if ( ! function_exists( 'verse_elegro_payment_merge_styles' ) ) {
	//Handler of the add_filter('verse_filter_merge_styles', 'verse_elegro_payment_merge_styles');
	function verse_elegro_payment_merge_styles( $list ) {
		$list[ 'plugins/elegro-payment/elegro-payment.css' ] = false;
		return $list;
	}
}
