<?php
/* Template Name: Portfolio Four Columns 1 */
get_header(); 
query_posts('post_type=portfolio&project-type='. query_categories() .'&posts_per_page=-1');
?>

<div class="inner"> 
	
    <?php include('includes/portfolio-filter.php');	?>
    
    <ul class="portfolio four-columns portfolio1">
    
    	<?php $count = 100; if (have_posts()) : while (have_posts()) : the_post(); ?>        
       
        <li data-id="id-<?php echo $count++; ?>" class="<?php portfolio_class(); ?>" > 
        	<div class="gallery clearfix">    
                <div class="item-image"> 
                    <a href="<?php pp_enabled(href); ?>" <?php pp_enabled(rel); ?> class="over">
                        <span><?php the_title(); ?></span>
                        <p><?php portfolio_desc_limited(); ?></p>
                    </a> 
                    <img src="<?php post_thumb(446, 314); ?>" alt> 
                    <?php pp_images(); ?>
                </div> 
            </div>
        </li>
        
        <?php endwhile; endif; ?>
        
    </ul>

<?php get_footer(); ?>