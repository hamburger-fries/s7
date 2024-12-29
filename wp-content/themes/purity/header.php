<!DOCTYPE html> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    
	<link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen">    
   
    <?php if((get_option_tree('theme_skin')) !== "Light") {	?>
    <link rel="stylesheet" href="<?php bloginfo('template_directory'); ?>/css/skins/<?php echo get_option_tree( 'theme_skin' ); ?>.css" type="text/css" media="screen">  
    <?php }	?>
    
    <!--[if IE 7]>
    <link rel="stylesheet" media="screen" href="<?php bloginfo('template_directory'); ?>/css/ie7.css"/>
  	<![endif]-->
    
    <link rel="shortcut icon" href="<?php echo get_option_tree('custom_favicon'); ?>" />
    
    <link rel="alternate" type="application/rss+xml" title="<?php bloginfo('name'); ?> RSS Feed" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="<?php bloginfo('name'); ?> Atom Feed" href="<?php bloginfo('atom_url'); ?>" />
    
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    <?php wp_head(); ?>
    
</head> 
 
<body <?php body_class($class); ?>>
	<div id="wrapper">  
    
    	<!-- HEADER START --> 
		<div id="header"> 
        	<div class="inner">
            	<div class="logo"> 
                	
					<a href="<?php echo home_url(); ?>" class="logo_img">
					<img class="website-logo" src="<?php echo get_option_tree('logo_image');	?>" alt="<?php bloginfo('name'); ?>">
					<?php 
					if(!get_option_tree('theme_retina') && get_option_tree('retina_logo')){
						echo '<img class="retina-logo" width="'.get_option_tree('retina_logo_width').'px" src="'.get_option_tree('retina_logo').'" alt>';
					}
					?>
					</a>
					
                </div> 
            
            	<div class="nav"> 
                    <ul> 
                    	<?php wp_nav_menu(array('menu' => 'custom_menu')); ?>
                    </ul>
                    <?php responsive_select_nav() ?>  
            	</div>  
                
                <div class="clear"></div>           
            </div><!-- .inner end --> 
        </div><!-- #header end --> 
        <!-- HEADER END -->      	
                
        <!-- MAIN CONTENT START --> 
        <div id="main"> 
        
        