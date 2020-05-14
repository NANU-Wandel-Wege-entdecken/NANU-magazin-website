<?php

namespace Nanu\Structure;

use WordPlate\Acf\Location;
use WordPlate\Acf\Fields\User;

/**
 * Custom Post Type Affiliate Product
 */
class CategoryLeadAuthor
{
	/**
     * register default hooks and actions for WordPress
     * @return
     */
	public function register() {

        $this->register_acf_field_group();

	}

    public function register_acf_field_group() {
        register_extended_field_group([
            'title' => '',
            'fields' => [
                User::make( __( 'Lead Author', 'attitude' ), 'category_lead_author')
                    ->roles([
                        'administrator',
                        'author',
                        'editor'
                    ])
                    ->returnFormat('object'),
            ],
            'location' => [
                Location::if('taxonomy', 'category')
            ],
        ]);
    }

    public static function get_category_lead_author( $term = false ) {

        if ( $term ) {
            $term = get_term( $term );
        } else if ( is_category() ) {
            $term = get_queried_object();
        } else {
            return '';
        }

        $category_lead_author = get_field( 'category_lead_author', $term );
        return is_wp_error( $category_lead_author ) ? '' : $category_lead_author;
    }
    
}


