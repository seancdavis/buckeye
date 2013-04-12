<?php

/* The CORE functions (this page needs to be commented)
------------------------------------------------------------------------ */
add_action( 'build_content', 'core_content_builder', 10, 2 );

function core_content_builder($page, $plugin = '') {
	
	get_header();
	if( is_front_page() ) {
		get_sidebar( 'front' );
	}
	else {
	 
		echo '<div id="container">';
		
		$post = $posts[0]; // Hack. Set $post so that the_date() works.
		/* If this is a category archive */ 
		if (is_category()) {
			echo '<h2>Archive for the ' . single_cat_title() . ' Category:</h2>'; 
		} 
		/* If this is a tag archive */ 
		elseif( is_tag() ) {
			echo '<h2>Posts Tagged &#8216;' . single_tag_title() . '&#8217;</h2>';
		} 
		/* If this is a daily archive */ 
		elseif (is_day()) {
			echo '<h2>Archive for ' . the_time('F jS, Y') . ':</h2>';
		} 
		/* If this is a monthly archive */
		elseif (is_month()) {
			echo '<h2>Archive for ' . the_time('F, Y') . ':</h2>';
		}
		/* If this is a yearly archive */
		elseif (is_year()) {
			echo '<h2>Archive for ' . the_time('Y') . ':</h2>';
		}
		/* If this is an author archive */ 
		elseif (is_author()) {
			echo '<h2>Author Archive</h2>';
		}
		/* If this is a paged archive */ 
		elseif (isset($_GET['paged']) && !empty($_GET['paged'])) {
			echo '<h2>Blog Archives</h2>';
		}		
		
		// builds correct content containers based on page layout
		global $post;
		$page_layout = get_post_meta($post->ID, '_page_layout', true);	
		if( $page_layout == '' ) $page_layout = 'Full-Width';
		switch($page_layout) {
			case 'Right Sidebar':
			echo '<div id="left-column">';
			do_action( 'build_loop', $page, $plugin );
			echo '</div>';
			get_sidebar();
			break;
			
			case 'Full-Width':
			echo '<div id="full-width-column">';
			do_action( 'build_loop', $page, $plugin );
			echo '</div>';
			break;
		} 	
	
		echo '</div>';
	
	}
	
	get_footer();
    
}

/* The LOOP
------------------------------------------------------------------------ */
add_action( 'build_loop', 'the_loop', 10, 2);

function the_loop($page, $plugin) {
	
	// Please note: there are lines in here specific to the wp-client plugin. They won't affect the core template.
	
	if(have_posts()) :
			
		while(have_posts()) : the_post(); ?>
			 
			<div class="post">
				<?php if( is_home() || is_category() || is_archive() ) : ?>
					<?php if( $plugin != 'wp-client' ) : ?>            		
						<a href="<?php the_permalink(); ?>">
							<h2 class="post-title"><?php the_title(); ?></h2>
						</a>
					<?php endif; ?>
				<?php endif; ?>
				<?php if( $page == 'clientspage' ) : ?><h2 class="post-title"><?php the_title(); ?></h2><?php endif; ?>
                
				<?php if( is_home() || is_single() ) : ?>
					<?php if( $plugin != 'wp-client' ) : ?>
                
                    <div class="post-metadata">
                    
                        <?php if( rt_get_chk_option( 'rt_blog_author' ) == 1 ) : ?><span class="post-author"><a href="<?php echo get_author_posts_url(get_the_author_meta( 'ID' )); ?>"><?php the_author_meta('display_name'); ?></a></span>&nbsp;&nbsp;&nbsp;<?php endif; ?>
                        
                        <?php if( rt_get_chk_option( 'rt_blog_date' ) == 1 ) : ?><span class="post-date"><?php echo get_the_date('n.j.y'); ?></span>&nbsp;&nbsp;&nbsp;<?php endif; ?>
                        
                        <?php if( rt_get_chk_option( 'rt_blog_comments' ) == 1 ) : ?><span class="post-comments"><?php comments_popup_link('No Comments', '1 Comment', '% Comments');?></span>&nbsp;&nbsp;&nbsp;<?php endif; ?>
                        
                        <span class="edit-post"><?php edit_post_link('Edit'); ?></span>
                        
                    </div>
                    
                    <hr class="post-separator">
					
                    <?php endif; ?>
				<?php endif; ?>
                 
                    <div class="content">   
                        
                        <?php 
							if( is_home() ) {
								the_post_thumbnail( 'blog-home-thumbnail', array('class' => 'blog-home-thumbnail'));
								$blog_view = rt_get_option( 'rt_blog_view' );
								if( $blog_view == 'the_excerpt' ) the_excerpt();
								else the_content();
							}
							elseif( is_page() || is_single() ) {
								the_content();
								if( is_page() ) { edit_post_link('Edit Page'); }
							}
						?>
                        
                    </div>
				
                <?php if( is_home() ) :
         
                    //echo '<a class="read-more-button" href="' . get_permalink() . '">Read More...</a>'; ?>
                    
                    <?php if( rt_get_chk_option( 'rt_blog_category' ) == 1 ) : ?><span class="post-category"><?php _e('Posted in&#58;'); ?><?php the_category(', ') ?></span>&nbsp;&nbsp;&nbsp;<?php endif; ?>
                    
                    <?php if( rt_get_chk_option( 'rt_blog_tags' ) == 1 ) : ?><span class="post-tags"><?php the_tags('Tagged with: ', ', '); ?></span><?php endif; ?>                   
                    
				<?php endif; ?>
				
			</div>
	
			<?php endwhile; ?>
            
            <?php if( is_home() ) : ?>			
            
                <div class="nav-page">
                    <?php posts_nav_link(); ?>
                </div>
                
			<?php endif; ?>
		 
		<?php endif;
	
}

