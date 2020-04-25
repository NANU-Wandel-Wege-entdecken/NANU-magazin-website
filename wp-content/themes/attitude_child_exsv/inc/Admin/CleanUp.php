<?php

namespace Nanu\Admin;

class CleanUp
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        add_action( 'admin_head', [ $this, 'admin_favicon' ] );
        add_action( 'wp_before_admin_bar_render', [ $this, 'cleanup_admin_bar' ] );
        remove_action( 'admin_color_scheme_picker', 'admin_color_scheme_picker' );
    }

   

    // Specify favicon for Dashboard
    public function admin_favicon() {
        echo '<link rel="Shortcut Icon" type="image/x-icon" href="nanu-magazin.org/wp-content/uploads/images/favicon.ico" />';
    }

    // cleanup admin bar
    function cleanup_admin_bar() {
        global $wp_admin_bar;
        $wp_admin_bar->remove_menu('wp-logo');
        $wp_admin_bar->remove_menu('new-link', 'new-content');
        // if (!current_user_can('Gastautor*in')) {
        //    $wp_admin_bar->remove_menu('comments');
        // }
    }


}




