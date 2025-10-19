<?php
/**
 * Skin Setup
 *
 * @package VERSE
 * @since VERSE 1.76.0
 */


//--------------------------------------------
// SKIN DEFAULTS
//--------------------------------------------

// Return theme's (skin's) default value for the specified parameter
if ( ! function_exists( 'verse_theme_defaults' ) ) {
	function verse_theme_defaults( $name='', $value='' ) {
		$defaults = array(
			'page_width'          => 1290,
			'page_boxed_extra'  => 60,
			'page_fullwide_max' => 1920,
			'page_fullwide_extra' => 60,
			'sidebar_width'       => 410,
			'sidebar_gap'       => 40,
			'grid_gap'          => 30,
			'rad'               => 0
		);
		if ( empty( $name ) ) {
			return $defaults;
		} else {
			if ( $value === '' && isset( $defaults[ $name ] ) ) {
				$value = $defaults[ $name ];
			}
			return $value;
		}
	}
}


// WOOCOMMERCE SETUP
//--------------------------------------------------

// Allow extended layouts for WooCommerce
if ( ! function_exists( 'verse_skin_woocommerce_allow_extensions' ) ) {
	add_filter( 'verse_filter_load_woocommerce_extensions', 'verse_skin_woocommerce_allow_extensions' );
	function verse_skin_woocommerce_allow_extensions( $allow ) {
		return false;
	}
}


// Theme init priorities:
// Action 'after_setup_theme'
// 1 - register filters to add/remove lists items in the Theme Options
// 2 - create Theme Options
// 3 - add/remove Theme Options elements
// 5 - load Theme Options. Attention! After this step you can use only basic options (not overriden)
// 9 - register other filters (for installer, etc.)
//10 - standard Theme init procedures (not ordered)
// Action 'wp_loaded'
// 1 - detect override mode. Attention! Only after this step you can use overriden options (separate values for the shop, courses, etc.)


//--------------------------------------------
// SKIN SETTINGS
//--------------------------------------------
if ( ! function_exists( 'verse_skin_setup' ) ) {
	add_action( 'after_setup_theme', 'verse_skin_setup', 1 );
	function verse_skin_setup() {

		$GLOBALS['VERSE_STORAGE'] = array_merge( $GLOBALS['VERSE_STORAGE'], array(

			// Key validator: market[env|loc]-vendor[axiom|ancora|themerex]
			'theme_pro_key'       => 'env-themerex',

			'theme_doc_url'       => '//verse.themerex.net/doc',

			'theme_demofiles_url' => '//demofiles.themerex.net/verse/',
			
			'theme_rate_url'      => '//themeforest.net/download',

			'theme_custom_url'    => '//themerex.net/offers/?utm_source=offers&utm_medium=click&utm_campaign=themeinstall',

			'theme_support_url'   => '//themerex.net/support/',

			'theme_download_url'  => '//1.envato.market/1reKZx',        						// themerex

			'theme_video_url'     => '//www.youtube.com/channel/UCdIjRh7-lPVHqTTKpaf8PLA',   	// themerex

			'theme_privacy_url'   => '//themerex.net/privacy-policy/',                   		// themerex

			'portfolio_url'       => '//themeforest.net/user/ancorathemes/portfolio',        	// themerex

			// Comma separated slugs of theme-specific categories (for get relevant news in the dashboard widget)
			// (i.e. 'children,kindergarten')
			'theme_categories'    => '',
		) );
	}
}


// Add/remove/change Theme Settings
if ( ! function_exists( 'verse_skin_setup_settings' ) ) {
	add_action( 'after_setup_theme', 'verse_skin_setup_settings', 1 );
	function verse_skin_setup_settings() {
		// Example: enable (true) / disable (false) thumbs in the prev/next navigation
		verse_storage_set_array( 'settings', 'thumbs_in_navigation', false );
		verse_storage_set_array2( 'required_plugins', 'woocommerce', 'install', true);
		verse_storage_set_array2( 'required_plugins', 'elegro-payment', 'install', true);
		verse_storage_set_array2( 'required_plugins', 'ti-woocommerce-wishlist', 'install', true);
		verse_storage_set_array2( 'required_plugins', 'the-events-calendar', 'install', true);
	}
}



