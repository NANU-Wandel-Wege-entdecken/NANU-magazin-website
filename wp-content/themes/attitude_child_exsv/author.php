<?php get_header(); ?>

<?php
	/**
	 * attitude_before_main_container hook
	 */
	do_action( 'attitude_before_main_container' );
?>

<div id="container" style="width: 100%;">
	<div id="content" class="authorpage" style="max-width: 668px; margin: 0 auto;">

<?php
    $curauth = (isset($_GET['author_name'])) ? get_user_by('slug', $author_name) : get_userdata(intval($author));
    ?>
    <div class="zentrieren">
    <div class="profil-avatar">
    <?php
    $email = $curauth->user_email;
    echo get_avatar( $email, 130 );
    ?>
    </div>
    <h1><?php echo $curauth->user_firstname; ?> <?php echo $curauth->user_lastname; ?></h1>
    <?php if( $curauth->taetigkeiten ) { ?>
    <h2><?php echo $curauth->taetigkeiten; ?></h2>
    <?php } ?>
    <p><?php echo $curauth->user_description; ?></p>
    <?php if( $curauth->mehrbio ) { ?>
    <p><?php echo $curauth->mehrbio; ?></p>
    <?php } ?>
    <?php if( $curauth->zusatzinfo ) { ?>
    <p class="zinfo"><?php echo $curauth->zusatzinfo; ?></p>
    <?php } ?>
    <?php if( $curauth->linkurl ) { ?>
    <p class="profillink"><a href="<?php echo $curauth->linkurl; ?>"><?php echo $curauth->linktext; ?></a></p>
    <?php } ?>
    </div>
            <?php if(get_the_author_meta('url')):  ?>
                <h2>Vernetze dich mit <?php the_author_meta('user_firstname'); ?></h2>
                <p class="websitelink-profil"><b>Website:</b> <a href="<?php the_author_meta('url'); ?>" class="no-ext-icon" target="_blanc"><?php the_author_meta('url'); ?></a>
            <?php
               else:
               // do nothing
               endif; ?>
           <div class="profilsocial">
               <?php if(get_the_author_meta('facebook')):  ?>
               <div class="socialauthorbuttons">
                    <a href="https://facebook.com/<?php the_author_meta('facebook'); ?>" class="facebook no-ext-icon" target="_blanc" rel="nofollow">Facebook</a>
                    <a href="https://facebook.com/<?php the_author_meta('facebook'); ?>" class="no-ext-icon" target="_blanc" rel="nofollow">/<?php the_author_meta('facebook'); ?></a>
               </div>
               <?php
               else:
               // do nothing
               endif; ?>
               <?php if(get_the_author_meta('instagram')):  ?>
               <div class="socialauthorbuttons">
                    <a href="https://instagram.com/<?php the_author_meta('instagram'); ?>" class="instagram no-ext-icon" target="_blanc" rel="nofollow">Instagram</a>
                    <a href="https://instagram.com/<?php the_author_meta('instagram'); ?>" class="no-ext-icon" target="_blanc" rel="nofollow">/<?php the_author_meta('instagram'); ?></a>
               </div>
               <?php
               else:
               // do nothing
               endif; ?>
               <?php if(get_the_author_meta('twitter')):  ?>
               <div class="socialauthorbuttons">
                    <a href="https://twitter.com/#!/<?php the_author_meta('twitter'); ?>" class="twitter no-ext-icon" target="_blanc" rel="nofollow">Twitter</a>
                    <a href="https://twitter.com/#!/<?php the_author_meta('twitter'); ?>" class="no-ext-icon" target="_blanc" rel="nofollow">/<?php the_author_meta('twitter'); ?></a>
               </div>
               <?php
               else:
               // do nothing
               endif; ?>
               <?php if(get_the_author_meta('googleplus')):  ?>
               <div class="socialauthorbuttons">
                    <a href="https://plus.google.com/<?php the_author_meta('googleplus'); ?>" class="googleplus no-ext-icon" target="_blanc" rel="nofollow">Google+</a>
                    <a href="https://plus.google.com/<?php the_author_meta('googleplus'); ?>?rel=author" class="no-ext-icon" target="_blanc" rel="nofollow">/<?php the_author_meta('googleplus'); ?></a>
               </div>
               <?php
               else:
               // do nothing
               endif; ?>
               <div class="clear"></div>
           </div>

    <h2>Die neuesten Artikel von <?php echo $curauth->user_firstname; ?> <?php echo $curauth->user_lastname; ?> auf dem Blog des Experiment Selbstversorgung:</h2>

<?php	global $post;

	if( have_posts() ) {
		while( have_posts() ) {
			the_post();

			do_action( 'attitude_before_post' );
?>
	<section id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<article>

			<?php do_action( 'attitude_before_post_header' ); ?>

			<header class="entry-header">
    			<h2 class="entry-title">
    				<?php the_title(); ?>
    			</h2><!-- .entry-title -->
  			</header>

  			<?php do_action( 'attitude_after_post_header' ); ?>

  			<?php do_action( 'attitude_before_post_content' ); ?>

			<?php
			if( has_post_thumbnail() ) {
				$image = '';
	     		$title_attribute = apply_filters( 'the_title', get_the_title( $post->ID ) );
	     		$image .= '<figure class="post-featured-image">';
	  			$image .= '<a href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">';
	  			$image .= get_the_post_thumbnail( $post->ID, 'featured', array( 'title' => esc_attr( $title_attribute ), 'alt' => esc_attr( $title_attribute ) ) ).'</a>';
	  			$image .= '</figure>';

	  			echo $image;
	  		}
  			?>
  			<div class="entry-content clearfix">
    			<?php the_excerpt(); ?>
  			</div>

  			<?php do_action( 'attitude_after_post_content' ); ?>

  			<?php do_action( 'attitude_before_post_meta' ); ?>

  			<div class="entry-meta-bar clearfix">
    			<div class="entry-meta">
    				<span class="by-author"><?php _e( 'By', 'attitude' ); ?> <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php the_author(); ?></a></span> |
    				<span class="date"><a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( get_the_time() ); ?>"><?php the_time( get_option( 'date_format' ) ); ?></a></span> |
    				<?php if( has_category() ) { ?>
             		<span class="category"><?php the_category(', '); ?></span> |
             	<?php } ?>
    				<?php if ( comments_open() ) { ?>
             		<span class="comments"><?php comments_popup_link( __( 'No Comments', 'attitude' ), __( '1 Comment', 'attitude' ), __( '% Comments', 'attitude' ), '', __( 'Comments Off', 'attitude' ) ); ?></span> |
             	<?php } ?>
    			</div><!-- .entry-meta -->
    			<?php
    			echo '<a class="readmore" href="' . get_permalink() . '" title="'.the_title( '', '', false ).'">'.__( 'Read more', 'attitude' ).'</a>';
    			?>
    		</div>

    		<?php do_action( 'attitude_after_post_meta' ); ?>

		</article>
	</section>
<?php
			do_action( 'attitude_after_post' );

		}
	}
	else {
		?>
		<h1 class="entry-title"><?php _e( 'No Posts Found.', 'attitude' ); ?></h1>
      <?php
   } ?>
		</div><!-- #content -->
	</div><!-- #container -->

<?php
	/**
	 * attitude_after_main_container hook
	 */
	do_action( 'attitude_after_main_container' );
?>

<?php get_footer(); ?>
