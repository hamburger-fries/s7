<?php
/* Template Name: Page Left Sidebar */
get_header(); 
?>

<div class="inner custom_content">

	<div class="content content_right">
	
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
		<?php the_content(); ?>
                
    <?php endwhile; endif; ?> 
    
    </div><!-- .content End --> 
    <!-- Content End -->
               
	<?php include "templates/sidebar/sidebar-left.php"; ?>

<?php get_footer(); ?>