//--------------------------------------------
// SKIN FONTS
//--------------------------------------------
if ( ! function_exists( 'verse_skin_setup_fonts' ) ) {
	add_action( 'after_setup_theme', 'verse_skin_setup_fonts', 1 );
	function verse_skin_setup_fonts() {
		// Fonts to load when theme start
		// It can be:
		// - Google fonts (specify name, family and styles)
		// - Adobe fonts (specify name, family and link URL)
		// - uploaded fonts (specify name, family), placed in the folder css/font-face/font-name inside the skin folder
		// Attention! Font's folder must have name equal to the font's name, with spaces replaced on the dash '-'
		// example: font name 'TeX Gyre Termes', folder 'TeX-Gyre-Termes'
		verse_storage_set(
			'load_fonts', array(
				// Google font
				array(
					'name'   => 'Poppins',
					'family' => 'sans-serif',
					'link'   => '',
					'styles' => 'ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700',
				),
                array(
                    'name'   => 'Syne',
                    'family' => 'sans-serif',
                    'link'   => '',
                    'styles' => 'wght@400;500;600;700',
                )
			)
		);

		// Characters subset for the Google fonts. Available values are: latin,latin-ext,cyrillic,cyrillic-ext,greek,greek-ext,vietnamese
		verse_storage_set( 'load_fonts_subset', 'latin,latin-ext' );

		// Settings of the main tags.
		// Default value of 'font-family' may be specified as reference to the array $load_fonts (see above)
		// or as comma-separated string.
		// In the second case (if 'font-family' is specified manually as comma-separated string):
		//    1) Font name with spaces in the parameter 'font-family' will be enclosed in the quotes and no spaces after comma!
		//    2) If font-family inherit a value from the 'Main text' - specify 'inherit' as a value
		// example:
		// Correct:   'font-family' => verse_get_load_fonts_family_string( $load_fonts[0] )
		// Correct:   'font-family' => 'Roboto,sans-serif'
		// Correct:   'font-family' => '"PT Serif",sans-serif'
		// Incorrect: 'font-family' => 'Roboto, sans-serif'
		// Incorrect: 'font-family' => 'PT Serif,sans-serif'

		$font_description = esc_html__( 'Font settings for the %s of the site. To ensure that the elements scale properly on mobile devices, please use only the following units: "rem", "em" or "ex"', 'verse' );

		verse_storage_set(
			'theme_fonts', array(
				'p'       => array(
					'title'           => esc_html__( 'Main text', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'main text', 'verse' ) ),
					'font-family'     => 'Poppins,sans-serif',
					'font-size'       => '1rem',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.84em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0em',
					'margin-bottom'   => '1.86em',
				),
				'post'    => array(
					'title'           => esc_html__( 'Article text', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'article text', 'verse' ) ),
					'font-family'     => '',			// Example: '"PR Serif",serif',
					'font-size'       => '',			// Example: '1.286rem',
					'font-weight'     => '',			// Example: '400',
					'font-style'      => '',			// Example: 'normal',
					'line-height'     => '',			// Example: '1.75em',
					'text-decoration' => '',			// Example: 'none',
					'text-transform'  => '',			// Example: 'none',
					'letter-spacing'  => '',			// Example: '',
					'margin-top'      => '',			// Example: '0em',
					'margin-bottom'   => '',			// Example: '1.4em',
				),
				'h1'      => array(
					'title'           => esc_html__( 'Heading 1', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H1', 'verse' ) ),
					'font-family'     => 'Syne,sans-serif',
					'font-size'       => '3.800em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '-1.7px',
					'margin-top'      => '1.1em',
					'margin-bottom'   => '0.38em',
				),
				'h2'      => array(
					'title'           => esc_html__( 'Heading 2', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H2', 'verse' ) ),
					'font-family'     => 'Syne,sans-serif',
					'font-size'       => '3.133em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.021em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.77em',
					'margin-bottom'   => '0.43em',
				),
				'h3'      => array(
					'title'           => esc_html__( 'Heading 3', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H3', 'verse' ) ),
					'font-family'     => 'Syne,sans-serif',
					'font-size'       => '2.333em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.086em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.15em',
					'margin-bottom'   => '0.6em',
				),
				'h4'      => array(
					'title'           => esc_html__( 'Heading 4', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H4', 'verse' ) ),
					'font-family'     => 'Syne,sans-serif',
					'font-size'       => '1.867em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.214em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.42em',
					'margin-bottom'   => '0.6em',
				),
				'h5'      => array(
					'title'           => esc_html__( 'Heading 5', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H5', 'verse' ) ),
					'font-family'     => 'Syne,sans-serif',
					'font-size'       => '1.600em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.417em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.42em',
					'margin-bottom'   => '0.7em',
				),
				'h6'      => array(
					'title'           => esc_html__( 'Heading 6', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'tag H6', 'verse' ) ),
					'font-family'     => 'Syne,sans-serif',
					'font-size'       => '1.267em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.474em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '1.75em',
					'margin-bottom'   => '0.7em',
				),
				'logo'    => array(
					'title'           => esc_html__( 'Logo text', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'text of the logo', 'verse' ) ),
					'font-family'     => 'Syne,sans-serif',
					'font-size'       => '1.7em',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.25em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'button'  => array(
					'title'           => esc_html__( 'Buttons', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'buttons', 'verse' ) ),
					'font-family'     => 'Syne,sans-serif',
					'font-size'       => '15px',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '21px',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'input'   => array(
					'title'           => esc_html__( 'Input fields', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'input fields, dropdowns and textareas', 'verse' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '14px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',     // Attention! Firefox don't allow line-height less then 1.5em in the select
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0.1px',
				),
				'info'    => array(
					'title'           => esc_html__( 'Post meta', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'post meta (author, categories, publish date, counters, share, etc.)', 'verse' ) ),
					'font-family'     => 'inherit',
					'font-size'       => '13px',  // Old value '13px' don't allow using 'font zoom' in the custom blog items
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
					'margin-top'      => '0.4em',
					'margin-bottom'   => '',
				),
				'menu'    => array(
					'title'           => esc_html__( 'Main menu', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'main menu items', 'verse' ) ),
					'font-family'     => 'Syne,sans-serif',
					'font-size'       => '16px',
					'font-weight'     => '700',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'submenu' => array(
					'title'           => esc_html__( 'Dropdown menu', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'dropdown menu items', 'verse' ) ),
					'font-family'     => 'Poppins,sans-serif',
					'font-size'       => '13px',
					'font-weight'     => '400',
					'font-style'      => 'normal',
					'line-height'     => '1.5em',
					'text-decoration' => 'none',
					'text-transform'  => 'none',
					'letter-spacing'  => '0px',
				),
				'other' => array(
					'title'           => esc_html__( 'Other', 'verse' ),
					'description'     => sprintf( $font_description, esc_html__( 'specific elements', 'verse' ) ),
					'font-family'     => 'Poppins,sans-serif',
				),
			)
		);

		// Font presets
		verse_storage_set(
			'font_presets', array(
				'karla' => array(
								'title'  => esc_html__( 'Karla', 'verse' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Dancing Script',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
													// Google font
													array(
														'name'   => 'Sansita Swashed',
														'family' => 'fantasy',
														'link'   => '',
														'styles' => '300,400,700',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Dancing Script",fantasy',
														'font-size'       => '1.25rem',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
														'font-size'       => '4em',
													),
													'h2'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h3'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h4'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h5'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'h6'      => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'logo'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'button'  => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
													'submenu' => array(
														'font-family'     => '"Sansita Swashed",fantasy',
													),
												),
							),
				'roboto' => array(
								'title'  => esc_html__( 'Roboto', 'verse' ),
								'load_fonts' => array(
													// Google font
													array(
														'name'   => 'Noto Sans JP',
														'family' => 'serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
													// Google font
													array(
														'name'   => 'Merriweather',
														'family' => 'sans-serif',
														'link'   => '',
														'styles' => '300,300italic,400,400italic,700,700italic',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Noto Sans JP",serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Merriweather,sans-serif',
													),
												),
							),
				'garamond' => array(
								'title'  => esc_html__( 'Garamond', 'verse' ),
								'load_fonts' => array(
													// Adobe font
													array(
														'name'   => 'Europe',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
													// Adobe font
													array(
														'name'   => 'Sofia Pro',
														'family' => 'sans-serif',
														'link'   => 'https://use.typekit.net/qmj1tmx.css',
														'styles' => '',
													),
												),
								'theme_fonts' => array(
													'p'       => array(
														'font-family'     => '"Sofia Pro",sans-serif',
													),
													'post'    => array(
														'font-family'     => '',
													),
													'h1'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h2'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h3'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h4'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h5'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'h6'      => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'logo'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'button'  => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'input'   => array(
														'font-family'     => 'inherit',
													),
													'info'    => array(
														'font-family'     => 'inherit',
													),
													'menu'    => array(
														'font-family'     => 'Europe,sans-serif',
													),
													'submenu' => array(
														'font-family'     => 'Europe,sans-serif',
													),
												),
							),
			)
		);
	}
}


//--------------------------------------------
// COLOR SCHEMES
//--------------------------------------------
if ( ! function_exists( 'verse_skin_setup_schemes' ) ) {
	add_action( 'after_setup_theme', 'verse_skin_setup_schemes', 1 );
	function verse_skin_setup_schemes() {

		// Theme colors for customizer
		// Attention! Inner scheme must be last in the array below
		verse_storage_set(
			'scheme_color_groups', array(
				'main'    => array(
					'title'       => esc_html__( 'Main', 'verse' ),
					'description' => esc_html__( 'Colors of the main content area', 'verse' ),
				),
				'alter'   => array(
					'title'       => esc_html__( 'Alter', 'verse' ),
					'description' => esc_html__( 'Colors of the alternative blocks (sidebars, etc.)', 'verse' ),
				),
				'extra'   => array(
					'title'       => esc_html__( 'Extra', 'verse' ),
					'description' => esc_html__( 'Colors of the extra blocks (dropdowns, price blocks, table headers, etc.)', 'verse' ),
				),
				'inverse' => array(
					'title'       => esc_html__( 'Inverse', 'verse' ),
					'description' => esc_html__( 'Colors of the inverse blocks - when link color used as background of the block (dropdowns, blockquotes, etc.)', 'verse' ),
				),
				'input'   => array(
					'title'       => esc_html__( 'Input', 'verse' ),
					'description' => esc_html__( 'Colors of the form fields (text field, textarea, select, etc.)', 'verse' ),
				),
			)
		);

		verse_storage_set(
			'scheme_color_names', array(
				'bg_color'    => array(
					'title'       => esc_html__( 'Background color', 'verse' ),
					'description' => esc_html__( 'Background color of this block in the normal state', 'verse' ),
				),
				'bg_hover'    => array(
					'title'       => esc_html__( 'Background hover', 'verse' ),
					'description' => esc_html__( 'Background color of this block in the hovered state', 'verse' ),
				),
				'bd_color'    => array(
					'title'       => esc_html__( 'Border color', 'verse' ),
					'description' => esc_html__( 'Border color of this block in the normal state', 'verse' ),
				),
				'bd_hover'    => array(
					'title'       => esc_html__( 'Border hover', 'verse' ),
					'description' => esc_html__( 'Border color of this block in the hovered state', 'verse' ),
				),
				'text'        => array(
					'title'       => esc_html__( 'Text', 'verse' ),
					'description' => esc_html__( 'Color of the text inside this block', 'verse' ),
				),
				'text_dark'   => array(
					'title'       => esc_html__( 'Text dark', 'verse' ),
					'description' => esc_html__( 'Color of the dark text (bold, header, etc.) inside this block', 'verse' ),
				),
				'text_light'  => array(
					'title'       => esc_html__( 'Text light', 'verse' ),
					'description' => esc_html__( 'Color of the light text (post meta, etc.) inside this block', 'verse' ),
				),
				'text_link'   => array(
					'title'       => esc_html__( 'Link', 'verse' ),
					'description' => esc_html__( 'Color of the links inside this block', 'verse' ),
				),
				'text_hover'  => array(
					'title'       => esc_html__( 'Link hover', 'verse' ),
					'description' => esc_html__( 'Color of the hovered state of links inside this block', 'verse' ),
				),
				'text_link2'  => array(
					'title'       => esc_html__( 'Accent 2', 'verse' ),
					'description' => esc_html__( 'Color of the accented texts (areas) inside this block', 'verse' ),
				),
				'text_hover2' => array(
					'title'       => esc_html__( 'Accent 2 hover', 'verse' ),
					'description' => esc_html__( 'Color of the hovered state of accented texts (areas) inside this block', 'verse' ),
				),
				'text_link3'  => array(
					'title'       => esc_html__( 'Accent 3', 'verse' ),
					'description' => esc_html__( 'Color of the other accented texts (buttons) inside this block', 'verse' ),
				),
				'text_hover3' => array(
					'title'       => esc_html__( 'Accent 3 hover', 'verse' ),
					'description' => esc_html__( 'Color of the hovered state of other accented texts (buttons) inside this block', 'verse' ),
				),
			)
		);

		// Default values for each color scheme
		$schemes = array(

			// Color scheme: 'default'
			'default' => array(
				'title'    => esc_html__( 'Default', 'verse' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F4F5F7',
					'bd_color'         => '#D0D2D9',

					// Text and links colors
					'text'             => '#6A6E71',
					'text_light'       => '#888A8D',
					'text_dark'        => '#000000',
					'text_link'        => '#C8D814',
					'text_hover'       => '#9DB702',
					'text_link2'       => '#B29FE9',
					'text_hover2'      => '#7C63D5',
					'text_link3'       => '#5740F9',
					'text_hover3'      => '#412ADF',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF',
					'alter_bg_hover'   => '#F0F0F0',
					'alter_bd_color'   => '#D0D2D9',
					'alter_bd_hover'   => '#BABBBE',
					'alter_text'       => '#6A6E71',
					'alter_light'      => '#888A8D',
					'alter_dark'       => '#000000',
					'alter_link'       => '#C8D814',
					'alter_hover'      => '#9DB702',
					'alter_link2'      => '#B29FE9',
					'alter_hover2'     => '#7C63D5',
					'alter_link3'      => '#5740F9',
					'alter_hover3'     => '#412ADF',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#2A2A2A',
					'extra_bg_hover'   => '#2C313D',
					'extra_bd_color'   => '#323641',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#888A8D',
					'extra_light'      => '#A5A6AA',
					'extra_dark'       => '#FFFFFF',
					'extra_link'       => '#C8D814',
					'extra_hover'      => '#FFFFFF',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D0D2D9',
					'input_bd_hover'   => '#BABBBE',
					'input_text'       => '#6A6E71',
					'input_light'      => '#888A8D',
					'input_dark'       => '#000000',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#000000',
					'inverse_link'     => '#FFFFFF',
					'inverse_hover'    => '#FFFFFF',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'dark'
			'dark'    => array(
				'title'    => esc_html__( 'Dark', 'verse' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#000000',
					'bd_color'         => '#343434',

					// Text and links colors
					'text'             => '#D2D3D5',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#FFFFFF',
					'text_link'        => '#C8D814',
					'text_hover'       => '#9DB702',
					'text_link2'       => '#B29FE9',
					'text_hover2'      => '#7C63D5',
					'text_link3'       => '#5740F9',
					'text_hover3'      => '#412ADF',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#161616',
					'alter_bg_hover'   => '#404040',
					'alter_bd_color'   => '#343434',
					'alter_bd_hover'   => '#53535C',
					'alter_text'       => '#D2D3D5',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#FFFFFF',
					'alter_link'       => '#C8D814',
					'alter_hover'      => '#9DB702',
					'alter_link2'      => '#B29FE9',
					'alter_hover2'     => '#7C63D5',
					'alter_link3'      => '#5740F9',
					'alter_hover3'     => '#412ADF',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#2A2A2A',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#888A8D',
					'extra_light'      => '#A5A6AA',
					'extra_dark'       => '#FFFFFF',
					'extra_link'       => '#C8D814',
					'extra_hover'      => '#FFFFFF',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent',
					'input_bg_hover'   => '#transparent',
					'input_bd_color'   => '#343434',
					'input_bd_hover'   => '#343434',
					'input_text'       => '#D2D3D5',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#FFFFFF',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9F9F9',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#000000',
					'inverse_link'     => '#FFFFFF',
					'inverse_hover'    => '#000000',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

            // Color scheme: 'light'
            'light' => array(
                'title'    => esc_html__( 'Light', 'verse' ),
                'internal' => true,
                'colors'   => array(

                    // Whole block border and background
                    'bg_color'         => '#FFFFFF',
                    'bd_color'         => '#D0D2D9',

                    // Text and links colors
                    'text'             => '#6A6E71',
                    'text_light'       => '#888A8D',
                    'text_dark'        => '#000000',
                    'text_link'        => '#C8D814',
                    'text_hover'       => '#9DB702',
                    'text_link2'       => '#B29FE9',
                    'text_hover2'      => '#7C63D5',
                    'text_link3'       => '#5740F9',
                    'text_hover3'      => '#412ADF',

                    // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                    'alter_bg_color'   => '#F4F5F7',
                    'alter_bg_hover'   => '#FFFFFF',
                    'alter_bd_color'   => '#D0D2D9',
                    'alter_bd_hover'   => '#BABBBE',
                    'alter_text'       => '#6A6E71',
                    'alter_light'      => '#888A8D',
                    'alter_dark'       => '#000000',
                    'alter_link'       => '#C8D814',
                    'alter_hover'      => '#9DB702',
                    'alter_link2'      => '#B29FE9',
                    'alter_hover2'     => '#7C63D5',
                    'alter_link3'      => '#5740F9',
                    'alter_hover3'     => '#412ADF',

                    // Extra blocks (submenu, tabs, color blocks, etc.)
                    'extra_bg_color'   => '#2A2A2A',
                    'extra_bg_hover'   => '#2C313D',
                    'extra_bd_color'   => '#323641',
                    'extra_bd_hover'   => '#575757',
                    'extra_text'       => '#888A8D',
                    'extra_light'      => '#A5A6AA',
                    'extra_dark'       => '#FFFFFF',
                    'extra_link'       => '#C8D814',
                    'extra_hover'      => '#FFFFFF',
                    'extra_link2'      => '#80d572',
                    'extra_hover2'     => '#8be77c',
                    'extra_link3'      => '#ddb837',
                    'extra_hover3'     => '#eec432',

                    // Input fields (form's fields and textarea)
                    'input_bg_color'   => 'transparent',
                    'input_bg_hover'   => 'transparent',
                    'input_bd_color'   => '#D0D2D9',
                    'input_bd_hover'   => '#BABBBE',
                    'input_text'       => '#6A6E71',
                    'input_light'      => '#888A8D',
                    'input_dark'       => '#000000',

                    // Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bd_color' => '#67bcc1',
                    'inverse_bd_hover' => '#5aa4a9',
                    'inverse_text'     => '#1d1d1d',
                    'inverse_light'    => '#333333',
                    'inverse_dark'     => '#000000',
                    'inverse_link'     => '#FFFFFF',
                    'inverse_hover'    => '#FFFFFF',

                    // Additional (skin-specific) colors.
                    // Attention! Set of colors must be equal in all color schemes.
                    //---> For example:
                    //---> 'new_color1'         => '#rrggbb',
                    //---> 'alter_new_color1'   => '#rrggbb',
                    //---> 'inverse_new_color1' => '#rrggbb',
                ),
            ),

			// Color scheme: 'extra_default'
			'extra_default' => array(
				'title'    => esc_html__( 'Extra Default', 'verse' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#F4F5F7',
					'bd_color'         => '#D0D2D9',

					// Text and links colors
					'text'             => '#6A6E71',
					'text_light'       => '#888A8D',
					'text_dark'        => '#000000',
					'text_link'        => '#C62045',
					'text_hover'       => '#AF1336',
					'text_link2'       => '#D1AD9C',
					'text_hover2'      => '#BF9A89',
					'text_link3'       => '#74BDC9',
					'text_hover3'      => '#55A5B2',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#FFFFFF',
					'alter_bg_hover'   => '#F0F0F0',
					'alter_bd_color'   => '#D0D2D9',
					'alter_bd_hover'   => '#BABBBE',
					'alter_text'       => '#6A6E71',
					'alter_light'      => '#888A8D',
					'alter_dark'       => '#000000',
					'alter_link'       => '#C62045',
					'alter_hover'      => '#AF1336',
					'alter_link2'      => '#D1AD9C',
					'alter_hover2'     => '#BF9A89',
					'alter_link3'      => '#74BDC9',
					'alter_hover3'     => '#55A5B2',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#2A2A2A',
					'extra_bg_hover'   => '#2C313D',
					'extra_bd_color'   => '#323641',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#888A8D',
					'extra_light'      => '#A5A6AA',
					'extra_dark'       => '#FFFFFF',
					'extra_link'       => '#C62045',
					'extra_hover'      => '#FFFFFF',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => 'transparent',
					'input_bg_hover'   => 'transparent',
					'input_bd_color'   => '#D0D2D9',
					'input_bd_hover'   => '#BABBBE',
					'input_text'       => '#6A6E71',
					'input_light'      => '#888A8D',
					'input_dark'       => '#000000',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#67bcc1',
					'inverse_bd_hover' => '#5aa4a9',
					'inverse_text'     => '#1d1d1d',
					'inverse_light'    => '#333333',
					'inverse_dark'     => '#000000',
					'inverse_link'     => '#FFFFFF',
					'inverse_hover'    => '#FFFFFF',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

			// Color scheme: 'extra_dark'
			'extra_dark'    => array(
				'title'    => esc_html__( 'Extra Dark', 'verse' ),
				'internal' => true,
				'colors'   => array(

					// Whole block border and background
					'bg_color'         => '#000000',
					'bd_color'         => '#343434',

					// Text and links colors
					'text'             => '#D2D3D5',
					'text_light'       => '#A5A6AA',
					'text_dark'        => '#FFFFFF',
					'text_link'        => '#C62045',
					'text_hover'       => '#AF1336',
					'text_link2'       => '#D1AD9C',
					'text_hover2'      => '#BF9A89',
					'text_link3'       => '#74BDC9',
					'text_hover3'      => '#55A5B2',

					// Alternative blocks (sidebar, tabs, alternative blocks, etc.)
					'alter_bg_color'   => '#161616',
					'alter_bg_hover'   => '#404040',
					'alter_bd_color'   => '#343434',
					'alter_bd_hover'   => '#53535C',
					'alter_text'       => '#D2D3D5',
					'alter_light'      => '#A5A6AA',
					'alter_dark'       => '#FFFFFF',
					'alter_link'       => '#C62045',
					'alter_hover'      => '#AF1336',
					'alter_link2'      => '#D1AD9C',
					'alter_hover2'     => '#BF9A89',
					'alter_link3'      => '#74BDC9',
					'alter_hover3'     => '#55A5B2',

					// Extra blocks (submenu, tabs, color blocks, etc.)
					'extra_bg_color'   => '#2A2A2A',
					'extra_bg_hover'   => '#3f3d47',
					'extra_bd_color'   => '#313131',
					'extra_bd_hover'   => '#575757',
					'extra_text'       => '#888A8D',
					'extra_light'      => '#A5A6AA',
					'extra_dark'       => '#FFFFFF',
					'extra_link'       => '#C62045',
					'extra_hover'      => '#FFFFFF',
					'extra_link2'      => '#80d572',
					'extra_hover2'     => '#8be77c',
					'extra_link3'      => '#ddb837',
					'extra_hover3'     => '#eec432',

					// Input fields (form's fields and textarea)
					'input_bg_color'   => '#transparent',
					'input_bg_hover'   => '#transparent',
					'input_bd_color'   => '#343434',
					'input_bd_hover'   => '#343434',
					'input_text'       => '#D2D3D5',
					'input_light'      => '#A5A6AA',
					'input_dark'       => '#FFFFFF',

					// Inverse blocks (text and links on the 'text_link' background)
					'inverse_bd_color' => '#e36650',
					'inverse_bd_hover' => '#cb5b47',
					'inverse_text'     => '#F9F9F9',
					'inverse_light'    => '#6f6f6f',
					'inverse_dark'     => '#000000',
					'inverse_link'     => '#FFFFFF',
					'inverse_hover'    => '#000000',

					// Additional (skin-specific) colors.
					// Attention! Set of colors must be equal in all color schemes.
					//---> For example:
					//---> 'new_color1'         => '#rrggbb',
					//---> 'alter_new_color1'   => '#rrggbb',
					//---> 'inverse_new_color1' => '#rrggbb',
				),
			),

            // Color scheme: 'extra_light'
            'extra_light' => array(
                'title'    => esc_html__( 'Extra Light', 'verse' ),
                'internal' => true,
                'colors'   => array(

                    // Whole block border and background
                    'bg_color'         => '#FFFFFF',
                    'bd_color'         => '#D0D2D9',

                    // Text and links colors
                    'text'             => '#6A6E71',
                    'text_light'       => '#888A8D',
                    'text_dark'        => '#000000',
                    'text_link'        => '#C62045',
                    'text_hover'       => '#AF1336',
                    'text_link2'       => '#D1AD9C',
                    'text_hover2'      => '#BF9A89',
                    'text_link3'       => '#74BDC9',
                    'text_hover3'      => '#55A5B2',

                    // Alternative blocks (sidebar, tabs, alternative blocks, etc.)
                    'alter_bg_color'   => '#F4F5F7',
                    'alter_bg_hover'   => '#FFFFFF',
                    'alter_bd_color'   => '#D0D2D9',
                    'alter_bd_hover'   => '#BABBBE',
                    'alter_text'       => '#6A6E71',
                    'alter_light'      => '#888A8D',
                    'alter_dark'       => '#000000',
                    'alter_link'       => '#C62045',
                    'alter_hover'      => '#AF1336',
                    'alter_link2'      => '#D1AD9C',
                    'alter_hover2'     => '#BF9A89',
                    'alter_link3'      => '#74BDC9',
                    'alter_hover3'     => '#55A5B2',

                    // Extra blocks (submenu, tabs, color blocks, etc.)
                    'extra_bg_color'   => '#2A2A2A',
                    'extra_bg_hover'   => '#2C313D',
                    'extra_bd_color'   => '#323641',
                    'extra_bd_hover'   => '#575757',
                    'extra_text'       => '#888A8D',
                    'extra_light'      => '#A5A6AA',
                    'extra_dark'       => '#FFFFFF',
                    'extra_link'       => '#C62045',
                    'extra_hover'      => '#FFFFFF',
                    'extra_link2'      => '#80d572',
                    'extra_hover2'     => '#8be77c',
                    'extra_link3'      => '#ddb837',
                    'extra_hover3'     => '#eec432',

                    // Input fields (form's fields and textarea)
                    'input_bg_color'   => 'transparent',
                    'input_bg_hover'   => 'transparent',
                    'input_bd_color'   => '#D0D2D9',
                    'input_bd_hover'   => '#BABBBE',
                    'input_text'       => '#6A6E71',
                    'input_light'      => '#888A8D',
                    'input_dark'       => '#000000',

                    // Inverse blocks (text and links on the 'text_link' background)
                    'inverse_bd_color' => '#67bcc1',
                    'inverse_bd_hover' => '#5aa4a9',
                    'inverse_text'     => '#1d1d1d',
                    'inverse_light'    => '#333333',
                    'inverse_dark'     => '#000000',
                    'inverse_link'     => '#FFFFFF',
                    'inverse_hover'    => '#FFFFFF',

                    // Additional (skin-specific) colors.
                    // Attention! Set of colors must be equal in all color schemes.
                    //---> For example:
                    //---> 'new_color1'         => '#rrggbb',
                    //---> 'alter_new_color1'   => '#rrggbb',
                    //---> 'inverse_new_color1' => '#rrggbb',
                ),
            ),
		);
		verse_storage_set( 'schemes', $schemes );
		verse_storage_set( 'schemes_original', $schemes );

		// Add names of additional colors
		//---> For example:
		//---> verse_storage_set_array( 'scheme_color_names', 'new_color1', array(
		//---> 	'title'       => __( 'New color 1', 'verse' ),
		//---> 	'description' => __( 'Description of the new color 1', 'verse' ),
		//---> ) );


		// Additional colors for each scheme
		// Parameters:	'color' - name of the color from the scheme that should be used as source for the transformation
		//				'alpha' - to make color transparent (0.0 - 1.0)
		//				'hue', 'saturation', 'brightness' - inc/dec value for each color's component
		verse_storage_set(
			'scheme_colors_add', array(
				'bg_color_0'        => array(
					'color' => 'bg_color',
					'alpha' => 0,
				),
				'bg_color_02'       => array(
					'color' => 'bg_color',
					'alpha' => 0.2,
				),
				'bg_color_07'       => array(
					'color' => 'bg_color',
					'alpha' => 0.7,
				),
				'bg_color_08'       => array(
					'color' => 'bg_color',
					'alpha' => 0.8,
				),
				'bg_color_09'       => array(
					'color' => 'bg_color',
					'alpha' => 0.9,
				),
				'alter_bg_color_07' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.7,
				),
				'alter_bg_color_04' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.4,
				),
				'alter_bg_color_00' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0,
				),
				'alter_bg_color_02' => array(
					'color' => 'alter_bg_color',
					'alpha' => 0.2,
				),
				'alter_bd_color_02' => array(
					'color' => 'alter_bd_color',
					'alpha' => 0.2,
				),
                'alter_dark_015'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.15,
                ),
                'alter_dark_02'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.2,
                ),
                'alter_dark_05'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.5,
                ),
                'alter_dark_08'     => array(
                    'color' => 'alter_dark',
                    'alpha' => 0.8,
                ),
				'alter_link_02'     => array(
					'color' => 'alter_link',
					'alpha' => 0.2,
				),
				'alter_link_07'     => array(
					'color' => 'alter_link',
					'alpha' => 0.7,
				),
				'extra_bg_color_05' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.5,
				),
				'extra_bg_color_07' => array(
					'color' => 'extra_bg_color',
					'alpha' => 0.7,
				),
				'extra_link_02'     => array(
					'color' => 'extra_link',
					'alpha' => 0.2,
				),
				'extra_link_07'     => array(
					'color' => 'extra_link',
					'alpha' => 0.7,
				),
                'text_dark_003'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.03,
                ),
                'text_dark_005'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.05,
                ),
                'text_dark_008'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.08,
                ),
				'text_dark_015'      => array(
					'color' => 'text_dark',
					'alpha' => 0.15,
				),
				'text_dark_02'      => array(
					'color' => 'text_dark',
					'alpha' => 0.2,
				),
                'text_dark_03'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.3,
                ),
                'text_dark_05'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.5,
                ),
				'text_dark_07'      => array(
					'color' => 'text_dark',
					'alpha' => 0.7,
				),
                'text_dark_08'      => array(
                    'color' => 'text_dark',
                    'alpha' => 0.8,
                ),
                'text_link_007'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.07,
                ),
				'text_link_02'      => array(
					'color' => 'text_link',
					'alpha' => 0.2,
				),
                'text_link_03'      => array(
                    'color' => 'text_link',
                    'alpha' => 0.3,
                ),
				'text_link_04'      => array(
					'color' => 'text_link',
					'alpha' => 0.4,
				),
				'text_link_07'      => array(
					'color' => 'text_link',
					'alpha' => 0.7,
				),
				'text_link2_08'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.8,
                ),
                'text_link2_007'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.07,
                ),
				'text_link2_02'      => array(
					'color' => 'text_link2',
					'alpha' => 0.2,
				),
                'text_link2_03'      => array(
                    'color' => 'text_link2',
                    'alpha' => 0.3,
                ),
				'text_link2_05'      => array(
					'color' => 'text_link2',
					'alpha' => 0.5,
				),
                'text_link3_007'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.07,
                ),
				'text_link3_02'      => array(
					'color' => 'text_link3',
					'alpha' => 0.2,
				),
                'text_link3_03'      => array(
                    'color' => 'text_link3',
                    'alpha' => 0.3,
                ),
                'inverse_text_03'      => array(
                    'color' => 'inverse_text',
                    'alpha' => 0.3,
                ),
                'inverse_link_08'      => array(
                    'color' => 'inverse_link',
                    'alpha' => 0.8,
                ),
                'inverse_hover_08'      => array(
                    'color' => 'inverse_hover',
                    'alpha' => 0.8,
                ),
				'text_dark_blend'   => array(
					'color'      => 'text_dark',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'text_link_blend'   => array(
					'color'      => 'text_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
				'alter_link_blend'  => array(
					'color'      => 'alter_link',
					'hue'        => 2,
					'saturation' => -5,
					'brightness' => 5,
				),
			)
		);

		// Simple scheme editor: lists the colors to edit in the "Simple" mode.
		// For each color you can set the array of 'slave' colors and brightness factors that are used to generate new values,
		// when 'main' color is changed
		// Leave 'slave' arrays empty if your scheme does not have a color dependency
		verse_storage_set(
			'schemes_simple', array(
				'text_link'        => array(),
				'text_hover'       => array(),
				'text_link2'       => array(),
				'text_hover2'      => array(),
				'text_link3'       => array(),
				'text_hover3'      => array(),
				'alter_link'       => array(),
				'alter_hover'      => array(),
				'alter_link2'      => array(),
				'alter_hover2'     => array(),
				'alter_link3'      => array(),
				'alter_hover3'     => array(),
				'extra_link'       => array(),
				'extra_hover'      => array(),
				'extra_link2'      => array(),
				'extra_hover2'     => array(),
				'extra_link3'      => array(),
				'extra_hover3'     => array(),
			)
		);

		// Parameters to set order of schemes in the css
		verse_storage_set(
			'schemes_sorted', array(
				'color_scheme',
				'header_scheme',
				'menu_scheme',
				'sidebar_scheme',
				'footer_scheme',
			)
		);

		// Color presets
		verse_storage_set(
			'color_presets', array(
				'autumn' => array(
								'title'  => esc_html__( 'Autumn', 'verse' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	),
												'dark' => array(
																	'text_link'  => '#d83938',
																	'text_hover' => '#f2b232',
																	)
												)
							),
				'green' => array(
								'title'  => esc_html__( 'Natural Green', 'verse' ),
								'colors' => array(
												'default' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	),
												'dark' => array(
																	'text_link'  => '#75ac78',
																	'text_hover' => '#378e6d',
																	)
												)
							),
			)
		);
	}
}


