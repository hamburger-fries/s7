<?php
$post = $wp_query->post;
get_header();
//$template = get_option_tree('portfolio_post_template');


$template = get_post_meta($post->ID, 'projLayout', true);
if($template == "sidebar-left")	{ $layout = "content_right"; }
if($template == "fullwidth") {
	$width = 900;
	$height = 360;
}else{
	$width = 662;
}
?>
            
<div class="inner custom_content"> 
         
	<!-- Content Start --> 
	<?php if($template != "fullwidth") { ?>
	
	<div class="content <?php echo $layout; ?>">   
   	
	<?php }
	if (have_posts()) : while (have_posts()) : the_post(); 
	
		$youtube = get_post_meta($post->ID, 'video_youtube', true);
		$vimeo = get_post_meta($post->ID, 'video_vimeo', true);	
		$range = 1;	
		if(!$youtube && !$vimeo){
    
	    	$gallery_type = get_post_meta($post->ID, 'pp_gallery_type', true);	
	    	$animation = get_option_tree('slider_effect');
	    	if($animation != "fade" && $animation != "slide"){
	    		$animation = "fade";
	    	}
	    	if($gallery_type == "slider"){
	    	
		    	// = = = = = = = = = = = = =
		    	// =====  Slider      ======
		    	// = = = = = = = = = = = = =
		    	
	    		?>
	    		<script type="text/javascript">
	    		jQuery(window).load(function() {
	    			jQuery('#slider_<?php echo $post->ID?>').flexslider({
	    				animationSpeed: <?php echo get_option_tree('slider_speed'); ?>,
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
	    		    if(!get_post_meta($post->ID, 'pp_just_thumb', true)){
		    		    echo '<li><img src="'. crop_img(get_post_meta($post->ID, 'pp_image-1', true), $width, $height) .'" alt></li>';
		    		}
	    		    foreach (range(2, 10) as $v ){			
	    		    	if(get_post_meta($post->ID, 'pp_image-'.$v, true)) :
	    		    	echo '<li><img src="'. crop_img(get_post_meta($post->ID, 'pp_image-'.$v, true), $width, $height) .'" alt></li>';
	    		    	endif;	    		    
	    			} 
	    			
	    			?>
	    			</ul> 
	    		</div> 
	    		<?php 
	    	}elseif($gallery_type == "list"){
	    	
		    	// = = = = = = = = = = = = =
		    	// =====  Image List  ======
		    	// = = = = = = = = = = = = =
		    	
				echo '<div class="image-list">';
	    		
	    		if(!get_post_meta($post->ID, 'pp_just_thumb', true)){
	    		    echo '<img src="'. crop_img(get_post_meta($post->ID, 'pp_image-1', true), $width, $height) .'" alt>';
	    		}
	    		
	    		if(get_post_meta($post->ID, 'pp_image-2', true)){
	    			
	    			foreach (range(2, 10) as $v ){			
	    				if(get_post_meta($post->ID, 'pp_image-'.$v, true)) :
	    				echo '<img src="'. crop_img(get_post_meta($post->ID, 'pp_image-'.$v, true), $width, $height) .'" alt>';
	    				endif;
	    			}
	    			echo '</div>';
	    		}
	    	
	    	}else{
	    		
	    		// = = = = = = = = = = = = =
	    		// =====  Lightbox    ======
	    		// = = = = = = = = = = = = =
	    		
	    		if(get_post_meta($post->ID, 'pp_just_thumb', true)){
	    			$range = 2;
	    		}
	    		?>	    		
	    		<div class="gallery clearfix">
	    		
	    		<a <?php pp_link(); ?>><img src="<?php echo crop_img(get_post_meta($post->ID, 'pp_image-'.$range, true), $width, $height) ?>" alt></a>
	    		
	    		<?php
	    		
    			echo '<div class="hidden">';
    			foreach (range($range+1, 10) as $v ){			
    				if(get_post_meta($post->ID, 'pp_image-'.$v, true)) :
    				echo '<a href="'. get_post_meta($post->ID, 'pp_image-'.$v, true) .'" rel="gallery[gallery'. $post->ID .']" title="'.get_the_title($post->ID).'"></a>';
    				endif;
    			}
    			echo '</div>'; 		
	    		
	    		?>
	    		
	    		</div>
	    	<?php
	    	}
    
		}elseif($youtube && !$vimeo){ 				
			echo '<div class="video-container"><iframe src="http://www.youtube.com/embed/'.$youtube.'" frameborder="0" allowfullscreen></iframe></div>';				
		}elseif($vimeo){ 				
			echo '<div class="video-container"><iframe src="http://player.vimeo.com/video/'.$vimeo.'?title=0&amp;byline=0&amp;portrait=0&amp;color=ffffff" frameborder="0" webkitAllowFullScreen allowFullScreen></iframe></div>';				
		}
		
	endwhile; endif;
	
	if($template != "fullwidth") { ?>
	</div><!-- .content End --> 
	<!-- Content End -->
	
	    <!-- Sidebar Start --> 
	    <div class="sidebar <?php if($template == "sidebar-left") echo "sidebar_left"; ?>">
	    	<?php the_content(); ?>
	    </div>
	    <!-- Sidebar End --> 
    
    <div class="clear"></div> 
    
    <?php }else{ ?>
    
    <div class="portfolio-fullwidth-content">    
    	<?php the_content(); ?>
    </div>
    
    <?php } ?>
    
              
<?php
	get_footer(); 
?>