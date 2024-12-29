<?php

/*

Plugin Name: Google Maps
Plugin URI: http://themeforest.net/user/Tauris/
Description: Display a Google map.
Version: 1.0
Author: Tauris
Author URI: http://themeforest.net/user/Tauris/

*/


/* Add our function to the widgets_init hook. */
add_action( 'widgets_init', 'pr_widget_googlemaps' );

/* Function that registers our widget. */
function pr_widget_googlemaps() {
	register_widget( 'PR_Widget_Googlemaps' );
}

// Widget class.
class PR_Widget_Googlemaps extends WP_Widget {


	function PR_Widget_Googlemaps() {
		/* Widget settings. */
		$widget_ops = array( 'classname' => 'pr_widget_googlemaps', 'description' => 'Display a selected number of googlemaps images.' );

		/* Create the widget. */
		$this->WP_Widget( 'pr_widget_googlemaps', '(C) Google Maps', $widget_ops );
	}
	
	function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );
		$width = $instance['width'];
		$height = $instance['height'];
		$src = $instance['src'];

		/* Before widget (defined by themes). */
		echo $before_widget;

		/* Title of widget (before and after defined by themes). */
		if ( $title )
			echo $before_title . $title . $after_title;

		/* Display name from widget settings. */
		?>
        

        
        <iframe width="<?php echo $width ?>" height="<?php echo $height ?>" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="<?php echo $src ?>&amp;output=embed"></iframe>
        

        <?php

		/* After widget (defined by themes). */
		echo $after_widget;
	}
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (if needed) and update the widget settings. */
		$instance['title'] = strip_tags( $new_instance['title'] );
		$instance['width'] = strip_tags( $new_instance['width'] );
		$instance['height'] = strip_tags( $new_instance['height'] );
		$instance['src'] = strip_tags( $new_instance['src'] );		

		return $instance;
	}
	
	
	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'title' => 'Map', 'width' => '198', 'height' => '150', 'src' => 'http://maps.google.com/maps?q=warszawa&hl=en&sll=49.724479,42.802734&sspn=49.824548,135.263672&vpsrc=0&hnear=Warsaw,+Warszawa,+Masovian+Voivodeship,+Poland&t=m&z=11');
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
    	<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:</label>
		<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>  
        
        <p>
        <label for="<?php echo $this->get_field_id('width'); ?>">Width:</label>
		<input id="<?php echo $this->get_field_id('width'); ?>" name="<?php echo $this->get_field_name('width'); ?>" type="text" value="<?php echo $instance['width']; ?>" size="3" />
        </p>         
      
        <p>
        <label for="<?php echo $this->get_field_id('height'); ?>">Height:</label>
		<input id="<?php echo $this->get_field_id('height'); ?>" name="<?php echo $this->get_field_name('height'); ?>" type="text" value="<?php echo $instance['height']; ?>" size="3" />
        </p>
        
        <p>
        <label for="<?php echo $this->get_field_id('src'); ?>">URL:</label>
		<input id="<?php echo $this->get_field_id('src'); ?>" name="<?php echo $this->get_field_name('src'); ?>" type="text" value="<?php echo $instance['src']; ?>" style="width:100%;" />
        </p>
        
        
        <?php
	}
}