// Activation methods
if ( ! function_exists( 'verse_skin_filter_activation_methods2' ) ) {
    add_filter( 'trx_addons_filter_activation_methods', 'verse_skin_filter_activation_methods2', 11, 1 );
    function verse_skin_filter_activation_methods2( $args ) {
        $args['elements_key'] = true;
        return $args;
    }
}


//Enqueue skin-specific scripts
if ( ! function_exists( 'verse_skin_upgrade_style' ) ) {
	add_action( 'wp_enqueue_scripts', 'verse_skin_upgrade_style', 2060 );
	function verse_skin_upgrade_style() {
		$verse_url = verse_get_file_url( verse_skins_get_current_skin_dir() . 'skin-upgrade-style.css' );	
		if ( '' != $verse_url ) {
			wp_enqueue_style( 'verse-skin-upgrade-style' . esc_attr( verse_skins_get_current_skin_name() ), $verse_url, array(), null );
		}
	}
}

$verse_clone_style_path = verse_get_file_dir( verse_skins_get_current_skin_dir() . 'skin-upgrade-style.php' );
if ( ! empty( $verse_clone_style_path ) ) {
	require_once $verse_clone_style_path;
}


// Add div with fixed background
if ( ! function_exists( 'verse_skin_action_before_page_wrap' ) ) {
    add_action('verse_action_before_page_wrap', 'verse_skin_action_before_page_wrap');
    function verse_skin_action_before_page_wrap()  {

        $grained_switch_on = verse_is_on( verse_get_theme_option( 'grained_switch' ) );
        $grained = ($grained_switch_on) ? 'grained_effect' : '';
        $grained_wrap = '<div class="'. $grained .'" >' .'</div>';

        if  ( $grained_switch_on ) {
            verse_show_layout($grained_wrap );
        }
    }
}


// Add theme specified classes to the body
if ( ! function_exists( 'verse_skin_add_body_classes' ) ) {
    add_filter( 'body_class', 'verse_skin_add_body_classes' );
    function verse_skin_add_body_classes($classes) {
        if ( verse_is_on( verse_get_theme_option( 'grained_switch' )  ) ) {
            $classes[] = 'grained_bg';
        }
        return $classes;
    }
}


//Grained textures
if ( ! function_exists( 'verse_skin_add_page_grained_texture' ) ) {
    add_filter( 'after_setup_theme', 'verse_skin_add_page_grained_texture', 3 );
    function verse_skin_add_page_grained_texture() {
		verse_storage_set_array_after(
			'options', 'remove_margins', array_merge(
				array(
					'grained_switch' => array(
						'title'    => esc_html__( 'Grained textures', 'verse' ),
						'desc'     => wp_kses_data( __( 'Activate grained textures', 'verse' ) ),
						"override" => array(
							'mode' => 'page',
							'section' => esc_html__('Content', 'verse')
						),
						'refresh'  => false,
						'std'      => 0,
						'pro_only'   => VERSE_THEME_FREE,
						'type'     => 'switch',
					)
				)
			)
		);
    }
}