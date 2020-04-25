<?php

namespace Nanu\Setup;

class Setup
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        add_action( 'after_setup_theme', [ $this, 'setup' ] );
        add_action( 'after_setup_theme', [ $this, 'content_width' ], 0);
    }

    public function setup()
    {
        /*
         * You can activate this if you're planning to build a multilingual theme
         */
        // load_theme_textdomain( 'nanu', get_template_directory() . '/languages' );

        /*
         * Default Theme Support options better have
         */
        // Add default posts and comments RSS feed links to head
        add_theme_support( 'automatic-feed-links' );
        add_theme_support( 'title-tag' );
        // This theme uses Featured Images (also known as post thumbnails) for per-post/per-page.
        add_theme_support( 'post-thumbnails' );
        add_theme_support( 'customize-selective-refresh-widgets' );

        add_theme_support( 'html5', [ 
            'comment-list',
            'comment-form',
            'search-form',
            'gallery',
            'caption',
            'style',
            'script'
         ] );

        /*
         * Activate Post formats if you need
         */
        add_theme_support( 'post-formats', [
            //'aside',
            'gallery',
            'link',
            //'image',
            //'quote',
            //'status',
            'video',
            'audio',
            //'chat',
        ] );


        // Add Attitude custom image sizes
        add_image_size( 'featured', 670, 300, true );
        add_image_size( 'featured-medium', 230, 230, true );
        add_image_size( 'slider-narrow', 1038, 460, true );
        add_image_size( 'large', 642, 9999 );
        add_image_size( 'gallery', 474, 342, true );
        add_image_size( 'icon', 80, 80, true );
        add_image_size( 'mobile', 280, 200, true);
        add_image_size( 'yarpp-thumbnail', 300, 200, true );
        add_image_size( 'schmal', 310, 9999, true );
        add_image_size( 'rich-snippet', 300, 300, true );

        add_filter( 'image_size_names_choose', [ $this, 'custom_image_sizes_in_backend' ] );
    }


    /*
        Define a max content width to allow WordPress to properly resize your images
    */
    public function content_width()
    {
        $GLOBALS[ 'content_width' ] = apply_filters( 'content_width', 1038 );
    }

    /*
        Register custom image sizes for backend use
    */
    public function custom_image_sizes_in_backend( $sizes ) {
        $sizes['large']           =  __( 'ganze Breite', 'attitude' );
        $sizes['yarpp-thumbnail'] =  __( 'Vorschaubild', 'attitude' );
        $sizes['featured-medium'] =  __( 'rechteckiges Vorschaubild', 'attitude' );
        $sizes['schmal']          =  __( 'schmal für seitlich', 'attitude' );
        $sizes['rich-snippet']    =  __( 'für rich snippets', 'attitude' );
        return $sizes;
    }
}
