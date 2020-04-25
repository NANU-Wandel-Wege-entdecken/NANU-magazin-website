<?php

namespace Nanu\Setup;

class Language
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        load_theme_textdomain( 'attitude', get_stylesheet_directory() . '/library/languages' );
    }
}



