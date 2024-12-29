<?php

//
// Purity Theme Functions
//
// Author: Tauris
// URL: http://themeforest.net/user/Tauris/
//


//
// Custom menu
//

add_action('init', 'register_custom_menu');
 
function register_custom_menu() {
register_nav_menu('custom_menu', __('Custom Menu'));
}

// Responsive version

function responsive_select_nav() {
	
	$locations = get_nav_menu_locations();
	$menu = wp_get_nav_menu_object( $locations[ 'custom_menu' ] );
	
	$items = wp_get_nav_menu_items($menu->term_id);
	global $of_option;
	$prefix = "st_"; 
	if($of_option[$prefix.'translate']){	
		$tr_select_page = $of_option[$prefix.'tr_select_page'];
	}else{			
		$tr_select_page = __('Select page:', 'spacing');	
	}
	echo "<select id='page_id' name='page_id'>";
	echo "<option>".$tr_select_page."</option>";
	   foreach ($items as $list){
			  if($list->menu_item_parent != "0"){
			  echo "<option value=".$list->url.">&nbsp; &nbsp;".$list->title."</option>";
			  }
			  else {
			  echo "<option value=".$list->url.">".$list->title."</option>";
			  }
	
	   }
	echo "</select>";
}

//
// Register Sidebars
//

