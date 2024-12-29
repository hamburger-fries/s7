<?php
/* Template Name: Page Right Sidebar */
get_header(); 
$post = $wp_query->post;
?>

<div class="inner custom_content"> 

	<div class="content">
	
    <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
		<?php the_content(); ?>
                
    <?php endwhile; endif; ?> 
    
    </div><!-- .content End --> 
    <!-- Content End -->
               
	<?php include "templates/sidebar/sidebar-right.php"; ?>

<?php get_footer(); ?>
