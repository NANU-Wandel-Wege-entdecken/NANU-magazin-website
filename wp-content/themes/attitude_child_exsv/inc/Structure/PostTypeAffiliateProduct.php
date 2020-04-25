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
            'name' => __( 'Affiliate Produkte', 'Post Type General Name', 'exsv_affpro' ),
            'singular_name' => __( 'Affiliate Produkt', 'Post Type Singular Name', 'exsv_affpro' ),
            'menu_name' => __( 'Affiliate Produkte', 'exsv_affpro' ),
            'name_admin_bar' => __( 'Affiliate Produkt', 'exsv_affpro' ),
            'archives' => __( 'Affiliate Produkt Archive', 'exsv_affpro' ),
            'attributes' => __( 'Affiliate Produkt Attribute', 'exsv_affpro' ),
            'parent_item_colon' => __( 'Eltern Affiliate Produkt:', 'exsv_affpro' ),
            'all_items' => __( 'Alle Affiliate Produkte', 'exsv_affpro' ),
            'add_new_item' => __( 'Affiliate Produkt erstellen', 'exsv_affpro' ),
            'add_new' => __( 'Erstellen', 'exsv_affpro' ),
            'new_item' => __( 'Affiliate Produkt erstellen', 'exsv_affpro' ),
            'edit_item' => __( 'Bearbeite Affiliate Produkt', 'exsv_affpro' ),
            'update_item' => __( 'Aktualisiere Affiliate Produkt', 'exsv_affpro' ),
            'view_item' => __( 'Affiliate Produkt anschauen', 'exsv_affpro' ),
            'view_items' => __( 'Affiliate Produkte anschauen', 'exsv_affpro' ),
            'search_items' => __( 'Suche Affiliate Produkt', 'exsv_affpro' ),
            'not_found' => __( 'Keine Affiliate Produkte gefunden.', 'exsv_affpro' ),
            'not_found_in_trash' => __( 'Keine Affiliate Produkte im Papierkorb gefunden.', 'exsv_affpro' ),
            'featured_image' => __( 'Beitragsbild', 'exsv_affpro' ),
            'set_featured_image' => __( 'Beitragsbild festlegen', 'exsv_affpro' ),
            'remove_featured_image' => __( 'Beitragsbild entfernen', 'exsv_affpro' ),
            'use_featured_image' => __( 'Als Beitragsbild verwenden', 'exsv_affpro' ),
            'insert_into_item' => __( 'In Affiliate Produkt einfügen', 'exsv_affpro' ),
            'uploaded_to_this_item' => __( 'Zu diesem Affiliate Produkt hochgeladen', 'exsv_affpro' ),
            'items_list' => __( 'Affiliate Produkte Liste', 'exsv_affpro' ),
            'items_list_navigation' => __( 'Affiliate Produkte Liste Navigation', 'exsv_affpro' ),
            'filter_items_list' => __( 'Filter Affiliate Produkte Liste', 'exsv_affpro' ),
        ];

        $args = [
            'label' => __( 'Affiliate Produkt', 'exsv_affpro' ),
            'description' => __( '', 'exsv_affpro' ),
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
            'name'              => _x( 'Affiliate Partner', 'taxonomy general name', 'exsv_affpro' ),
            'singular_name'     => _x( 'Affiliate Partner', 'taxonomy singular name', 'exsv_affpro' ),
            'search_items'      => __( 'Suche Affiliate Partner', 'exsv_affpro' ),
            'all_items'         => __( 'Alle Affiliate Partner', 'exsv_affpro' ),
            'parent_item'       => __( 'Eltern Affiliate Partner', 'exsv_affpro' ),
            'parent_item_colon' => __( 'Eltern Affiliate Partner:', 'exsv_affpro' ),
            'edit_item'         => __( 'Bearbeite Affiliate Partner', 'exsv_affpro' ),
            'update_item'       => __( 'Aktualisiere Affiliate Partner', 'exsv_affpro' ),
            'add_new_item'      => __( 'Affiliate Partner hinzufügen', 'exsv_affpro' ),
            'new_item_name'     => __( 'Neuer Affiliate Partner Name', 'exsv_affpro' ),
            'menu_name'         => __( 'Affiliate Partner', 'exsv_affpro' ),
        );
        $args = array(
            'labels' => $labels,
            'description' => __( '', 'exsv_affpro' ),
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
