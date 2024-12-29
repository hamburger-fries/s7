<?php
/* Template Name: Portfolio Four Columns 2 */
get_header(); 
query_posts('post_type=portfolio&project-type='. query_categories() .'&posts_per_page=-1');
?>

<div class="inner"> 
	
    <?php include('includes/portfolio-filter.php');	?>
    
    <ul class="portfolio four-columns portfolio2">
    
    	<?php $count = 100; if (have_posts()) : while (have_posts()) : the_post(); ?>
       
        <li data-id="id-<?php echo $count++; ?>" class="<?php portfolio_class(); ?>"> 
            <div class="item-image"> 
                <div class="gallery clearfix" > 
                    <a href="<?php pp_enabled(href); ?>" <?php pp_enabled(rel); ?>><img src="<?php post_thumb(446, 314); ?>" alt></a>                        
                    <?php pp_images(); ?> 
                </div> 
            </div> 
                    
            <div class="item-name"> 
                <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            </div> 
        </li>
        
        <?php endwhile; endif; ?>
        
    </ul>

<?php get_footer(); ?>