<!-- Sidebar Start --> 
<div class="sidebar"> 
	<ul>
	<?php
	global $post;
	if(is_home()){
		$post_id = get_option('page_for_posts');
	}else{
		$post_id = $post->ID;
	}
	if(get_post_meta($post_id, 'page_sidebar', true) && get_post_meta($post_id, 'page_sidebar', true) != "Default"){
		if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar(get_post_meta($post_id, 'page_sidebar', true))) :
		endif;
	}elseif( is_page_template('template-contact.php') ) {
	   if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Contact Sidebar") ) :
	   endif;
	}elseif( is_archive() || is_search() || is_404()  ) {
	   if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Archives/Search Sidebar") ) :
	   endif;
	}elseif( is_home() && get_post_type() !== 'portfolio' || is_single() && get_post_type() !== 'portfolio' ) {
	   if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Blog Sidebar") ) :
	   endif;
	}elseif( is_page_template('template-page-right.php') || is_page_template('template-page-left.php')) {
	   if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar("Page Sidebar") ) :
	   endif;
	}
	?>                   
    </ul>
</div>
<!-- Sidebar End --> 

<div class="clear"></div>  