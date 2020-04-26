<?php

namespace Nanu\Setup;

class Attachments
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        add_filter( 'media_view_settings', [ $this, 'link_images_to_attachment_file' ] );
        add_filter( 'comments_open', [ $this, 'disable_comments_for_attachment_pages' ], 10 , 2 );
    }

    public function disable_comments_for_attachment_pages( $open, $post_id ) {
        if ( 'attachment' === get_post_type( $post_id ) ) {
            return false;
        }
        return $open;
    }

    public function link_images_to_attachment_file( $settings ) {
        $settings['galleryDefaults']['link'] = 'file';
        return $settings;
    }

}