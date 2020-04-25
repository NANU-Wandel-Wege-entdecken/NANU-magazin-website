<?php

namespace Nanu\Plugins;


class PopularPosts
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
	public function register()
	{   
        if ( ! in_array( 'wordpress-popular-posts/wordpress-popular-posts.php', apply_filters('active_plugins', get_option('active_plugins') ) ) ) { 
            return;
        }
		add_filter( 'wpp_custom_html', [ $this, 'popular_posts_custom_html_list' ], 10, 2 );
	}


    /*
    * Builds custom HTML
    *
    * With this function, I can alter WPP's HTML output from my theme's functions.php.
    * This way, the modification is permanent even if the plugin gets updated.
    *
    * @param   array   $mostpopular
    * @param   array   $instance
    * @return  string
    */
    public function popular_posts_custom_html_list( $mostpopular, $instance ){
        $output = '<div id="top8"><ul class="wpp-list">';

        // loop the array of popular posts objects
        foreach( $mostpopular as $popular ) {

            $stats = array(); // placeholder for the stats tag

            // Comment count option active, display comments
            if ( $instance['stats_tag']['comment_count'] ) {
                // display text in singular or plural, according to comments count
                $stats[] = '<span class="wpp-comments">' . sprintf(
                    _n('1 comment', '%s comments', $popular->comment_count, 'wordpress-popular-posts'),
                    number_format_i18n($popular->comment_count)
                ) . '</span>';
            }

            // Pageviews option checked, display views
            if ( $instance['stats_tag']['views'] ) {

                // If sorting posts by average views
                if ($instance['order_by'] == 'avg') {
                    // display text in singular or plural, according to views count
                    $stats[] = '<span class="wpp-views">' . sprintf(
                        _n('1 view per day', '%s views per day', intval($popular->pageviews), 'wordpress-popular-posts'),
                        number_format_i18n($popular->pageviews, 2)
                    ) . '</span>';
                } else { // Sorting posts by views
                    // display text in singular or plural, according to views count
                    $stats[] = '<span class="wpp-views">' . sprintf(
                        _n('1 view', '%s views', intval($popular->pageviews), 'wordpress-popular-posts'),
                        number_format_i18n($popular->pageviews)
                    ) . '</span>';
                }
            }

            // Author option checked
            if ($instance['stats_tag']['author']) {
                $author = get_the_author_meta('display_name', $popular->uid);
                $display_name = '<a href="' . get_author_posts_url($popular->uid) . '">' . $author . '</a>';
                $stats[] = '<i>' . sprintf(__('by %s', 'wordpress-popular-posts'), $display_name). '</i> - ';
            }

            // Date option checked
            if ($instance['stats_tag']['date']['active']) {
                $date = date_i18n($instance['stats_tag']['date']['format'], strtotime($popular->date));
                $stats[] = '<span class="wpp-date">' . sprintf(__('posted on %s', 'wordpress-popular-posts'), $date) . '</span>';
            }

            // Category option checked
            if ($instance['stats_tag']['category']) {
                $post_cat = get_the_category($popular->id);
                $post_cat = (isset($post_cat[0]))
                ? '<a href="' . get_category_link($post_cat[0]->term_id) . '">' . $post_cat[0]->cat_name . '</a>'
                : '';

                if ($post_cat != '') {
                    $stats[] = '<span class="wpp-category">' . sprintf(__('under %s', 'wordpress-popular-posts'), $post_cat) . '</span>';
                }
            }

            // Build stats tag
            if ( !empty($stats) ) {
                $stats = '<p>' . join( ' | ', $stats ) . '';
            }

            $excerpt = ''; // Excerpt placeholder

            // Excerpt option checked, build excerpt tag
            if ($instance['post-excerpt']['active']) {
                $excerpt = get_the_excerpt( $popular->id );
                if ( !empty($excerpt) ) {
                    $excerpt = '' . $excerpt . '</p>';
                }
            }

            $output .= "<li class=\"postformat-" . get_post_format( $popular->id ) . "\">";
            $output .= "<a href=\"" . get_the_permalink( $popular->id ) . "\" title=\"" . esc_attr( $popular->title ) . "\" class=\"wpp-thumbnail wpp_featured_stock wp-post-image\" target=\"_self\">" . get_the_post_thumbnail( $popular->id, 'gallery' ) . "</a>";
            $output .= "<a href=\"" . get_the_permalink( $popular->id ) . "\" title=\"" . esc_attr( $popular->title ) . "\" class=\"wpp-post-title\" target=\"_self\">" . $popular->title . "</a>";
            $output .= $stats;
            $output .= $excerpt;
            $output .= "<a class=\"readmore\" href=\"" . get_the_permalink( $popular->id ) . "\" title=\"" . esc_attr( $popular->title ) . "\">Artikel lesen</a></li>" . "\n";

        }

        $output .= '</ul></div>';

        return $output;
    }
}

