<?php

namespace Nanu\Structure;

class Subtitle
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        add_action( 'admin_menu', [ $this, 'create_subtitle_metabox' ] );
        add_action( 'save_post', [ $this, 'save_subtitle_on_save_post' ], 10, 2 );
    }

    public function create_subtitle_metabox() {
        add_meta_box( 'subtitle_metabox', 'Post Subtitle', [ $this, 'subtitle_metabox_html' ], 'post', 'normal', 'high' );
        add_meta_box( 'subtitle_metabox', 'Page Subtitle', [ $this, 'subtitle_metabox_html' ], 'page', 'normal', 'high' );
    }

    public function subtitle_metabox_html( $object, $box ) { 
        ?>
        <div id="postcustomstuff">
        <p>
            <label>Bitte gib einen Untertitel ein:</label>
            <input name="page_sub_title" id="sw_title" style="width: 97%;" value="<?php echo esc_html( get_post_meta( $object->ID, 'page_sub_title', true ), 1 ); ?>" />
            <input type="hidden" name="subtitle_nonce" value="<?php echo wp_create_nonce( 'subtitle-nonce' ); ?>" />
        </p>
        </div>
        <?php 
    }

    public function save_subtitle_on_save_post( $post_id, $post ) {

        if ( ! wp_verify_nonce( $_POST['subtitle_nonce'], 'subtitle-nonce' ) ) {
            return $post_id;
        }

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        //Saving 1st Data
        
        $meta_value     = get_post_meta( $post_id, 'page_sub_title', true );
        $new_meta_value = stripslashes( $_POST['page_sub_title'] );

        if ( $new_meta_value && '' == $meta_value ) {
            add_post_meta( $post_id, 'page_sub_title', $new_meta_value, true );
        } elseif ( $new_meta_value != $meta_value ) {
            update_post_meta( $post_id, 'page_sub_title', $new_meta_value );
        } elseif ( '' == $new_meta_value && $meta_value ) {
            delete_post_meta( $post_id, 'page_sub_title', $meta_value ); 
        }
    }

    static function the_subtitle() {
        global $post;
        $subtitle = get_post_meta($post->ID, 'page_sub_title', true);
        if ( ! empty( $subtitle ) ) : 
            ?>
            <h2 class="subtitle_head">
            <?php echo $subtitle; ?>
            </h2>
            <?php 
        endif;
    }
}