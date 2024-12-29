<?php
/* Template Name: Portfolio One Column 1 */
get_header(); 		
query_posts('post_type=portfolio&project-type='. query_categories() .'&posts_per_page=-1');
?>

<div class="inner"> 
	
    <?php include('includes/portfolio-filter.php');	?>
    
    <ul class="portfolio one-column detailed">
    
    	<?php $count = 100; if (have_posts()) : while (have_posts()) : the_post(); ?>
       
        <li data-id="id-<?php echo $count++; ?>" class="<?php portfolio_class(); ?>"> 
            <div class="item-image"> 
                <div class="gallery clearfix">
                <a href="<?php pp_enabled(href); ?>" <?php pp_enabled(rel); ?>><img src="<?php post_thumb(600, 260); ?>" alt></a> 
                <?php pp_images(); ?>                                    
                </div> 
            </div>                       
            
            <div class="item-name"> 
                <h3 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                <p><?php portfolio_desc(); ?></p>
                <a href="<?php the_permalink(); ?>"><?php tr_translate(read_more); ?> →</a> 
            </div> 
        </li>
        
        <?php endwhile; endif; ?>
        
    </ul>

<?php get_footer(); ?>