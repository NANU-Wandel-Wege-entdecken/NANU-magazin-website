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
        add_filter( 'media_view_settings', 'link_images_to_attachment_file');
        add_filter( 'comments_open', 'disable_comments_for_attachment_pages', 10 , 2 );
    }

    public function disable_comments_for_attachment_pages( $open, $post_id ) {
        $post = get_post( $post_id );
        if ( 'attachment' === $post->post_type ) {
            return false;
        }
        return $open;
    }

    public function link_images_to_attachment_file( $settings ) {
        $settings['galleryDefaults']['link'] = 'file';
        return $settings;
    }

}