if ( function_exists('register_sidebar') ) {
	register_sidebar(array(
        'name' => 'Blog Sidebar',
        'before_widget' => '<div class="sidebar_item">',
        'after_widget' => '</div>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
	register_sidebar(array(
        'name' => 'Page Sidebar',
        'before_widget' => '<div class="sidebar_item">',
        'after_widget' => '</div>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
	register_sidebar(array(
        'name' => 'Contact Sidebar',
        'before_widget' => '<div class="sidebar_item">',
        'after_widget' => '</div>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
	register_sidebar(array(
        'name' => 'Archives/Search Sidebar',
        'before_widget' => '<div class="sidebar_item">',
        'after_widget' => '</div>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
    register_sidebar(array(
        'name' => 'Footer Widgets Area',
        'before_widget' => '<li>',
        'after_widget' => '</li>',
        'before_title' => '<h5>',
        'after_title' => '</h5>',
    ));
        
    $sidebars = get_option( 'sidebarmanager_options');  
    
    	if(isset($sidebars['custom_sidebar']) && sizeof($sidebars['custom_sidebar']) > 0)  
    	{  
    		foreach($sidebars['custom_sidebar'] as $sidebar)  
    		{  
    			register_sidebar( array(  
    				'name' => $sidebar,
    				'before_widget' => '<li>',  
    				'after_widget' => '</li>',
    				'before_title' => '<h5>',
    				'after_title' => '</h5>',
    			) );  
    		}  
    	}
	
}

//
// Large image size
//

if ( function_exists( 'add_theme_support' ) ) {
	add_theme_support( 'post-thumbnails' );
	add_image_size( 'large', 662, '', true );
}

//
// Scripts and Styles
//

function ts_custom() {
	if (!is_admin()) {
		wp_register_script('jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/jquery-ui.min.js', array('jquery'));
		
		wp_register_script('custom', get_template_directory_uri() . '/js/custom.js', array('jquery'));	
		wp_register_script('contact-form', get_template_directory_uri() . '/js/contact-form.js', array('jquery'));		
		wp_register_script('flexslider', get_template_directory_uri() . '/js/jquery.flexslider-min.js', array('jquery'));
		wp_register_script('prettyphoto', get_template_directory_uri() . '/js/jquery.prettyPhoto.js', array('jquery'));
		wp_register_script('quicksand', get_template_directory_uri() . '/js/jquery.quicksand.min.js', array('jquery'));
		wp_register_script('portfolio-height', get_template_directory_uri() . '/js/portfolio-height.js', array('jquery'));	
		wp_register_script('easing', get_template_directory_uri() . '/js/jquery.easing.js', array('jquery'));		
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui');
		wp_enqueue_script('contact-form');		
		wp_enqueue_script('custom');
		wp_enqueue_script('easing');
		wp_enqueue_script('prettyphoto');
		wp_enqueue_script('flexslider');
		
		wp_register_style('style-dynamic', get_template_directory_uri() . '/css/style-dynamic.php');
		wp_register_style('custom', get_template_directory_uri() . '/css/custom.css');
		wp_register_style('responsive', get_template_directory_uri() . '/css/responsive.css');
		wp_register_style('retina', get_template_directory_uri() . '/css/retina.css');
		wp_register_style('prettyphoto', get_template_directory_uri() . '/css/scripts/prettyPhoto.css');	
		wp_register_style('flexslider', get_template_directory_uri() . '/css/scripts/flexslider.css');	
		
		wp_enqueue_style('style-dynamic');
		wp_enqueue_style('custom');					
		wp_enqueue_style('prettyphoto');
		wp_enqueue_style('flexslider');	
		
		if(!get_option_tree('theme_responsive')) wp_enqueue_style('responsive');
		if(!get_option_tree('theme_retina')) wp_enqueue_style('retina');
		
		// Google Font
		
		if(get_option_tree('font_heading') && get_option_tree('font_heading') != "League Gothic"){
			wp_register_style('google-font-heading', 'http://fonts.googleapis.com/css?family='.str_replace('+','',get_option_tree('font_heading')));
			wp_enqueue_style('google-font-heading');
		}
		
		if(get_option_tree('font_body') && get_option_tree('font_body') != "Helvetica/Arial"){
			wp_register_style('google-font-body', 'http://fonts.googleapis.com/css?family='.str_replace('+','',get_option_tree('font_body')));
			wp_enqueue_style('google-font-body');
		}	

	}
}
add_action('init', 'ts_custom');

// Comments Script

function ts_comments() {
	if(is_singular() || is_page())
	wp_enqueue_script( 'comment-reply' );
}
add_action('wp_print_scripts', 'ts_comments');

// Portfolio Scripts

function ts_portfolio() {
	if (is_page_template('template-portfolio.php') ||
	is_page_template('template-portfolio-one-1.php') ||
	is_page_template('template-portfolio-one-2.php') ||
	is_page_template('template-portfolio-one-3.php') ||
	is_page_template('template-portfolio-two-1.php') ||
	is_page_template('template-portfolio-two-2.php') ||
	is_page_template('template-portfolio-two-3.php') ||
	is_page_template('template-portfolio-three-2.php') ||
	is_page_template('template-portfolio-three-3.php') ||
	is_page_template('template-portfolio-four-1.php') ||
	is_page_template('template-portfolio-four-2.php') ||
	is_page_template('template-portfolio-four-3.php')
	){	
	wp_enqueue_script('quicksand'); 
	}
	
	if(is_page_template('template-portfolio-three-3.php') ||
	is_page_template('template-portfolio-two-3.php') ||
	is_page_template('template-portfolio-four-3.php')
	){
	wp_enqueue_script('portfolio-height');
	}
}
add_action('wp_print_scripts', 'ts_portfolio');

// Homepage Styles

function css_home() {	
	if (is_page_template('template-home.php') )
	wp_enqueue_style('nivoslider');	
}
add_action('wp_print_styles', 'css_home');

//
// Comments Layout
//

function ts_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; ?>
   
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
	<div id="comment-<?php comment_ID(); ?>">
    
		<div class="avatar-holder"> 
            <?php echo get_avatar($comment,$size='48'); ?>
        </div>
        
        <div class="comment-entry"> 
            <span> 
            	<?php printf(__('<strong>%s</strong>'), get_comment_author_link()) ?> on <?php  echo get_comment_date('M d, Y'); ?> 
				<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth'],reply_text => get_option_tree('tr_reply')))) ?><?php edit_comment_link(__(' | Edit'),'  ','') ?>
            </span> 
            <?php if ($comment->comment_approved == '0') : ?>
         <em><?php _e('Your comment is awaiting moderation.') ?></em>
         <br />
		<?php endif; ?>
        
        <?php comment_text() ?>       
            
        </div>


<?php
}

//
// Blog Functions
//

require_once('functions/blog-metaboxes.php'); 

function blog_url(){

	echo get_permalink(get_option('page_for_posts')); 
	
}

//
// Global Template
//

function global_template($action){
	$global_template = get_option_tree('global_template');
	
	if($global_template !== "Right Sidebar"){	
		switch ($action) {
			case 'content':
			echo "content_right";
		break;
			case 'sidebar':
			include 'templates/sidebar/sidebar-left.php';
		}
	}else {
		switch ($action){
			case 'sidebar':
			include 'templates/sidebar/sidebar-right.php';
		}
	}
}

//
// Custom Functions
//

function page_title($type){	
	
	global $post;
	
	switch ($type) {
		case 'title':
		echo get_the_title($post->ID);
	break;
		case 'tagline':
		$tagline = get_post_meta($post->ID, 'page-tagline', true);
		if($tagline){
			echo "<span>". $tagline . "</span>";
		}
	break;	
		case 'blog_title':
		$frontpage_id = get_option('page_for_posts');
		echo get_the_title($frontpage_id);
	break;
		case 'blog_tagline':
		$frontpage_id = get_option('page_for_posts');
		echo "<span>". get_post_meta($frontpage_id, 'page-tagline', true) . "</span>";
	break;
	}
}

function homepage_tagline(){

	if(get_option_tree('homepage_tagline_enable'))
	{?>
	  
	<div class="home_tagline"> 
		<h1>
		<?php
		  echo get_option_tree('homepage_tagline' );
		?>                  
		</h1> 
	</div>     
	<div class="divider line"></div> 
    
    <?php
	}
	
}

function new_excerpt_length($length) {
	return 12;
}
function new_excerpt_more($more) {
	return '...';
}
add_filter('excerpt_more', 'new_excerpt_more');
add_filter('excerpt_length', 'new_excerpt_length');

function limited_content(){
	global $post;
	$content = get_the_content($post->ID);
	echo substr($content, 0, 90)."...";
}

function tr_translate($phrase){
	echo get_option_tree('tr_'.$phrase);
}

//
// Portfolio Functions
//

require_once('functions/portfolio-manager.php'); 

function portfolio_cats(){
	global $post;
    $terms = wp_get_object_terms($post->ID, "project-type");
	foreach ( $terms as $term ) {
		echo '<li><a href="" title="'. $term->slug .'">' . $term->name . "</a></li>";	   
	}	
}


function query_categories(){
	global $post;
	    
	$terms = wp_get_object_terms($post->ID, "project-type");	
	
	$obj = new stdClass;
	
	foreach ( $terms as $term ) {
		$slug = $term->slug;
		$obj->$slug = $slug;  
	}
		
	$array = (array) $obj;
	$text = implode(',', $array );
	
	return $text;
	
}

function portfolio_term(){
	
	$terms = wp_get_object_terms(the_ID, 'project-type');
     foreach ( $terms as $term ) {
		$term = $term->name;
		$term = strtolower($term);
       echo '' . $term . "";
        
     }	
}

function portfolio_class(){
	global $post;
    $terms = wp_get_object_terms($post->ID, "project-type");
	foreach ( $terms as $term ) {
		echo $term->slug . " ";	   
	}	
	
}

function portfolio_desc(){
	
	foreach (get_post_custom_values('projDesc') as $value){ 
		echo $value; 
	}
	
}

function portfolio_desc_limited(){
	
	foreach (get_post_custom_values('projDesc') as $value){ 
		$value = substr($value, 0, 110)."...";	
		echo $value;
	}
	
}

function crop_img($url, $width, $height = NULL){

	require_once('includes/aq_resizer.php');
	return aq_resize($url,$width,$height,true);
	
}

function post_thumb($width, $height, $url = NULL){
	
	global $post;
	$thumb = get_post_meta($post->ID, 'pp_image-1', true);
	require_once('includes/aq_resizer.php');
	echo aq_resize($thumb,$width,$height,true);
		
}

function pp_enabled($action){
	
	global $post;	
	$gallery_type = get_post_meta($post->ID, 'pp_gallery_type', true);	
	
	if($action == "href"){
		if($gallery_type == "lightbox" || !$gallery_type){ 
			echo the_permalink($post->ID);
		}elseif($gallery_type == "slider" && !is_single()){
			echo the_permalink($post->ID);
		}elseif($gallery_type == "list"){
			echo the_permalink($post->ID);
		}else{ // Direct lightbox
			$youtube = get_post_meta($post->ID, 'video_youtube', true);
			$vimeo = get_post_meta($post->ID, 'video_vimeo', true);
			if($youtube || $vimeo){
				$size = '&width='.get_post_meta($post->ID, 'vlightbox_width', true).'&height='.get_post_meta($post->ID, 'vlightbox_height', true);
			}
			if(!$youtube && !$vimeo){
				$image_name = 'pp_image-1';
				if(get_post_meta($post->ID, 'pp_just_thumb', true)){
					$image_name = 'pp_image-2';
				}
				echo get_post_meta($post->ID, $image_name, true);
			}elseif($youtube && !$vimeo){
				echo 'http://www.youtube.com/watch?v='.$youtube.$size;
			}else{
				echo 'http://vimeo.com/'.$vimeo.$size;
			}			
		}
	}elseif($action == "rel"){
		if($gallery_type == "direct"){
			echo 'rel="gallery[gallery'. $post->ID .']" title="'.get_the_title($post->ID).'"';
		}
	}
}

function pp_enabled_images(){

	global $post;	
	$gallery_type = get_post_meta($post->ID, 'pp_gallery_type', true);
	
	if($gallery_type == "direct" || !$gallery_type){		
		echo '<div class="hidden">';
			if(!get_post_meta($post->ID, 'pp_just_thumb', true)){
			    //echo '<a href="'. get_post_meta($post->ID, 'pp_image-2', true) .'" rel="gallery[gallery'. $post->ID .']" title="'.get_the_title($post->ID).'"></a>';
			}
		foreach (range(3, 10) as $v ){			
			if(get_post_meta($post->ID, 'pp_image-'.$v, true)) :
			echo '<a href="'. get_post_meta($post->ID, 'pp_image-'.$v, true) .'" rel="gallery[gallery'. $post->ID .']" title="'.get_the_title($post->ID).'"></a>';
			endif;
		}
		echo '</div>';
	}
				
}

function pp_images(){

	global $post;	
	$gallery_type = get_post_meta($post->ID, 'pp_gallery_type', true);
	
	if(get_post_meta($post->ID, 'pp_image-2', true) && $gallery_type == "direct" || get_post_meta($post->ID, 'pp_image-2', true) && !$gallery_type){
		echo '<div class="hidden">';
		if(!get_post_meta($post->ID, 'pp_just_thumb', true)){
		    echo '<a href="'. get_post_meta($post->ID, 'pp_image-2', true) .'" rel="gallery[gallery'. $post->ID .']" title="'.get_the_title($post->ID).'"></a>';
		}
		foreach (range(3, 10) as $v ){			
			if(get_post_meta($post->ID, 'pp_image-'.$v, true)) :
			echo '<a href="'. get_post_meta($post->ID, 'pp_image-'.$v, true) .'" rel="gallery[gallery'. $post->ID .']" title="'.get_the_title($post->ID).'"></a>';
			endif;
		}
		echo '</div>';
	}
				
}

function pp_link(){

	global $post;
	
	$range = 1;
	
	if(get_post_meta($post->ID, 'pp_just_thumb', true)){
		$range = 2;
	}
	
	echo 'href="'.get_post_meta($post->ID, 'pp_image-'.$range, true).'" rel="gallery[gallery'.$post->ID.']" title="'.get_the_title($post->ID).'"';
	
}

function post_tags(){

	$posttags = get_the_tags();
	if ($posttags) {
		echo "<p><span>".get_option_tree(tr_tags)."</span>";	
		foreach($posttags as $tag) {	
		  echo '<a href="'. get_tag_link($tag->term_id) .'">'; 
		  echo $tag->name.' ';	 
		  echo "</a>";
		}
  	echo "</p>";
	}	
}

function blog_index_gallery($layout){

	global $post;
	$gallery_type = get_post_meta($post->ID, 'pp_gallery_type', true);	
	
	if($layout == 1){
		$width = 662;
		$height = 220;
	}elseif($layout == 2){
		$width = 494;
		$height = 200;
	}else{
		$width = 460;
		$height = 290;
	}
	$range = 1;
	if($gallery_type == "slider" && $layout != 3){
	
		// = = = = = = = = = = = = =
		// =====  Slider      ======
		// = = = = = = = = = = = = =
		
		?>
		<script type="text/javascript">
		jQuery(window).load(function() {
			jQuery('#slider_<?php echo $post->ID?>').flexslider({
				animationDuration: <?php echo get_option_tree('slider_speed'); ?>,
				slideshowSpeed: <?php echo get_option_tree('slider_pause'); ?>,
				directionNav: <?php echo get_option_tree('slider_direction_nav'); ?>,
				controlNav: true,
				animation: '<?php echo $animation; ?>',
				smoothHeight: true
			});
		});
		</script>
			    		
		<div id="slider_<?php echo $post->ID?>" class="flexslider">
		    <ul class="slides">
		    <?php 
		    foreach (range(1, 10) as $v ){			
		    	if(get_post_meta($post->ID, 'pp_image-'.$v, true)) :
		    	echo '<li><img src="'. crop_img(get_post_meta($post->ID, 'pp_image-'.$v, true), $width, $height) .'" alt></li>';
		    	endif;	    		    
			} 
			
			?>
			</ul> 
		</div>

		<?php 
	}elseif($gallery_type == "direct"){
		
		// = = = = = = = = = = = = =
		// =====  Lightbox    ======
		// = = = = = = = = = = = = =
		
		?>	    		
		<div class="gallery clearfix">
		
		<a <?php pp_link(); ?>><img src="<?php echo crop_img(get_post_meta($post->ID, 'pp_image-1',true), $width, $height) ?>" alt></a>
		
		<?php
		if(get_post_meta($post->ID, 'pp_image-2', true)){
			echo '<div class="hidden">';
			foreach (range(2, 10) as $v ){			
				if(get_post_meta($post->ID, 'pp_image-'.$v, true)) :
				echo '<a href="'. get_post_meta($post->ID, 'pp_image-'.$v, true) .'" rel="gallery[gallery'. $post->ID .']" title="'.get_the_title($post->ID).'"></a>';
				endif;
			}
			echo '</div>'; 		
		}
		?>
		
		</div>
	<?php 
	}else{
	?>	
	<div class="post-image">
		<a href="<?php the_permalink(); ?>"><img src="<?php echo crop_img(get_post_meta($post->ID, 'pp_image-1',true), $width, $height) ?>" alt></a>
	</div>
	<?php
	}
	
}

//
// Tracking Code
//

if ( function_exists('tracking_code') ) {
  add_action('wp_footer', 'tracking_code');
}

function tracking_code(){
	echo get_option_tree('pr_tracking');
}

//
// Dashboard Functions
//

function my_admin_scripts() {
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	wp_register_script('my-upload', get_template_directory_uri() . '/admin/assets/js/jquery.upload.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_script('my-upload');
}

function my_admin_styles() {
	wp_enqueue_style('thickbox');
	wp_register_style('admin-styles', get_template_directory_uri() . '/admin/assets/css/admin-styles.css');
	wp_enqueue_style('admin-styles');
}

if(is_admin()) {
	add_action('admin_print_scripts', 'my_admin_scripts');
	add_action('admin_print_styles', 'my_admin_styles');
	include TEMPLATEPATH . '/functions/tinymce/tinymce.php';
}

require TEMPLATEPATH . '/admin/index.php';

//
// Widgets
//

include TEMPLATEPATH . '/functions/widget-blogpost.php';
include TEMPLATEPATH . '/functions/widget-portfoliopost.php';
include TEMPLATEPATH . '/functions/widget-flickr.php';
include TEMPLATEPATH . '/functions/widget-googlemaps.php';
include TEMPLATEPATH . '/functions/widget-vimeo.php';
include TEMPLATEPATH . '/functions/widget-youtube.php';

//
// Shortcodes
//

include TEMPLATEPATH . '/functions/purity-shortcodes.php';  

add_filter('the_content', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');

//
// Sidebar Manager
//

require TEMPLATEPATH . '/functions/sidebar-manager.php';