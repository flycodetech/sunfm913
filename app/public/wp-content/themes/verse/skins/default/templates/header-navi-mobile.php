<?php
/**
 * The template to show mobile menu (used only header_style == 'default')
 *
 * @package VERSE
 * @since VERSE 1.0
 */

$verse_show_widgets = verse_get_theme_option( 'widgets_menu_mobile_fullscreen' );
$verse_show_socials = verse_get_theme_option( 'menu_mobile_socials' );

?>
<div class="menu_mobile_overlay scheme_dark"></div>
<div class="menu_mobile menu_mobile_<?php echo esc_attr( verse_get_theme_option( 'menu_mobile_fullscreen' ) > 0 ? 'fullscreen' : 'narrow' ); ?> scheme_dark">
	<div class="menu_mobile_inner<?php echo esc_attr( $verse_show_widgets == 1  ? ' with_widgets' : '' ); ?>">
        <div class="menu_mobile_header_wrap">
            <?php
            // Logo
            set_query_var( 'verse_logo_args', array( 'type' => 'mobile' ) );
            get_template_part( apply_filters( 'verse_filter_get_template_part', 'templates/header-logo' ) );
            set_query_var( 'verse_logo_args', array() ); ?>

            <a class="menu_mobile_close menu_button_close" tabindex="0"><span class="menu_button_close_text"><?php esc_html_e('Close', 'verse')?></span><span class="menu_button_close_icon"></span></a>
        </div>
        <div class="menu_mobile_content_wrap content_wrap">
            <div class="menu_mobile_content_wrap_inner<?php echo esc_attr($verse_show_socials ? '' : ' without_socials'); ?>"><?php
            // Mobile menu
            $verse_menu_mobile = verse_get_nav_menu( 'menu_mobile' );
            if ( empty( $verse_menu_mobile ) ) {
                $verse_menu_mobile = apply_filters( 'verse_filter_get_mobile_menu', '' );
                if ( empty( $verse_menu_mobile ) ) {
                    $verse_menu_mobile = verse_get_nav_menu( 'menu_main' );
                    if ( empty( $verse_menu_mobile ) ) {
                        $verse_menu_mobile = verse_get_nav_menu();
                    }
                }
            }
            if ( ! empty( $verse_menu_mobile ) ) {
                $verse_menu_mobile = str_replace(
                    array( 'menu_main',   'id="menu-',        'sc_layouts_menu_nav', 'sc_layouts_menu ', 'sc_layouts_hide_on_mobile', 'hide_on_mobile' ),
                    array( 'menu_mobile', 'id="menu_mobile-', '',                    ' ',                '',                          '' ),
                    $verse_menu_mobile
                );
                if ( strpos( $verse_menu_mobile, '<nav ' ) === false ) {
                    $verse_menu_mobile = sprintf( '<nav class="menu_mobile_nav_area" itemscope="itemscope" itemtype="%1$s//schema.org/SiteNavigationElement">%2$s</nav>', esc_attr( verse_get_protocol( true ) ), $verse_menu_mobile );
                }
                verse_show_layout( apply_filters( 'verse_filter_menu_mobile_layout', $verse_menu_mobile ) );
            }
            // Social icons
            if($verse_show_socials) {
                verse_show_layout( verse_get_socials_links(), '<div class="socials_mobile">', '</div>' );
            }            
            ?>
            </div>
		</div><?php

        if ( $verse_show_widgets == 1 )  {
            ?><div class="menu_mobile_widgets_area"><?php
            // Create Widgets Area
            verse_create_widgets_area( 'widgets_additional_menu_mobile_fullscreen' );
            ?></div><?php
        } ?>

    </div>
</div>
