<?php
/**
 * Plugin Name: Remove Admin Notices
 * Author: Garth Mortensen
 * Author URI: https://www.garthmortensen.com
 * Donate Link: https://www.garthmortensen.com/donate
 * Description: Honestly, I'm just sick of going into my wp-admin and seeing "YOAST!!!!!" all over the place. ¯\_(ツ)_/¯ And then I noticed other things I didn't like about the plugin, so I got rid of those things too. And then Joost contacted me and said I don't have permission to use his trademark, so I changed the name to "Remove Admin Notices". Now I can block other plugins that have the same terrible practices.
 * Version: 1.2
 */

function remove_admin_notices() {
    if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
        if ( !class_exists( 'Yoast_Notification_Center' ) ) {
            require_once( WP_PLUGIN_DIR . '/wordpress-seo/admin/class-yoast-notification-center.php' );
        }
        remove_action( 'all_admin_notices', array( Yoast_Notification_Center::get(), 'display_notifications' ) );
    }
}
add_action( 'admin_init', 'remove_admin_notices' );

function remove_admin_sidebar() {
    ?>
<style>
.wpseo_content_cell #sidebar {
    display: none;
}
</style>
    <?php
}
add_action( 'admin_head', 'remove_admin_sidebar' );

function remove_annoying_admin_html_comments() {
    include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    if ( is_plugin_active( 'wordpress-seo/wp-seo.php' ) ) {
        if( !class_exists( 'WPSEO_Frontend' ) ) {
            require_once( WP_PLUGIN_DIR . '/wordpress-seo/frontend/class-frontend.php' );
        }
        $a = remove_action( 'wpseo_head', array( WPSEO_Frontend::get_instance(), 'debug_marker' ), 2 );
    }
}
add_action( 'init', 'remove_annoying_admin_html_comments' );

function remove_lame_admin_bar() {
    global $wp_admin_bar;
    $wp_admin_bar->remove_menu( 'wpseo-menu' );
}
add_action( 'admin_bar_menu', 'remove_lame_admin_bar', 96 );
