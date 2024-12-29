<?php
/*
Template Name: Full width
*/

get_header(); 
?>
           
<div class="inner custom_content"> 
                            
<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
	<?php the_content(); ?>
    
    <div class="divider"></div>
			
<?php endwhile; endif; ?>

                
<?php get_footer(); ?>