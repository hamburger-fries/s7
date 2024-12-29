<?php get_header(); ?>

<div class="inner custom_content"> 

	<div class="content">
	
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
		<?php the_content(); ?>
                
    <?php endwhile; endif; ?> 
    
    </div>
    <!-- Content End -->
               
	<?php include "templates/sidebar/sidebar-right.php"; ?>

<?php get_footer(); ?>