<?php

namespace Nanu\Admin;

class EditFlow
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        add_filter( 'comments_clauses', [ $this, 'restrict_comment_visibility_to_own_posts' ] );

        add_action( 'pre_get_posts', [ $this, 'restrict_post_visibility_to_own_posts' ] );

        /* TODO does not work with Gutenberg yet */
        add_action( 'admin_notices', [ $this, 'add_admin_notice_with_editing_advice' ] );

        add_action( 'future_to_pending',     [ $this, 'send_email_notice_on_new_pending_post' ] );
        add_action( 'new_to_pending',        [ $this, 'send_email_notice_on_new_pending_post' ] );
        add_action( 'draft_to_pending',      [ $this, 'send_email_notice_on_new_pending_post' ] );
        add_action( 'auto-draft_to_pending', [ $this, 'send_email_notice_on_new_pending_post' ] );
    }

    // Nur Kommentare zu eigenen Artikeln anzeigen
    public function restrict_comment_visibility_to_own_posts( $clauses ) {
        if ( is_admin() && ! current_user_can( 'edit_others_posts' ) ) {
            global $user_ID, $wpdb;
            $clauses['join'] = ", ".$wpdb->base_prefix."posts";
            $clauses['where'] .= " AND ".$wpdb->base_prefix."posts.post_author = ".$user_ID." AND ".$wpdb->base_prefix."comments.comment_post_ID = ".$wpdb->base_prefix."posts.ID";
        }
        return $clauses;
    }

    // Nur eigene Artikel anzeigen
    public function restrict_post_visibility_to_own_posts( $query ) {

        if ( ! is_admin() ) {
            return $query;
        }
        //$pagenow holds the name of the current page being viewed
        global $pagenow;

        //$current_user uses the get_currentuserinfo() method to get the currently logged in user's data
        global $current_user;

        //Shouldn't happen for the admin und nicht für Editor*innen - daher Prüfung nach capability Edit Others Posts, but for any role with the edit_posts capability and only on the posts list page, that is edit.php
        if (
            ! current_user_can( 'edit_others_posts' )
            && current_user_can( 'edit_posts' )
            && ( 'edit.php' == $pagenow )
        ) {
            //global $query's set() method for setting the author as the current user's id
            $query->set( 'author', $current_user->ID );
        }

        return $query;
    }

    // Email versenden, sobald ein Artikel auf Review geschickt wird
    public function send_email_notice_on_new_pending_post( $post ) {
        $emails  = "michael@nanu-magazin.org";
        $title   = wp_strip_all_tags( get_the_title( $post->ID ) );
        $url     = get_permalink( $post->ID );
        $message = "Bitte prüfen! Link zum Artikel: \n{$url}";

        wp_mail( $emails, "Neuer Gastartikel: {$title}", $message );
    }

    public function add_admin_notice_with_editing_advice() {
        global $pagenow;
    
        if ( ( $pagenow == 'post-new.php' || $pagenow == 'edit.php' ) && 'post' === get_post_type( $_GET['post'] ) ) {
            echo '<div class="notice notice-info is-dismissible">
            <p><strong>Ein paar Tipps fürs Schreiben</strong><br>Bitte schau dir folgende Tipps und Anhaltspunkte an, damit dein Artikel möglichst flott für eine Veröffentlichung in Frage kommt: <a href="https://nanu-magazin.org/mitmachen/gastartikel-schreiben/das-format-von-experimentselbstversorgung-net/" target="_blank">So schreiben wir Artikel auf dieser Website!</a></p>
            </div>';
        }
    }
    
}