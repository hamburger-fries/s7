<?php
/*
Template Name: Homepage
*/

get_header(); ?>

<div class="inner"> 
                        
    
	<?php 
	if(get_option_tree('slider_enable'))
	{	
		include 'includes/slider.php'; 
	}
	
	$homepage_cc = get_option_tree('homepage_cc');
	
	if($homepage_cc)
	{
		echo $homepage_cc;
	}	
	?>    
   
    <?php homepage_tagline(); ?>
    
    <?php if(get_option_tree('recent_work')){  ?>
    <div id="recent-work" class="home-section"> 
        <h3><?php tr_translate('recent_work_title'); ?></h3>  
        <?php $count = strtolower((str_replace (" ", "", get_option_tree('recent_work_st'))));
			if($count == "fourcolumns"){
				$query_count = 4;
			}else{
				$query_count = 3;
			}
		?>
        <ul class="<?php echo $count; ?> home-list">
        
			<?php query_posts('post_type=portfolio&posts_per_page='.$query_count); if (have_posts()) : while (have_posts()) : the_post();	?>                    
            <li>
        		<div class="gallery clearfix">  
                        <a href="<?php pp_enabled(href); ?>" <?php pp_enabled(rel); ?> class="over">
                            <span><?php the_title(); ?></span>
                            <p><?php portfolio_desc_limited(); ?></p>
                        </a> 
                        <a href="<?php the_permalink(); ?>"><img src="<?php post_thumb(446, 314); ?>" alt>   </a> 
                        <?php pp_images(); ?>
        		</div>        		
            </li>
            <?php endwhile; endif; wp_reset_query(); ?>                     
            
        </ul>
        
        <div class="clear"></div>
        <a href="<?php echo "?page_id=".get_option_tree('portfolio_page'); ?>" class="goto"><?php  tr_translate('recent_work_view'); ?></a>
    </div>  
    <?php } ?> 
    
    
    
    <?php if(get_option_tree('recent_posts')){  ?>
    <div class="divider line"></div> 
    
    <div id="recent-posts" class="home-section"> 
        <h3><?php tr_translate('recent_posts_title'); ?></h3>          
        <?php $count = strtolower((str_replace (" ", "", get_option_tree('recent_posts_st'))));
			if($count == "fourcolumns"){
				$query_count = 4;
			}else{
				$query_count = 3;
			}
		?>
        <ul class="<?php echo $count; ?> home-list">
        
			<?php query_posts('posts_per_page='.$query_count); if (have_posts()) : while (have_posts()) : the_post();	?>
            <li>
            	<?php if(get_post_meta($post->ID, 'pp_image-1', true) && get_option_tree('recent_posts_thumbs')){ ?>
        		<div class="recent-posts-thumb">
            		<a href="<?php the_permalink() ?>">
            			<img src="<?php echo crop_img(get_post_meta($post->ID, 'pp_image-1',true), 446, 280) ?>" alt="<?php the_title(); ?>">
            		</a>
        		</div>
            	<?php } ?>
                <h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5> 
                <span class="post-info"><?php tr_translate(by); ?> <?php the_author_posts_link(); ?> <?php tr_translate(on); ?> <?php the_time('M d, Y'); ?></span>
                <?php the_excerpt(); ?>
            </li>
            <?php endwhile; endif; wp_reset_query(); ?>                    
            
        </ul>
        
        <div class="clear"></div>
        <a href="<?php blog_url(); ?>" class="goto"><?php tr_translate('recent_posts_view'); ?></a>
    </div>
    <?php } ?>     
 
    
    <!--Begin Homepage Content-->
    <?php wp_reset_query(); if (have_posts()) : while (have_posts()) : the_post(); ?>
    
    	<?php if(get_the_content()) echo '<div class="divider line"></div>'; ?>
        <?php the_content(); ?>
              
    <?php endwhile; endif; ?>
    <!--End Homepage Content-->
    
                
<?php get_footer(); ?>