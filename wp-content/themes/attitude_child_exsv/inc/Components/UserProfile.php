<?php

namespace Nanu\Components;

class UserProfile
{
    /**
     * register default hooks and actions for WordPress
     * @return
     */
    public function register()
    {
        add_action( 'init', [ $this, 'change_author_slug' ] );
        add_action( 'after_switch_theme', array( $this, 'rewrite_flush') );

        add_filter( 'user_contactmethods', [ $this, 'add_user_contact_methods' ] );

        add_action( 'show_user_profile', [ $this, 'add_custom_user_profile_fields' ] );
        add_action( 'edit_user_profile', [ $this, 'add_custom_user_profile_fields' ] );
        
        add_action( 'personal_options_update', [ $this, 'save_custom_user_profile_fields' ] );
        add_action( 'edit_user_profile_update', [ $this, 'save_custom_user_profile_fields' ] );

        add_filter( 'get_the_author_description', 'wpautop' );
    }

    public function change_author_slug() {
        global $wp_rewrite;
        $author_slug = 'profil'; // change slug name
        $wp_rewrite->author_base = $author_slug;
    }

    // Zusätzliche Felder im Benutzerprofil
    public function add_user_contact_methods( $user_contactmethods ) {

        $user_contactmethods['facebook']  = '<b>Facebook</b> (nur deinen Username, also z.B.: <b>michael.hartl</b> statt https://facebook.com/michael.hartl';
        $user_contactmethods['twitter']   = '<b>Twitter</b> (nur deinen Username)';
        $user_contactmethods['instagram'] = '<b>Instagram</b> (nur deinen Username)';

        // Yahoo, Jabber, AOL entfernen
        unset($user_contactmethods['yim']);
        unset($user_contactmethods['googleplus']);
        unset($user_contactmethods['jabber']);
        unset($user_contactmethods['aim']);

        return $user_contactmethods;
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

    // Weitere Felder im User-Profil anlegen
    public function add_custom_user_profile_fields( $user ) {
        ?>
        <h3><?php _e('Weitere Angaben für die Profilseite', 'exsv_affpro'); ?></h3>
        <p>Was du hier eingibst, erscheint auf deiner Profil-Seite. Der erste lange Absatz der Profilseite ist der Text, den du weiter oben bei "Biographische Angaben" eingegeben hast. Siehe als Beispiel für eine Profilseite die von <a href="https://nanu-magazin.org/profil/lisa/" target="_blanc">Lisa.</a></p>
        <table class="form-table">
            <tr>
                <th>
                    <label for="taetigkeiten"><?php _e('Tätigkeiten', 'exsv_affpro'); ?></label>
                </th>
                <td>
                    <input type="text" name="taetigkeiten" id="taetigkeiten" value="<?php echo esc_attr( get_the_author_meta( 'taetigkeiten', $user->ID ) ); ?>" class="regular-text" /><br />
                    <span class="description"><?php _e('Sowas wie <b>Autor, Projektmanager, Superstar</b>.', 'exsv_affpro'); ?></span>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="mehrbio"><?php _e('Weitere biographische Angaben', 'exsv_affpro'); ?></label>
                </th>
                <td>
                    <textarea name="mehrbio" id="mehrbio" rows="8" cols="30" class="regular-text" /><?php echo esc_attr( get_the_author_meta( 'mehrbio', $user->ID ) ); ?></textarea><br />
                    <span class="description"><?php _e('Erscheinen auf der Profil-Seite, nicht bei den Artikeln. Diese erscheinen direkt unter den Biographischen Angaben, die du weiter oben eingeben kannst. Biographische Angaben erscheinen sowohl unter deinen Artikeln, als auch in deinem Profil - die Angaben hier eben nur als nächster Bereich nach den Biographischen Angaben im Profil.', 'exsv_affpro'); ?></span>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="zusatzinfo"><?php _e('Zusatzinfos', 'exsv_affpro'); ?></label>
                </th>
                <td>
                    <textarea name="zusatzinfo" id="zusatzinfo" rows="2" cols="30" class="regular-text" /><?php echo esc_attr( get_the_author_meta( 'zusatzinfo', $user->ID ) ); ?></textarea><br />
                    <span class="description"><?php _e('Sachen wie <b>Julia bloggt regelmäßig auf hundertwasser-blog.at</b>.', 'exsv_affpro'); ?></span>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="linktext"><?php _e('Text eines Links nach der Zusatzinfo', 'exsv_affpro'); ?></label>
                </th>
                <td>
                    <textarea name="linktext" id="linktext" rows="1" cols="30" class="regular-text" /><?php echo esc_attr( get_the_author_meta( 'linktext', $user->ID ) ); ?></textarea><br />
                    <span class="description"><?php _e('Wird unterhalb der Zusatzinfo angezeigt. Sowas wie <b>Lies jetzt ihre neuesten Artikel!</b>', 'exsv_affpro'); ?></span>
                </td>
            </tr>
            <tr>
                <th>
                    <label for="linkurl"><?php _e('URL des Links', 'exsv_affpro'); ?></label>
                </th>
                <td>
                    <input type="text" name="linkurl" id="linkurl" value="<?php echo esc_attr( get_the_author_meta( 'linkurl', $user->ID ) ); ?>" class="regular-text" /><br />
                </td>
            </tr>
        </table>
    <?php }
    
    public function save_custom_user_profile_fields( $user_id ) {
    
        if ( ! current_user_can( 'edit_user', $user_id ) ) {
            return false;
        }
    
        update_user_meta( $user_id, 'mehrbio', $_POST['mehrbio'] );
        update_user_meta( $user_id, 'zusatzinfo', $_POST['zusatzinfo'] );
        update_user_meta( $user_id, 'linktext', $_POST['linktext'] );
        update_user_meta( $user_id, 'linkurl', $_POST['linkurl'] );
        update_user_meta( $user_id, 'taetigkeiten', $_POST['taetigkeiten'] );
    }
} 
