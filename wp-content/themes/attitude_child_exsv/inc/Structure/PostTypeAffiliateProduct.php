<?php

namespace Nanu\Structure;

/**
 * Custom Post Type Affiliate Product
 */
class PostTypeAffiliateProduct
{
	/**
     * register default hooks and actions for WordPress
     * @return
     */
	public function register() {
		add_action( 'init', array( $this, 'register_post_type_affiliate_product'), 5 );
		add_action( 'after_switch_theme', array( $this, 'rewrite_flush') );
	}

  /**
    * Create Custom Post Type
    * @return empty
    */
    public function register_post_type_affiliate_product()
    {
        $labels = [
            'name' => __( 'Affiliate Produkte', 'Post Type General Name', 'attitude' ),
            'singular_name' => __( 'Affiliate Produkt', 'Post Type Singular Name', 'attitude' ),
            'menu_name' => __( 'Affiliate Produkte', 'attitude' ),
            'name_admin_bar' => __( 'Affiliate Produkt', 'attitude' ),
            'archives' => __( 'Affiliate Produkt Archive', 'attitude' ),
            'attributes' => __( 'Affiliate Produkt Attribute', 'attitude' ),
            'parent_item_colon' => __( 'Eltern Affiliate Produkt:', 'attitude' ),
            'all_items' => __( 'Alle Affiliate Produkte', 'attitude' ),
            'add_new_item' => __( 'Affiliate Produkt erstellen', 'attitude' ),
            'add_new' => __( 'Erstellen', 'attitude' ),
            'new_item' => __( 'Affiliate Produkt erstellen', 'attitude' ),
            'edit_item' => __( 'Bearbeite Affiliate Produkt', 'attitude' ),
            'update_item' => __( 'Aktualisiere Affiliate Produkt', 'attitude' ),
            'view_item' => __( 'Affiliate Produkt anschauen', 'attitude' ),
            'view_items' => __( 'Affiliate Produkte anschauen', 'attitude' ),
            'search_items' => __( 'Suche Affiliate Produkt', 'attitude' ),
            'not_found' => __( 'Keine Affiliate Produkte gefunden.', 'attitude' ),
            'not_found_in_trash' => __( 'Keine Affiliate Produkte im Papierkorb gefunden.', 'attitude' ),
            'featured_image' => __( 'Beitragsbild', 'attitude' ),
            'set_featured_image' => __( 'Beitragsbild festlegen', 'attitude' ),
            'remove_featured_image' => __( 'Beitragsbild entfernen', 'attitude' ),
            'use_featured_image' => __( 'Als Beitragsbild verwenden', 'attitude' ),
            'insert_into_item' => __( 'In Affiliate Produkt einfügen', 'attitude' ),
            'uploaded_to_this_item' => __( 'Zu diesem Affiliate Produkt hochgeladen', 'attitude' ),
            'items_list' => __( 'Affiliate Produkte Liste', 'attitude' ),
            'items_list_navigation' => __( 'Affiliate Produkte Liste Navigation', 'attitude' ),
            'filter_items_list' => __( 'Filter Affiliate Produkte Liste', 'attitude' ),
        ];

        $args = [
            'label' => __( 'Affiliate Produkt', 'attitude' ),
            'description' => __( '', 'attitude' ),
            'labels' => $labels,
            'menu_icon' => 'dashicons-cart',
            'supports' => [ 'title', 'thumbnail' ],
            'taxonomies' => [ 'affiliatepartner' ],
            'public' => false,
            'show_ui' => true,
            'show_in_menu' => true,
            'menu_position' => 5,
            'show_in_admin_bar' => true,
            'show_in_nav_menus' => false,
            'can_export' => true,
            'has_archive' => false,
            'hierarchical' => false,
            'exclude_from_search' => true,
            'show_in_rest' => true,
            'publicly_queryable' => true,
            'capability_type' => 'page',
        ];
        register_post_type( 'affiliateprodukt', $args );
    
        $labels = array(
            'name'              => _x( 'Affiliate Partner', 'taxonomy general name', 'attitude' ),
            'singular_name'     => _x( 'Affiliate Partner', 'taxonomy singular name', 'attitude' ),
            'search_items'      => __( 'Suche Affiliate Partner', 'attitude' ),
            'all_items'         => __( 'Alle Affiliate Partner', 'attitude' ),
            'parent_item'       => __( 'Eltern Affiliate Partner', 'attitude' ),
            'parent_item_colon' => __( 'Eltern Affiliate Partner:', 'attitude' ),
            'edit_item'         => __( 'Bearbeite Affiliate Partner', 'attitude' ),
            'update_item'       => __( 'Aktualisiere Affiliate Partner', 'attitude' ),
            'add_new_item'      => __( 'Affiliate Partner hinzufügen', 'attitude' ),
            'new_item_name'     => __( 'Neuer Affiliate Partner Name', 'attitude' ),
            'menu_name'         => __( 'Affiliate Partner', 'attitude' ),
        );
        $args = array(
            'labels' => $labels,
            'description' => __( '', 'attitude' ),
            'hierarchical' => false,
            'public' => false,
            'publicly_queryable' => true,
            'show_ui' => true,
            'show_in_menu' => true,
            'show_in_nav_menus' => false,
            'show_in_rest' => false,
            'show_tagcloud' => false,
            'show_in_quick_edit' => true,
            'show_admin_column' => true,
        );
        register_taxonomy( 'affiliatepartner', array('affiliateprodukt', ), $args );

	}

    /**
    * Flush Rewrite on CPT activation
    * @return empty
    */
    public function rewrite_flush()
    {
        // Flush the rewrite rules only on theme activation
        flush_rewrite_rules();
    }
}
