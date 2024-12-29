<?php
$post = $wp_query->post;
get_header();

// Thumbnail Height

$height = '280'; // Leave '' blank for auto height

?>
            
<div class="inner custom_content"> 
         
	<!-- Content Start --> 
	<div class="content <?php global_template(content); ?>">  
          
	<?php if (have_posts()) : while (have_posts()) : the_post(); 
    	
    	$gallery_type = get_post_meta($post->ID, 'pp_gallery_type', true);	
    	$range = 1;
    	$width = 662;
    	if($gallery_type == "slider"){
    	
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
    		if(get_post_meta($post->ID, 'pp_image-2', true)){
	    		echo '<div class="hidden">';
	    		foreach (range($range+1, 10) as $v ){			
	    			if(get_post_meta($post->ID, 'pp_image-'.$v, true)) :
	    			echo '<a href="'. get_post_meta($post->ID, 'pp_image-'.$v, true) .'" rel="gallery[gallery'. $post->ID .']" title="'.get_the_title($post->ID).'"></a>';
	    			endif;
	    		}
	    		echo '</div>';
    		}
    		?>
    		
    		</div>
    	<?php } ?>
    	
        <h1><?php the_title(); ?></h1> 
        <span class="post-meta"><?php tr_translate(posted_by); ?> <strong><?php the_author_posts_link(); ?></strong> <?php tr_translate(on); ?> <strong><?php the_time('M d, Y'); ?></strong> <?php tr_translate(posted_in); ?> <strong><?php the_category(', '); ?></strong></span> 
        <?php the_content(); ?>			
                   
        <?php comments_template(); ?>
    <?php endwhile; endif; ?>

	</div><!-- .content End --> 
	<!-- Content End -->

	<?php global_template(sidebar); ?>
                   
<?php
get_footer(); 
?>
