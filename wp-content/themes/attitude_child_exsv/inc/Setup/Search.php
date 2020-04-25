<?php

namespace Nanu\Setup;

class Search
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        add_action( 'pre_get_posts', [ $this, 'exclude_certain_pages_from_search' ] );
    }

    /**
     * Exclude certain pages from search
     *
     * @param [type] $query
     * @return void
     */
    public function exclude_certain_pages_from_search( $query ) {
        if ( $query->is_search ) {
            $query->set('post__not_in', [
                111820,
                118210,
                110339,
                111575,
                111564,
                111582,
                110372,
                110782,
                110353,
                111119,
                113183,
                114917,
                114916,
                114791,
                115259,
                115260,
                110259,
                3560
             ] );
        }
        return $query;
    }
}