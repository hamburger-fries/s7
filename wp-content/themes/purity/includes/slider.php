    <script type="text/javascript">	
	<?php
		$animation = get_option_tree('slider_effect');
		if($animation != "fade" && $animation != "slide"){
			$animation = "fade";
		}
	 ?>
    jQuery(window).load(function() {
    	jQuery('#slider').flexslider({
    		animationSpeed: <?php echo get_option_tree('slider_speed'); ?>,
    		slideshowSpeed: <?php echo get_option_tree('slider_pause'); ?>,
    		directionNav: <?php echo get_option_tree('slider_direction_nav'); ?>,
    		controlNav: true,
    		animation: '<?php echo $animation; ?>',
    		smoothHeight: true
    	});
    });
    </script>
    
    <div id="slider" class="flexslider">
    	<ul class="slides">
        <?php 
		$slides = get_option_tree( 'slider_slider', $option_tree, false, true, -1 );
		if($slides)
		foreach( $slides as $slide ) {
		  	echo '
				<li><a href="'.$slide['link'].'"><img src="'.crop_img($slide['image'],900,get_option_tree('slider_height')).'" title="'.$slide['description'].'" alt></a>';
			  
			if($slide['description']){
				echo '<p class="flex-caption">';
				echo '<span class="slide-caption">'.$slide['description'].'</span>';
				echo '</p>';
			}
			
			echo '</li>';
		}			
		?>
		</ul>
    </div>   
    
    <div class="divider line"></div>  