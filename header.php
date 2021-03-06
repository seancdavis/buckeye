<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />

<title>
	<?php if( is_front_page() ) { bloginfo( 'name' ); }
        else { wp_title('', true) . _e( ' | ' ) . bloginfo( 'name' ); } ?>    
</title>
 
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
 
<?php
	// Supports threaded comments     
    if ( is_singular() && get_option( 'thread_comments' ) )
		wp_enqueue_script( 'comment-reply' );
 
    wp_head();     
    wp_get_archives('type=monthly&format=link');
?>

<?php 

$header_font = rt_get_option( 'rt_header_font' );
$body_font = rt_get_option( 'rt_body_font' );

switch($header_font) {
	case 'Open Sans':
	echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Arvo':
	echo "<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Lato':
	echo "<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Vollkorn':
	echo "<link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Ubuntu':
	echo "<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>";
	break;
	
	case 'PT Sans':
	echo "<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Droid Sans':
	echo "<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>";
	break;
}

switch($body_font) {
	case 'Open Sans':
	echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Arvo':
	echo "<link href='http://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Lato':
	echo "<link href='http://fonts.googleapis.com/css?family=Lato' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Vollkorn':
	echo "<link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Ubuntu':
	echo "<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>";
	break;
	
	case 'PT Sans':
	echo "<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>";
	break;
	
	case 'Droid Sans':
	echo "<link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>";
	break;
}

?>

<style>
body {
	font-family: <?php print $body_font ?>, serif;
}

h1,h2,h3,h4,h5,h6 {
	font-family: <?php print $header_font; ?>, sans serif;
}	
</style>

<style><?php print rt_get_option('rt_css'); /* custom css */ ?></style>

</head>

<body>
 
<div id="wrapper">
    
    <div id="header" class="clearfix">
    
    	<div id="social-icons"><?php do_action( 'rt_display_social_icons' ); // library/content/content.php ?></div>
        
        <div id="logo">        	
            <h2><a href="<?php echo get_option('home'); ?>"><?php if( rt_get_option('rt_logo') != '' ) { echo '<img src="' . rt_get_option('rt_logo') . '" style="max-width: ' . rt_get_option('rt_logo_width') . 'px; max-height:' . rt_get_option('rt_logo_height') . 'px;" />'; }
				else { bloginfo('name'); } ?></a></h2>
       	</div>
        
  		<div id="main-menu" class="clearfix"><?php wp_nav_menu( array( 'sort_column' => 'menu_order', 'menu_class' => 'main-menu', 'theme_location' => 'primary-menu' ) ); ?></div>
		
        <div id="main-menu-small-container"><?php do_action( 'get_main_menu_as_dropdown' ); //library/content/content.php ?></div>
        
        <?php if( is_front_page() ) { do_action( 'display_feature' ); /* library/plugins/display-feature.php */ } 
		else if( is_single() || is_page() ) { if( has_post_thumbnail() ) { do_action( 'feature_image' ); /* library/content/content.php */ } } ?>
        
	</div>