/* Settings for the_excerpt()
-------------------------------------------------------------------------------- */
function new_excerpt_length($length) {
	return rt_get_option( 'rt_blog_excerpt_length' );
}
add_filter('excerpt_length', 'new_excerpt_length');

function new_excerpt_more($more) {
	global $post;
	return '&nbsp;&nbsp;<a href="' . get_permalink($post->ID) . '" >' . rt_get_option( 'rt_blog_readmore_text' ) . '</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

/* Feature Image
------------------------------------------------------------------------ */
add_action( 'feature_image', 'get_feature_image' );

function get_feature_image() {
	
	$url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
	
	echo '<div id="feature-image-container" style="background-image: url(' . $url . ' );" ></div>';    

}

/* Social Icons
------------------------------------------------------------------------ */
add_action( 'rt_display_social_icons', 'rt_display_social_icons' );

function rt_display_social_icons() {
	
	if( rt_get_option('rt_facebook') != '' ) { _e( '<a href="' . rt_get_option('rt_facebook') . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/facebook-24.png" /></a>' ); }
				if( rt_get_option('rt_twitter') != '' ) { _e( '<a href="' . rt_get_option('rt_twitter') . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/twitter-24.png" /></a>' ); }
				if( rt_get_option('rt_linkedin') != '' ) { _e( '<a href="' . rt_get_option('rt_linkedin') . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/linkedin-24.png" /></a>' ); }
				if( rt_get_option('rt_pinterest') != '' ) { _e( '<a href="' . rt_get_option('rt_pinterest') . '" target="_blank"><img src="' . get_template_directory_uri() . '/images/pinterest-24.png" /></a>' ); }
	
}

/* displays main menu as a dropdown list --- click directs you to that page.
------------------------------------------------------------------------ */
add_action( 'get_main_menu_as_dropdown', 'get_main_menu_as_dropdown' );

function get_main_menu_as_dropdown() {

            $menu_name = 'primary-menu';

            if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
            $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );

            $menu_items = wp_get_nav_menu_items($menu->term_id);

            $menu_list = '<select id="main-menu-small">';

            foreach ( (array) $menu_items as $key => $menu_item ) {
                $title = $menu_item->title;
                $url = $menu_item->url;
                $menu_list .= '<option value="' . $url . '">' . $title . '</option>';
            }
            $menu_list .= '</select>';
            } else {
            $menu_list = '<ul><li>Menu "' . $menu_name . '" not defined.</li></ul>';
            }            
            
            echo $menu_list;
	
}

?>